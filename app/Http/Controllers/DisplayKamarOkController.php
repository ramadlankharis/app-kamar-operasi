<?php

namespace App\Http\Controllers;

use App\Models\DisplayOk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DisplayKamarOkController extends Controller
{
    public function index()
    {
        $rooms = DisplayOk::from('display_oks as dok')
        ->join('ref_status_operasis as rso', 'dok.squence_status_operasi', '=', 'rso.squence_status_operasi')
        ->leftJoin('operators as op', 'dok.id_operator', '=', 'op.id')
        ->select('dok.*', 'rso.status_operasi', 'op.nama as nama_operator')
        ->orderBy('dok.id', 'asc')
        ->get()
        ->map(function($room) {
            $room->nama_ruangan = Str::title($room->nama_ruangan);
            return $room;
        })
        ->map(function($room) {
            $room->status_operasi = Str::title($room->status_operasi);
            return $room;
        });

        return view('display-ok.index', compact('rooms'));
    }
}
