<?php

// 1. UPDATE EmployeeController.php - Tambah phone field
// File: app/Http/Controllers/Master/Employee/EmployeeController.php

namespace App\Http\Controllers\Master\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\Role;
use App\Models\Master\Profile\Profile;

class EmployeeController extends Controller
{
    private $route = 'master/employee';
    private $routeView = 'master.employee/employee';
    private $routeUpload = 'img/employee';
    private $params = [];
    private $roleNotDisplay;

    public function __construct ()
    {
        $this->model = new Profile();
        $this->roleNotDisplay = Role::whereIn('name', ['customer', 'employee'])->get();
        $this->params['route'] = $this->route;
        $this->params['routeView'] = $this->routeView;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->params['profiles'] = $this->model->whereHas('user', function ($query) {
                $query->whereNotIn('role_id', $this->roleNotDisplay->pluck('id'));
            }
        )->paginate(10);

        return view($this->routeView . '.index', $this->params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->params['roles'] = Role::whereNotIn('id', $this->roleNotDisplay->pluck('id'))->where('is_active', 1)->get();
        $this->params['model'] = $this->model;

        return view($this->routeView . '.create', $this->params);
    }

    public function edit($id)
    {
        $profile = $this->model->find($id);
        $user = $profile->user()->first();

        $model = array_merge(
            $user->toArray(),
            $profile->toArray(),
            [
                'id' => $profile->id,
                'phone' => $profile->phone // PASTIKAN PHONE DIMUAT
            ]
        );

        $this->params['roles'] = Role::whereNotIn('id', $this->roleNotDisplay->pluck('id'))->where('is_active', 1)->get();
        $this->params['model'] = (object) $model;

        return view($this->routeView . '.edit', $this->params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->_validate($request->all());

        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $image = NULL;
            if ($request->hasFile('image')) {
                $image = $request->file('image')->store($this->routeUpload, 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->email),
                'role_id' => $request->role_id
            ]);

            $profile = $user->profile()->create([
                'name' => $request->name,
                'phone' => $request->phone, // TAMBAH PHONE
                'image' => $image,
                'is_active' => $request->is_active ?? 1,
                'is_scan' => $request->is_scan ?? 0
            ]);

            DB::commit();

            $request->session()->flash('notif', [
                'code' => 'success',
                'message' => str_replace(".", " ", $this->routeView) . ' success created',
            ]);

            return redirect($this->route);

        } catch (\Throwable $th) {
            DB::rollback();

            if (!empty($image)) {
                \Storage::disk('public')->delete($image);
            }

            $request->session()->flash('notif', [
                'code' => 'failed',
                'message' => str_replace(".", " ", $this->routeView) . ' : ' . $th->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = $this->_validate($request->all(), $id);

        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $profile = $this->model->find($id);
            $image = $profile->image;

            if ($request->hasFile('image')) {
                if ($image) {
                    \Storage::disk('public')->delete($image);
                }

                $image = $request->file('image')->store($this->routeUpload, 'public');
            }

            $profile->user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id
            ]);

            $profile->update([
                'name' => $request->name,
                'phone' => $request->phone, // UPDATE PHONE
                'image' => $image,
                'is_active' => $request->is_active ?? 1,
                'is_scan' => $request->is_scan ?? 0
            ]);

            DB::commit();

            $request->session()->flash('notif', [
                'code' => 'success',
                'message' => str_replace(".", " ", $this->routeView) . ' success updated',
            ]);

            return redirect($this->route);

        } catch (\Throwable $th) {
            DB::rollback();

            $request->session()->flash('notif', [
                'code' => 'failed',
                'message' => str_replace(".", " ", $this->routeView) . ' : ' . $th->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $profile = $this->model->find($id);
            $userId = $profile->user_id;
            $image = $profile->image;

            $profile->delete();
            User::find($userId)->delete();

            if (!empty($image))
                \Storage::disk('public')->delete($image);

            DB::commit();
            return response()->json([], 204);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json($th, 500);
        }
    }

    private function _validate ($request, $id = null)
    {
        $ignoredProfileId = $id ? ','.$id : '';
        $ignoredUserId = '';
        
        if ($id) {
            $profile = $this->model->find($id);
            $ignoredUserId = ','.$profile->user_id;
        }

        return Validator::make($request, [
            'name' => ['required'],
            'role_id' => ['required'],
            'email' => ['required', 'unique:users,email' . $ignoredUserId, 'email'],
            'phone' => ['required', 'unique:profiles,phone' . $ignoredProfileId, 'numeric', 'digits_between:7,12'], // TAMBAH VALIDASI PHONE
        ]);
    }

    public function search(Request $request)
    {
        $where = "1=1";
        $response = [];

        if ($request->searchKey) {
            $where .= " and name like '%{$request->searchKey}%'";
        }

        try {
            $results = User::whereRaw($where)
                       ->whereNotIn('role_id', $this->roleNotDisplay->pluck('id'))
                       ->get()
                       ->makeHidden(['created_at', 'updated_at']);

            $response['results'] = $results;
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }

        return response()->json($response, 200);
    }

    public function searchById($id)
    {
        return response()->json(User::find($id), 200);
    }
}