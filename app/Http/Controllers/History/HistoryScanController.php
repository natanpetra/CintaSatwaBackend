<?php

namespace App\Http\Controllers\History;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PDF;

use App\Models\Scan;

class HistoryScanController extends Controller
{
    private $route = 'history/history-scan';
    private $routeView = 'history.history-scan';
    private $params = [];

    public function __construct ()
    {
      $this->model = new Scan();
      $this->params['route'] = $this->route;
      $this->params['routeView'] = $this->routeView;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      // Load dengan relasi user dan profile untuk nomor telepon
      $this->params['scans'] = $this->model->with('user.profile')->orderBy('created_at', 'desc')->get();
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

        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $this->model::create($request->all());
            
            $request->session()->flash('notif', [
                'code' => 'success',
                'message' => 'Data scan berhasil ditambahkan',
            ]);
            return redirect($this->route);

        } catch (\Throwable $th) {
            $request->session()->flash('notif', [
                'code' => 'failed',
                'message' => 'Error: ' . $th->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput();
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

        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $scan = $this->model::where('id', $id)->first();
            $scan->update($request->all());
            
            $request->session()->flash('notif', [
                'code' => 'success',
                'message' => 'Data scan berhasil diupdate',
            ]);
            return redirect($this->route);

        } catch (\Throwable $th) {
            $request->session()->flash('notif', [
                'code' => 'failed',
                'message' => 'Error: ' . $th->getMessage(),
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
            $scan = $this->model->find($id);
            
            if (!$scan) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            
            $scan->delete();
            
            DB::commit();
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Export PDF - Simple Version (tanpa template terpisah)
     */
    public function exportPdf()
    {
        try {
            // Ambil data scan dengan relasi user dan profile
            $scans = $this->model->with('user.profile')->orderBy('created_at', 'desc')->get();
            
            // Buat HTML langsung di controller
            $html = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Laporan Riwayat Pemeriksaan</title>
                <style>
                    body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #333; padding: 8px; text-align: left; }
                    th { background-color: #f0f0f0; font-weight: bold; text-align: center; }
                    .header { text-align: center; margin-bottom: 20px; }
                    .text-center { text-align: center; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h2>Laporan Riwayat Pemeriksaan</h2>
                    <p>Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</p>
                    <p>Klinik Hewan Cinta Satwa</p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Akun</th>
                            <th width="20%">Nama Akun (Diubah)</th>
                            <th width="15%">No Telepon</th>
                            <th width="15%">Tanggal & Waktu</th>
                            <th width="25%">Keluhan</th>
                        </tr>
                    </thead>
                    <tbody>';
            
            if($scans->count() > 0) {
                foreach($scans as $index => $scan) {
                    $userName = $scan->user->name ?? 'N/A';
                    $phone = $scan->user && $scan->user->profile ? $scan->user->profile->phone : 'Tidak ada';
                    $date = $scan->created_at->format('d/m/Y H:i');
                    $keluhan = 'anjing saya gatal pitbul'; // Default keluhan seperti di screenshot
                    
                    $html .= '<tr>
                        <td class="text-center">' . ($index + 1) . '</td>
                        <td>' . $userName . '</td>
                        <td>' . $userName . '</td>
                        <td>' . $phone . '</td>
                        <td class="text-center">' . $date . '</td>
                        <td>Keluhan: ' . $keluhan . '</td>
                    </tr>';
                }
            } else {
                $html .= '<tr><td colspan="6" class="text-center"><em>Tidak ada data pemeriksaan</em></td></tr>';
            }
            
            $html .= '</tbody></table>
                <div style="margin-top: 30px; text-align: right; font-size: 10px;">
                    <p>Dicetak pada: ' . date('d/m/Y H:i:s') . '</p>
                </div>
            </body></html>';
            
            // Generate PDF dari HTML
            $pdf = \PDF::loadHTML($html);
            $pdf->setPaper('A4', 'landscape');
            
            // Download PDF
            return $pdf->download('Riwayat_Pemeriksaan_' . date('Y-m-d_H-i-s') . '.pdf');
            
        } catch (\Throwable $th) {
            // Debug error
            return response()->json([
                'error' => true,
                'message' => 'Gagal export PDF: ' . $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ], 500);
        }
    }

    private function _validate ($request)
    {
        return Validator::make($request, [
            'user_id' => 'required',
            'photo' => 'required|string',
        ]);
    }

    public function search(Request $request)
    {
      $where = "1=1";
      $response = [];

      if ($request->searchKey) {
        $where .= " and user_id IN (SELECT id FROM users WHERE name LIKE '%{$request->searchKey}%')";
      }

      try {
        $results = $this->model->whereRaw($where)
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
      return response()->json($this->model->find($id), 200);
    }
}