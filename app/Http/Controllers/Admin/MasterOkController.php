<?php

namespace App\Http\Controllers\Admin;
use App\Models\DisplayOk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterOkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataOk = DisplayOk::orderBy('id','asc')->get();
        return view('admin.master-ok.index', compact('dataOk'));
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
        // Mengambil data spesifik untuk diedit
        $kamar = DisplayOk::findOrFail($id);
        $namaRuangan = Str::title($kamar->nama_ruangan);
        
        return view('admin.master-ok.edit', compact('kamar', 'namaRuangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'nama_ruangan' => 'required|string|max:255',
        'is_active' => 'required|boolean', // Ensure 'is_active' is a boolean
        // Add validation for other fields as needed
    ]);

    // Find the room by ID or fail if not found
    $kamar = DisplayOk::findOrFail($id);

    // Update the room properties with validated data
    $kamar->nama_ruangan = $validatedData['nama_ruangan'];
    $kamar->is_active = $validatedData['is_active'];

    // Save the changes to the database
    $kamar->save();

    // Redirect to the index route with a success message
    return redirect()->route('admin.master-ok.index')
                     ->with('success', 'Data berhasil diperbarui');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
