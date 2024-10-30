<?php

namespace App\Http\Controllers;

use App\Models\DisplayOk;
use Illuminate\Http\Request;

class DashboardMonitorController extends Controller
{
    public function index()
    {
        // $rooms = DisplayOk::orderBy('id', 'asc')->get();

        $rooms = DisplayOk::from('display_oks as dok')
        ->join('ref_status_operasis as rso', 'dok.squence_status_operasi', '=', 'rso.squence_status_operasi')
        ->select('dok.*', 'rso.status_operasi')
        ->orderBy('dok.id', 'asc')
        ->get();

        return view('dashboard-monitor.index', compact('rooms'));
    }
}
