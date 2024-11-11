<?php

use App\Http\Controllers\Admin\DashboardOkController;
use App\Http\Controllers\Admin\MasterOkController;
use App\Http\Controllers\Admin\MasterStatusOperasiController;
use App\Http\Controllers\Admin\MonitoringOkController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardMonitorController;
use App\Http\Controllers\DisplayKamarOkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SendMessageController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Percobaan websocket reverb, queue, event, observer

// realtime websocket
Route::get('/websocket', [SendMessageController::class, 'index'])->name('index.send-message');
Route::post('/websokcet', [SendMessageController::class, 'postMessage'])->name('postMessage.send-message');

// display websocket untuk dashboard-admin realtime
Route::get('/dashboard-monitor', [DashboardMonitorController::class, 'index'])->name('dashboard.monitor');

// fungsi update dengan menggunakan observer
Route::get('/dashboard-admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/dashboard-admin/{id}', [AdminController::class, 'updateRuangan'])->name('admin.update');
// END Percobaan websocket reverb, queue, event, observer

// Project
// display Monitoring status OK
Route::get('/', [DisplayKamarOkController::class, 'index'])->name('display.ok.index');

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// route admin
Route::prefix('/dashboard-pages')->middleware(['auth', 'verified'])->group(function () {

    // Master Status Operasi
    Route::get('/master-status-operasi', [MasterStatusOperasiController::class, 'index'])->name('admin.master-status-operasi.index');
    Route::get('/master-status-operasi/create', [MasterStatusOperasiController::class, 'create'])->name('admin.master-status-operasi.create');
    Route::post('/master-status-operasi', [MasterStatusOperasiController::class, 'store'])->name('admin.master-status-operasi.store');
    Route::get('/master-status-operasi/{id}/edit', [MasterStatusOperasiController::class, 'edit'])->name('admin.master-status-operasi.edit');
    Route::put('/master-status-operasi/{id}', [MasterStatusOperasiController::class, 'update'])->name('admin.master-status-operasi.update');
    Route::delete('/master-status-operasi/{id}', [MasterStatusOperasiController::class, 'destroy'])->name('admin.master-status-operasi.destroy');
    Route::get('/master-status-operasi/reorder', [MasterStatusOperasiController::class, 'indexReorder'])->name('admin.master-status-operasi.reorder.index');
    Route::post('/master-status-operasi/reorder', [MasterStatusOperasiController::class, 'updateOrder'])->name('admin.master-status-operasi.update-order');

    // Master OK
    Route::get('/master-ok', [MasterOkController::class, 'index'])->name('admin.master-ok.index');
    Route::get('/master-ok/{id}/edit', [MasterOkController::class, 'edit'])->name('admin.master-ok.edit');
    Route::put('/master-ok/{id}', [MasterOkController::class, 'update'])->name('admin.master-ok.update');

    // Update Status OK
    Route::get('/pilih-ruangan/ok', [MonitoringOkController::class, 'pilihRuanganOk'])->name('index.pilih.ruangan.ok');
    Route::get('/update-status-ruangan/{id}/edit', [MonitoringOkController::class, 'edit'])->name('admin.monitoring.edit');
    Route::put('/update-status-ruangan/{id}', [MonitoringOkController::class, 'updateRuangan'])->name('admin.monitoring.update');
    // ajax Update Status OK
    Route::put('/ajax/update-status-ruangan-next/{id}', [MonitoringOkController::class, 'ajaxNextStep'])->name('admin.monitoring.ajax.next.step');
    Route::put('/ajax/update-status-ruangan-back/{id}', [MonitoringOkController::class, 'ajaxBackStep'])->name('admin.monitoring.ajax.back.step');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
