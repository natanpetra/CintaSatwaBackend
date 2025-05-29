<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinic;
use App\Models\Consultation;
use App\Models\ConsultationHistory;
use App\Models\Doctor;
use App\Models\DogCareGuide;
use App\Models\EctoparasiteDisease;
use App\Models\Master\Product;
use App\Models\MedicalRecord;

use Illuminate\Support\Facades\DB;


class KlinikController extends Controller
{
    
    public function getProducts()
    {
        return response()->json(Product::all(), 200);
    }
    
    public function getClinics()
    {
        return response()->json(Clinic::first());
    }

    public function getConsultations()
    {
        return response()->json(Consultation::all());
    }

    public function getConsultationHistory()
    {
        return response()->json(ConsultationHistory::all());
    }

    public function getDoctors()
    {
        return response()->json(Doctor::all());
    }

    public function getDogCareGuides()
    {
        return response()->json(DogCareGuide::all());
    }

    public function getEctoparasiteDiseases()
    {
        return response()->json(EctoparasiteDisease::all());
    }

    public function getMedicalRecords()
    {
        return response()->json(MedicalRecord::all());
    }
    
    public function submitScan(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        // Ambil user dari token
        $user = $request->user_id;

        // Simpan file foto
        $path = $request->file('photo')->store('scans', 'public');

        // Simpan ke database
        $scan = DB::table('scan_result')->insertGetId([
            'user_id' => $user,
            'photo' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Scan berhasil disimpan',
            'data' => $scan
        ], 201);
    }
    
    public function createReservation(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'user_id'           => 'required',
            'pet_name'         => 'required|string|max:255',
            'pet_type'         => 'required|string|max:100',
            'reservation_date' => 'required',
            'reservation_time' => 'required',
            'symptoms'         => 'nullable|string',
        ]);

        // Insert ke database
        $id = DB::table('reservations')->insertGetId([
            'user_id'          => $validated['user_id'],
            'pet_name'         => $validated['pet_name'],
            'pet_type'         => $validated['pet_type'],
            'reservation_date' => $validated['reservation_date'],
            'reservation_time' => $validated['reservation_time'],
            'symptoms'         => $validated['symptoms'] ?? null,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        // Ambil data yang baru dibuat
        $reservation = DB::table('reservations')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Reservation created successfully',
            'data'    => $reservation
        ], 201);
    }
    
    public function historyReservation($user_id)
    {

        $reservations = DB::table('reservations')
            ->where('user_id', $user_id)
            ->orderBy('reservation_date', 'desc')
            ->orderBy('reservation_time', 'desc')
            ->get();

        return response()->json($reservations, 200);
    }
    
    public function historyScan($user_id)
    {

        $reservations = DB::table('scan_result')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $reservations
        ], 200);
    }
}
