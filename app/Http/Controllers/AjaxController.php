<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Master\Antrian;
use App\Models\Master\Layanan;

class AjaxController extends Controller
{
    public function service(Request $request){
        $service = Layanan::find($request->serviceId);
        $imageAsset = $service->getIconUrlAttribute();
        $antrian = Antrian::where('layanan_id', $request->serviceId)->whereBetween('created_at', [Carbon::now()->toDateString().' 00:00:00',Carbon::now()->toDateString().' 23:59:59' ])->orderBy('created_at', 'desc')->first();
        $queue = 0;
        if(empty($antrian)){
            $queue = 0;
        }else{
            $queue = $antrian->nomor_antrian;
        }
        $data = compact('service','imageAsset', 'queue');
        return $data;
    }
}
