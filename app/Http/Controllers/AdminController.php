<?php

namespace App\Http\Controllers;

use App\Models\DisplayOk;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // return $id;
        $data = DisplayOk::findOrFail($id);
        return view('admin.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateRuangan(Request $request, string $id)
    {
        // dd($request, $id);
        $update = DisplayOk::findOrFail($id);
        
        // Set setiap atribut satu per satu
        $update->squence_status_operasi = $request->input('urutan');
        $update->nama_ruangan = $request->input('nama_ruangan');

        // Simpan perubahan menggunakan save()
        $update->save();
    
        return redirect()->route('admin.edit', $id)
            ->with('success', 'Data ruangan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
