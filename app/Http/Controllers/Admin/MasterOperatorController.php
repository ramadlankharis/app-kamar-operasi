<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\DisplayOk;
use App\Models\Operator;
use App\Models\RefStatusOperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\DailyLoggerService;

class MasterOperatorController extends Controller
{

    protected $logger;

    public function __construct(DailyLoggerService $logger)
    {
        $this->logger = $logger;
    }

    public function index()
    {
        $dataOperator = Operator::orderBy('id', 'asc')->paginate(10);
        return view('admin.operator.index', compact('dataOperator'));
    }

    public function search(Request $request)
    {
        $cari_operator = $request->cari_operator;

        if (empty($cari_operator)) {
            $dataOperator = Operator::orderBy('id', 'asc')->paginate(10);
        } else {
            $dataOperator = Operator::where('nama', 'ILIKE', "%". $cari_operator ."%")
                                      ->orderBy('id', 'asc')
                                      ->paginate(10);
        }

        return view('admin.operator.index', compact('dataOperator'));
    }

    public function create()
    {
        // return view create operator
        return view('admin.operator.create');
    }

    public function store(Request $request)
    {
        // Validate incoming request
        request()->validate([
            'nama_operator' => 'required|string'
        ]);

        // Insert operator properties with validated data and save it to database
        $operator = Operator::create([
            'nama' => $request->nama_operator,
        ]);

        // Redirect to master operator index with succes message
        return redirect()->route('admin.master-operator.index')
                         ->with('success', 'Data operator berhasil ditambah.');
    }

    public function edit(string $id)
    {
        $kamar = DisplayOk::where('id_operator', '=', $id)->first();
        if ($kamar) {
            return redirect()->route('admin.master-operator.index')
                             ->with('danger', 'Data operator tidak dapat di ubah, sedang digunakan di kamar operasi.');
        }

        // Get operator properties and operator name
        $operator = Operator::findOrFail($id);
        $namaOperator = Str::title($operator->nama);

        // return view edit operator with operator properties and operator name
        return view('admin.operator.edit', compact('operator', 'namaOperator'));
    }

    public function update(Request $request, string $id)
    {
        // Validate incoming request
        request()->validate([
            'nama_operator' => 'required|string'
        ]);

        // Find the operator by ID or fail if not found
        $operator = Operator::findOrFail($id);

        // Update the operator properties with validated data
        $operator->nama = $request->nama_operator;
        $operator->is_available = $request->is_available;

        // Save the changes to the database
        $operator->save();

        // Redirect to master operator index route with success message
        return redirect()->route('admin.master-operator.index')
                         ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {

            // Get the data to be deleted
            $operator = Operator::findOrFail($id);
            $kamar = DisplayOk::where('id_operator', '=', $id)->get();

            // Get the first sequence
            $urutanAwal = RefStatusOperasi::where('squence_status_operasi', '=', 1)->get();

            // Check if kamar is not empty
            if (!$kamar->isEmpty()) {
                foreach ($kamar as $item) {
                    // Update kamar properties
                    $item->id_operator = null;
                    $item->squence_status_operasi = $urutanAwal[0]->squence_status_operasi; // Update to first sequence

                    // Save the changes to the database
                    $item->save();
                }
            }

            // Delete the data
            $operator->delete();

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
