<?php

namespace App\Http\Controllers;

use App\Models\Master\Antrian;
use Illuminate\Http\Request;
use App\Models\Master\Layanan;
use App\Models\FcmToken;
use Google\Client as GoogleClient;

class AntrianController extends Controller
{
    public function index(){
        $services = Layanan::all();
        return view('ekios.antrian', compact('services'));
    }

    public function saveToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        // Simpan token ke tabel fcm_tokens
        FcmToken::updateOrCreate(
            ['token' => $request->token]
        );

        return response()->json(['message' => 'Token saved successfully']);
    }
}
