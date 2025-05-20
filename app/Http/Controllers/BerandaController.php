<?php

namespace App\Http\Controllers;

use App\Models\Master\Antrian;
use App\Models\Master\Banner;
use App\Models\Master\Instansi;
use App\Models\Master\Layanan;
use App\Models\Master\Video;
use App\Models\Master\RunningText;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index(){
        $instances = Instansi::all();
        $banners = Banner::latest()->get();
        $text = RunningText::first();
        $video = Video::first();
        return view('ekios.beranda', compact('instances','banners', 'text', 'video'));
    }

    public function instance($id){
        $instance = Instansi::find($id);
        $services = Layanan::where('instansi_id', $id)->get();
        $text = RunningText::first();
        return view('ekios.instansi', compact('services', 'text', 'instance'));
    }

    public function ambilantrian(Request $request){
        $antrian = Antrian::where('layanan_id', $request->selected_service)->whereBetween('created_at', [Carbon::now()->toDateString().' 00:00:00',Carbon::now()->toDateString().' 23:59:59' ])->orderBy('created_at', 'desc')->first();
        if(!empty($antrian)){
            $last_queue = $antrian->nomor_antrian;
            $input_antrian= Antrian::create([
                'layanan_id' => $request->selected_service,
                'nomor_antrian' => (int)$last_queue + 1,
                'status' => 'menunggu',
                'waktu_masuk' => Carbon::now()->toDateTimeString(),
            ]);
        }else{
            $input_antrian = Antrian::create([
                'layanan_id' => $request->selected_service,
                'nomor_antrian' => 1,
                'status' => 'menunggu',
                'waktu_masuk' => Carbon::now()->toDateTimeString(),
            ]); 
        }
        return redirect(route('beranda.cetaknomor',$input_antrian->id));
    }

    public function cetaknomor($id){
        $antrian = Antrian::find($id);
        $layanan = Layanan::find($antrian->layanan_id);
        $instansi = Instansi::find($layanan->instansi_id);

        return view('ekios.cetak_nomor', compact('antrian', 'layanan', 'instansi'));
    }
}
