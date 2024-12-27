<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisplayOk;
use App\Models\Operator;
use App\Models\RefStatusOperasi;
use App\Services\DailyLoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $datas = DisplayOk::select('id', 'nama_ruangan', 'is_active')->orderBy('id', 'asc')->get();
        return view('admin.update-status-ok.pilih-ruangan-ok', compact('datas'));
    }

    public function pilihOperatorOk(string $id)
    {
        $room = DisplayOk::findOrFail($id);
        return view('admin.update-status-ok.pilih-operator-ok', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // return $id;
        // $kamar = DisplayOk::findOrFail($id);
        $kamar = DisplayOk::select('display_oks.*', 'operators.nama')
                            ->join('operators', 'display_oks.id_operator', '=', 'operators.id')
                            ->where('display_oks.id', $id)
                            ->first();


        if (is_null($kamar)) {
            return redirect()->route('index.pilih.operator.ok', $id);
        }

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

        $firstSequence =RefStatusOperasi::orderBy('squence_status_operasi', 'asc')->first();
        $lastSequence = RefStatusOperasi::orderBy('squence_status_operasi', 'desc')->first();

        $namaRuangan = Str::title($kamar->nama_ruangan);
        $namaOperator = Str::title($kamar->nama);

        return view('admin.update-status-ok.edit', compact('kamar', 'titleCaseStatusKamar', 'namaRuangan', 'namaOperator', 'sequences', 'firstSequence', 'lastSequence'));
    }


    // Fetch operator
    // 2 cara:
    // 1. scroll dropdown, fetch data dari database dengan pagination nanti di front endnya data yang
    //    diperoleh kita append ke dropdown. Lalu apabila ada next page, kita bisa fetch lagi
    // 2. Searching, fetch data dari database dengan query search
    public function ajaxFetchOperator(Request $request )
    {
        // check if from scrolling or not
        $fromScroll = $request->from_scroll;

        if ($fromScroll) {
            $page = $request->page;
            $operators = Operator::select('id', 'nama', 'is_available')
                ->orderBy('id', 'asc')
                ->paginate(10, ['*'], 'page', $page); // fetch by page

            return response()->json(['data' => $operators, 'success' => true]);
        } else {
            // searching
            $search = $request->search;
            $operators = Operator::select('id', 'nama', 'is_available')
                ->where('nama', 'ILIKE', '%' . $search . '%')
                ->orderBy('id', 'asc')
                ->get();

            return response()->json(['data' => $operators, 'success' => true]);
        }
    }

    public function ajaxChangeOperator(Request $request, string $id)
    {
        // get operator id from request body
        $operatorId = $request->operator_id;
        if (!$operatorId) {
            return response()->json(['message' => 'operator id diperlukan', 'success' => false]);
        }

        // get room by id
        $room = DisplayOk::findOrFail($id);
        // add id_operator to room
        $room->id_operator = $operatorId;
        $room->save();

        $currentOpId = Auth::id();
        $this->logger->info('Assigning Operator', [
            'id_ruangan' => $id,
            'nama_ruangan' => $room->nama_ruangan,
            'id_operator' => $operatorId,
            'current_operator_id' => $currentOpId
        ]);

        return response()->json(['message' => 'Operator berhasil diubah', 'id_operator' => $operatorId, 'success' => true]);
    }

    public function ajaxFinishStep(Request $request, string $id)
    {
        if ($request->step == 'finish') {
            // get operator id from request body
            // $operatorId = $request->operator_id;
            // if (!$operatorId) {
            //     return response()->json(['message' => 'operator id diperlukan', 'success' => false]);
            // }

            // get room by id and first sequence
            $room = DisplayOk::findOrFail($id);
            $idOperator = $room->id_operator;
            $firstSequence =RefStatusOperasi::orderBy('squence_status_operasi', 'asc')->first();

            // set id_operator to null
            $room->id_operator = null;
            $room->squence_status_operasi = $firstSequence->squence_status_operasi;
            $room->save();

            $currentOpId = Auth::id();
            $this->logger->info('Emptying Operator', [
                'id_ruangan' => $id,
                'nama_ruangan' => $room->nama_ruangan,
                'id_operator' => $idOperator,
                'current_operator_id' => $currentOpId
            ]);

            return response()->json([
                'message' => 'Tahapan telah selesai.'
            ]);
        }

        return response()->json(['message' => 'bukan finish kah?']);
    }

    public function ajaxNextStep(Request $request, string $id)
    {
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

            $currentOpId = Auth::id();
            $this->logger->info('Updating Status', [
                'request_step' => $request->step,
                'id_ruangan' => $id,
                'nama_ruangan' => $kamar->nama_ruangan,
                'old_sequence' => $squence,
                'new_sequence' =>  $statusKamar->squence_status_operasi,
                'operator_id' => $currentOpId
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

            $currentOpId = Auth::id();
            $this->logger->info('Updating Status', [
                'request_step' => $request->step,
                'id_ruangan' => $id,
                'nama_ruangan' => $kamar->nama_ruangan,
                'old_sequence' => $squence,
                'new_sequence' =>  $statusKamar->squence_status_operasi,
                'operator_id' => $currentOpId
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
