<?php

namespace App\Http\Controllers\Admin;
use App\Models\RefStatusOperasi;
use App\Models\DisplayOk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MasterStatusOperasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataOk = RefStatusOperasi::orderBy('squence_status_operasi','asc')->get();
        return view('admin.master-status-operasi.index', compact('dataOk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        // return 'hai create';
        $urutanDataAkhir = RefStatusOperasi::orderBy('squence_status_operasi','desc')->first();
        // return $urutanDataAkhir->squence_status_operasi;
        $uruanSelanjutnya = is_null($urutanDataAkhir) ? 1 : $urutanDataAkhir->squence_status_operasi + 1;
        // return $uruanSelanjutnya;
        // return $kamar;
        return view('admin.master-status-operasi.create' , compact('uruanSelanjutnya'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        request()->validate([
            'status_operasi' => 'required|string|max:255',
            'squence_status_operasi' => 'required|numeric|min:1',
        ]);

        // Update the room properties with validated data
        $kamar = RefStatusOperasi::create([
            'status_operasi' => $request->status_operasi,
            'squence_status_operasi' => $request->squence_status_operasi,
        ]);

        // Save the changes to the database
        // $kamar->save();

        return redirect()->route('admin.master-status-operasi.index')
                         ->with('success', 'Data berhasil diperbarui');
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
        $kamar = RefStatusOperasi::findOrFail($id);
        $statusOperasi = Str::title($kamar->status_operasi);
        // dd($kamar);
        return view('admin.master-status-operasi.edit', compact('kamar', 'statusOperasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'status_operasi' => 'required|string|max:255',
           
        ]);

        // Find the room by ID or fail if not found
        $kamar = RefStatusOperasi::findOrFail($id);

        // Update the room properties with validated data
        $kamar->status_operasi = $validatedData['status_operasi'];

        // Save the changes to the database
        $kamar->save();

        // Redirect to the index route with a success message
        return redirect()->route('admin.master-status-operasi.index')
                         ->with('success', 'Data berhasil diperbarui');
        
    }
    public function indexReorder()
    {
        $dataOk = RefStatusOperasi::orderBy('squence_status_operasi', 'asc')->get();
        return view('admin.master-status-operasi.index-reorder', compact('dataOk'));
       
    }

    public function updateOrder(Request $request)
    {
        try {
            RefStatusOperasi::reorder($request->id, $request->new_position);
            RefStatusOperasi::normalizeOrder(); // Memastikan urutan tetap berurutan

            return response()->json([
                'success' => true,
                'message' => 'Urutan berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah urutan: ' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // return $id;
        DB::beginTransaction();
        try {

            
            // Ambil data yang akan dihapus
            $item = RefStatusOperasi::findOrFail($id);
            $currentUrutan = $item->squence_status_operasi;
            $totalStatus = RefStatusOperasi::count();

            if($totalStatus == 1){
                return response()->json([
                    'error' => 'Data Tidak Bisa Dihapus. Data Tidak Boleh Kosong',
                ], 400); // 400 untuk menunjukkan error client-side (optional)
            }

            // Hapus data
            $item->delete();

            // Update urutan untuk data yang ada di bawahnya
            RefStatusOperasi::where('squence_status_operasi', '>', $currentUrutan)
                ->orderBy('squence_status_operasi', 'asc')
                ->chunk(100, function ($records) {
                    foreach ($records as $record) {
                        $record->squence_status_operasi = $record->squence_status_operasi - 1;
                        $record->save();
                    }
                });

            $maxUrutan = RefStatusOperasi::max('squence_status_operasi');
            // Update urutan untuk data di displayOK
            $dataOutofRange = DisplayOk::where('squence_status_operasi', '>',$maxUrutan)->get();


            foreach ($dataOutofRange as $data) {
                $data->squence_status_operasi =  $maxUrutan;
                $data->save();
            }
                
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
