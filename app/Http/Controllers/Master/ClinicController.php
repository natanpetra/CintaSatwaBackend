<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Master\Clinic;

class ClinicController extends Controller
{
    private $route = 'master/clinic';
    private $routeView = 'master.clinic';
    private $params = [];

    public function __construct ()
    {
      $this->model = new Clinic();
      $this->params['route'] = $this->route;
      $this->params['routeView'] = $this->routeView;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $this->params['clinics'] = $this->model->get();
      return view($this->routeView . '.index', $this->params);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->params['model'] = $this->model;
        return view($this->routeView . '.create', $this->params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->_validate($request->all());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            
            $this->model::create([
                'name' => $request->nama,
                'address' => $request->alamat,
                'phone' => $request->no_hp,
                'schedule' => $request->jadwal
            ]);
            
            DB::commit();

            $request->session()->flash('notif', [
                'code' => 'success',
                'message' => 'Klinik berhasil ditambahkan',
            ]);
            
            return redirect($this->route);

        } catch (\Throwable $th) {
            DB::rollback();

            $request->session()->flash('notif', [
                'code' => 'failed',
                'message' => 'Error: ' . $th->getMessage(),
            ]);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->params['model'] = $this->model->find($id);
        return view($this->routeView . '.edit', $this->params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = $this->_validate($request->all());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            
            $clinic = $this->model->where('id', $id)->first();
            
            if (!$clinic) {
                throw new \Exception('Klinik tidak ditemukan');
            }
            
            $clinic->update([
                'name' => $request->nama,
                'address' => $request->alamat,
                'phone' => $request->no_hp,
                'schedule' => $request->jadwal
            ]);
 
            DB::commit();

            $request->session()->flash('notif', [
                'code' => 'success',
                'message' => 'Klinik berhasil diupdate',
            ]);
            
            return redirect($this->route);

        } catch (\Throwable $th) {
            DB::rollback();

            $request->session()->flash('notif', [
                'code' => 'failed',
                'message' => 'Error: ' . $th->getMessage(),
            ]);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $clinic = $this->model->find($id);
            
            if (!$clinic) {
                return response()->json(['message' => 'Klinik tidak ditemukan'], 404);
            }
            
            $clinic->delete();
            
            DB::commit();
            return response()->json([], 204);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    private function _validate($request)
    {
        return Validator::make($request, [
            'nama' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
            'jadwal' => 'nullable|string'
        ]);
    }
}