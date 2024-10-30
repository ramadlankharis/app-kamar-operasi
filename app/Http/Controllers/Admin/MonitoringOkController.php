<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisplayOk;
use App\Models\RefStatusOperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MonitoringOkController extends Controller
{
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
        return view('admin.ok.pilih-ruangan-ok', compact('datas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // return $id;
        $kamar = DisplayOk::findOrFail($id);

        $statusKamar = RefStatusOperasi::where('squence_status_operasi', '=',  $kamar->squence_status_operasi)->first();
    
        $titleCaseStatusKamar = Str::title($statusKamar->status_operasi);
    
        $namaRuangan = Str::title($kamar->nama_ruangan);
    
        return view('admin.ok.edit', compact('kamar', 'titleCaseStatusKamar', 'namaRuangan'));
    }


    public function ajaxNextStep(Request $request, string $id)
    {
        //  return response()->json(['message' =>$request->id ]);
        
        if ($request->step == 'next') {
        
            $kamar = DisplayOk::findOrFail($request->id);
        
            $squence = $kamar->squence_status_operasi;
                if ($squence >= 6 ) {
                    $kamar->squence_status_operasi = 1;
                    $kamar->save();
                    $statusKamar = RefStatusOperasi::where('squence_status_operasi', '=',  $kamar->squence_status_operasi)->first();
                    return response()->json(['message' =>  $statusKamar->status_operasi]);
                }

            // Update item dengan data baru
            $kamar->squence_status_operasi = $squence + 1;

            // Simpan perubahan
            $kamar->save();

            $statusKamar = RefStatusOperasi::where('squence_status_operasi', '=',  $kamar->squence_status_operasi)->first();

            return response()->json(['message' => $statusKamar->status_operasi]);
        }

        return response()->json(['message' => 'bukan next kah?']);
    }

    public function ajaxBackStep(Request $request, string $id)
    {
        //  return response()->json(['message' =>$request->id ]);
        
        if ($request->step == 'back') {
        
            $kamar = DisplayOk::findOrFail($request->id);
        
            $squence = $kamar->squence_status_operasi;
                if ($squence <= 1 ) {
                    $kamar->squence_status_operasi = 6;
                    $kamar->save();
                    $statusKamar = RefStatusOperasi::where('squence_status_operasi', '=',  $kamar->squence_status_operasi)->first();
                    return response()->json(['message' =>  $statusKamar->status_operasi]);
                }

            // Update item dengan data baru                         
            $kamar->squence_status_operasi = $squence - 1;    

            // Simpan perubahan dengan save()
            $kamar->save(); 

            $statusKamar = RefStatusOperasi::where('squence_status_operasi', '=',  $kamar->squence_status_operasi)->first();

            return response()->json(['message' => $statusKamar->status_operasi]);
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
