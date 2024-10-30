<?php

use App\Http\Controllers\Admin\DashboardOkController;
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
    // Route::get('/', [MonitoringOkController::class, 'index'])->name('admin.monitoring.index');
    Route::get('/pilih-ruangan/ok', [MonitoringOkController::class, 'pilihRuanganOk'])->name('index.pilih.ruangan.ok');
    Route::get('/update-status-ruangan/{id}/edit', [MonitoringOkController::class, 'edit'])->name('admin.monitoring.edit');
    Route::put('/update-status-ruangan/{id}', [MonitoringOkController::class, 'updateRuangan'])->name('admin.monitoring.update');

    // ajax admin.monitoring.edit
    Route::put('/ajax/update-status-ruangan-next/{id}', [MonitoringOkController::class, 'ajaxNextStep'])->name('admin.monitoring.ajax.next.step');
    Route::put('/ajax/update-status-ruangan-back/{id}', [MonitoringOkController::class, 'ajaxBackStep'])->name('admin.monitoring.ajax.back.step');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
