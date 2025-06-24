<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Models\Role;
use App\Models\Master\Profile\Profile;
use App\Models\Master\Profile\ProfileTransactionSetting;

use App\Mail\CustomerRegistered;

class CustomerController extends Controller
{
    private $errorMessages = [];

    private function _userObject($user)
    {
        // create presentation
        $profile = $user->profile()
            ->first();
            
        $user = $user->toArray();

        $result = array_merge(
            $user,
            $profile->toArray(),
            [
                'id' => $profile->id,
                'phone' => $profile->phone, // PASTIKAN PHONE MUNCUL DI RESPONSE
                'image_url' => $profile->image ? asset('storage/' . $profile->image) : null
            ]
        );

        return $result;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::all(), 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'unique:users,email', 'email'],
            'name' => ['required'],
            'phone' => ['required', 'unique:profiles,phone', 'numeric', 'digits_between:7,12'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            $errorMessages = [];
            foreach ($validator->errors()->get('*') as $key => $value) {
                $errorMessages[$key] = implode(', ', $value);
            }
            return response()->json(['message' => $errorMessages], 400);
        }

        try {
            DB::beginTransaction();

            $roleAsCustomer = 2;

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'notification_channel_id' => $request->notification_channel_id,
                'token_api' => Str::random(60),
                'token_email_verification' => Str::random(12),
                'role_id' => 2,
            ]);

            $profile = $user->profile()->create([
                'name' => $user->name,
                'phone' => $request->phone, // SIMPAN PHONE NUMBER
                'is_active' => true
            ]);

            DB::commit();

            // RETURN DENGAN PHONE NUMBER
            return response()->json($this->_userObject($user), 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function verificationEmail($verification_code)
    {
        if (!Empty($verification_code)) {
            $user = User::where('token_email_verification', $verification_code)
            ->whereNull('email_verified_at')
            ->first();

            if (!empty($user)) {
                $user->email_verified_at = date('Y-m-d H:i:s');
                $user->save();

                $response = [
                    'type' => 'success',
                    'message' => 'vefikasi email berhasil, silahkan login pada aplikasi!'
                ];

                return view('auth.verify-message-1', $response);
            }

            abort(404);
        }

        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // PASTIKAN PHONE NUMBER MUNCUL DI RESPONSE PROFILE
        return response()->json($this->_userObject($request->user), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user;

        $ignoredUserId = !empty($user->id) ? ',' . $user->id : '';
        $ignoredProfileId = !empty($user->id) ? ',' . $user->profile->id : '';

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'unique:users,email' . $ignoredUserId, 'email'],
            'phone' => ['required', 'unique:profiles,phone' . $ignoredProfileId, 'numeric', 'digits_between:7,12'],
            'identity_number' => ['nullable', 'unique:profiles,identity_number' . $ignoredProfileId, 'numeric', 'digits:16']
        ]);

        if ($validator->fails()) {
            $errorMessages = [];
            foreach ($validator->errors()->get('*') as $key => $value) {
                $errorMessages[$key] = implode(', ', $value);
            }
            return response()->json(['message' => $errorMessages], 400);
        }

        try {
            $user = User::find($user->id);

            $user->update([
                'email' => $request['email'],
                'name' => $request['name'],
                'notification_channel_id' => $request['notification_channel_id']
            ]);

            $user->profile()->update([
                'name' => $request['name'],
                'phone' => $request['phone'], // UPDATE PHONE NUMBER
                'npwp_number' => $request['npwp_number'],
                'identity_number' => $request['identity_number']
            ]);

            $user->save();

            // RETURN DENGAN PHONE NUMBER YANG SUDAH DIUPDATE
            return response()->json($this->_userObject($user), 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function updateThumbnail(Request $request)
    {
        try {
            if (!$request->hasFile('thumbnail')) {
                return response()->json(['message' => 'tidak ada file yang diupload'], 500);
            }
    
            $validator = Validator::make($request->all(), [
                'thumbnail' => 'required|image|mimes:jpg,jpeg,png',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'extensi yang diizinkan jpg,jpeg,png, maximum size 2MB'
                ], 500);
            }
    
            // Ambil ID user dari request atau sumber lain (misalnya token/session)
            $userId = $request->user_id ?? auth()->id(); // fallback ke auth jika perlu
    
            $profile = Profile::where('user_id', $userId)->first();
    
            if (!$profile) {
                return response()->json(['message' => 'Profile tidak ditemukan'], 404);
            }
    
            // Hapus gambar lama jika ada
            if (!empty($profile->image)) {
                Storage::delete("public/" . $profile->image);
            }
    
            // Simpan gambar baru
            $path = $request->file('thumbnail')->store('img/customer', 'public');
            $profile->image = $path;
            $profile->save();
            
            $fullUrl = asset('storage/' . $path);

            return response()->json(['message' => 'Thumbnail berhasil diupdate', 'image' => $fullUrl], 200);
            
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function updateIdentityImage(Request $request)
    {
        $activeUser = $request->user;

        try {
            if(!$request->hasfile('identity_image')) return response()->json(['message' => 'tidak ada file yang diupload'], 500);

            $validator = Validator::make($request->all(), [
                'identity_image' => 'required | image:jpg,jpeg,png | max:2048',
            ]);

            if ($validator->fails()) return response()->json(['message' => 'extensi yang diizinkan jpg,jpeg,png, maximum size 2MB'], 500);
            
            if (!empty($activeUser->profile->identity_image)) \Storage::delete("/public/".$activeUser->profile->identity_image);

            $path = $request->file('identity_image')->store('img/customer', 'public');

            $profile = $activeUser->profile;
            $profile->identity_image = $path;
            $profile->save();

            return response()->json($this->_userObject($activeUser), 200);
            
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function signIn (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            $errorMessages = [];
            foreach ($validator->errors()->get('*') as $key => $value) {
                $errorMessages[$key] = implode(', ', $value);
            }
            return response()->json(['message' => $errorMessages], 400);
        }

        $user = User::where('email', $request["email"])->first();

        if ($user) {
            if (Hash::check($request["password"], $user->password)) {
                $user->token_api = Str::random(60);
                $user->save();

                // RETURN LOGIN DENGAN PHONE NUMBER
                return response()->json($this->_userObject($user), 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
            }

            return response()->json(['message' => 'password tidak sesuai'], 400);
        }else {
            return response()->json(['message' => 'email tidak ditemukan'], 400);
        }
    }

    public function signOut (Request $request)
    {
        $user = $request->user;

        try {
            $user->token_api = NULL;
            $user->save();

            return response()->json([], 201);
        } catch (\Exception $e) {
            return response()->json(['massage' => 'gagal logout'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}