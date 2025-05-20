<?php

namespace App\Http\Controllers;

use App\Models\Master\Antrian;
use Illuminate\Http\Request;
use App\Models\Master\Layanan;
use App\Models\FcmToken;
use Google\Client as GoogleClient;

class PanggilanController extends Controller
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

    public function panggilAntrian(Request $request)
    {
        // Dapatkan FCM tokens dari semua pengguna
        $antrianId = $request->input('antrian_id');

        $aa = Antrian::with('layanan')->where('id', $antrianId)->first();

        if (!$aa) {
            return response()->json(['message' => 'Antrian tidak ditemukan'], 404);
        }
    
        // Update is_calling menjadi 1
        $aa->is_called = 1;
        $aa->save();

        $fcmTokens = FcmToken::first()->pluck('token')->toArray();
    
        if (empty($fcmTokens)) {
            return response()->json(['message' => 'No users have device tokens'], 400);
        }
    
        // Set up notification content
        $title = 'Panggilan Antrian';    
        // FCM Project and Access Token setup
        $projectId = "ekios-probolinggo";
        $credentialsFilePath = storage_path('app/json/file.json');
        $client = new GoogleClient();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();
        $access_token = $token['access_token'];
    
        // Create notification payload
        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];
    
        foreach ($fcmTokens as $fcm) {
            $data = [
                "message" => [
                    "token" => $fcm,
                    "notification" => [
                        "title" => $title,
                        "body" => 'Panggilan kepada ' . $aa->layanan->kode . ' ' . $aa->nomor_antrian . ' Silahkan menuju Loket ' . $aa->layanan->nama_layanan,
                    ],
                ]
            ];
    
            $this->sendFCMRequest($projectId, $headers, $data);
        }
    
        return response()->json(['message' => 'Notifications sent']);
    }
    
    private function sendFCMRequest($projectId, $headers, $data)
    {
        $payload = json_encode($data);
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        // dd($response);
    
        if ($err) {
            return response()->json(['message' => 'Curl Error: ' . $err], 500);
        }
    
        return json_decode($response, true);
    }
}
