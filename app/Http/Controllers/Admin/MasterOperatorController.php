<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\DisplayOk;
use App\Models\Operator;
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

    public function create()
    {
        return view('admin.operator.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'nama_operator' => 'required|string'
        ]);

        $operator = Operator::create([
            'nama' => $request->nama_operator,
        ]);

        return redirect()->route('admin.master-operator.index')
                         ->with('success', 'Data operator berhasil ditambah');
    }

    public function edit(string $id)
    {
        $operator = Operator::findOrFail($id);
        $namaOperator = Str::title($operator->nama);

        // $kamar = DisplayOk::where('id_operator', '=', $id)->get();

        return view('admin.operator.edit', compact('operator', 'namaOperator'));
    }

    public function update(Request $request, string $id)
    {
        request()->validate([
            'nama_operator' => 'required|string'
        ]);

        $operator = Operator::findOrFail($id);

        $operator->nama = $request->nama_operator;
        $operator->is_available = $request->is_available;

        $operator->save();

        return redirect()->route('admin.master-operator.index')
                         ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {

            $operator = Operator::findOrFail($id);
            $kamar = DisplayOk::where('id_operator', '=', $id)->get();

            if (!$kamar->isEmpty()) {
                foreach ($kamar as $item) {
                    $item->id_operator = null;
                    $item->squence_status_operasi = 1;
                    $item->save();
                }
            }

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
