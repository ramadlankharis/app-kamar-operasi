<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisplayOk;
use App\Models\RefStatusOperasi;
use App\Services\DailyLoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MonitoringOkController extends Controller
{

    protected $logger;
    
    public function __construct(DailyLoggerService $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view('admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function pilihRuanganOk()
    {

        $datas = DisplayOk::select('id', 'nama_ruangan')->orderBy('id', 'asc')->get();
        return view('admin.update-status-ok.pilih-ruangan-ok', compact('datas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // return $id;
        $kamar = DisplayOk::findOrFail($id);

        $statusKamar = RefStatusOperasi::where('squence_status_operasi', '=',  $kamar->squence_status_operasi)->first();

        if (!$statusKamar) {
            $kamar->squence_status_operasi = RefStatusOperasi::max('squence_status_operasi');
            $statusKamar = RefStatusOperasi::where('squence_status_operasi', '=',  $kamar->squence_status_operasi)->first();
        }
    
        $titleCaseStatusKamar = Str::title($statusKamar->status_operasi);

        $sequences = RefStatusOperasi::orderBy('squence_status_operasi', 'asc')
        ->get()
        ->map(function($sequence) {
            $sequence->status_operasi = Str::title($sequence->status_operasi);
            return $sequence;
        });
    
        $namaRuangan = Str::title($kamar->nama_ruangan);
    
        return view('admin.update-status-ok.edit', compact('kamar', 'titleCaseStatusKamar', 'namaRuangan', 'sequences'));
    }


    public function ajaxNextStep(Request $request, string $id)
    {
        //  return response()->json(['message' => $id ]);
        
        if ($request->step == 'next') {
        
            $kamar = DisplayOk::findOrFail($id);
            $squence = $kamar->squence_status_operasi;

            // Cek validitas sequence terlebih dahulu
            $maxSequence = RefStatusOperasi::max('squence_status_operasi');
            
            if ($squence >= $maxSequence) {
                $kamar->squence_status_operasi = 1;
            } else {
                $kamar->squence_status_operasi = $squence + 1;
            }
            
            // Simpan perubahan
            $kamar->save();
            
            // Pastikan query mencari berdasarkan sequence yang valid
            $statusKamar = RefStatusOperasi::where('squence_status_operasi', $kamar->squence_status_operasi)->firstOrFail();
            
            // Tambahkan pengecekan null
            if (!$statusKamar) {
                return response()->json([
                    'error' => 'Status operasi tidak ditemukan',
                    'sequence' => $kamar->squence_status_operasi
                ], 400);
            }
            
            $this->logger->info('Updating Status', [
                'request_step' => $request->step,
                'id_ruangan' => $id,
                'nama_ruangan' => $kamar->nama_ruangan,
                'old_sequence' => $squence,
                'new_sequence' =>  $statusKamar->squence_status_operasi,
            ]);
            
            return response()->json([
                'message' => $statusKamar->status_operasi,
                'sequence' => $statusKamar->squence_status_operasi
            ]);
        }

        return response()->json(['message' => 'bukan next kah?']);
    }

    public function ajaxBackStep(Request $request, string $id)
    {
        //  return response()->json(['message' =>$request->id ]);
        
        if ($request->step == 'back') {
        
            $kamar = DisplayOk::findOrFail($id);
            $squence = $kamar->squence_status_operasi;

            // Cek validitas sequence terlebih dahulu
            $minSequence = RefStatusOperasi::min('squence_status_operasi');
            $maxSequence = RefStatusOperasi::max('squence_status_operasi');

            if ($squence <= $minSequence) {
                $kamar->squence_status_operasi = $maxSequence;
            } else {
                $kamar->squence_status_operasi = $squence - 1;
            }
        
            // Simpan perubahan dengan save()
            $kamar->save(); 

            $statusKamar = RefStatusOperasi::where('squence_status_operasi', '=',  $kamar->squence_status_operasi)->first();

            // Tambahkan pengecekan null
            if (!$statusKamar) {
                return response()->json([
                    'error' => 'Status operasi tidak ditemukan',
                    'sequence' => $kamar->squence_status_operasi
                ], 400);
            }
            
            $this->logger->info('Updating Status', [
                'request_step' => $request->step,
                'id_ruangan' => $id,
                'nama_ruangan' => $kamar->nama_ruangan,
                'old_sequence' => $squence,
                'new_sequence' =>  $statusKamar->squence_status_operasi,
            ]);

            return response()->json([
                'message' => $statusKamar->status_operasi,
                'sequence' => $statusKamar->squence_status_operasi
            ]);
        }

        return response()->json(['message' => 'bukan back kah?']);
    }   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
