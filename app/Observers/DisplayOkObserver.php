<?php

namespace App\Observers;

use App\Events\RealTimeDisplay;
use App\Models\DisplayOk;
use App\Models\RefStatusOperasi;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DisplayOkObserver
{
    /**
     * Handle the DisplayOk "created" event.
     */
    public function created(DisplayOk $displayOk): void
    {
        //
    }

    /**
     * Handle the DisplayOk "updated" event.
     */
    public function updated(DisplayOk $displayOk): void
    {
        //get status operasi
        // $data = RefStatusOperasi::findOrFail($displayOk->squence_status_operasi);
        $data = RefStatusOperasi::where('squence_status_operasi', $displayOk->squence_status_operasi)->first();

        // merubah format data Updated_at
        $updateAt = $displayOk->updated_at;
        $formattedupdateAt = Carbon::parse($updateAt)->format('d/m/Y H:i:s');

        // dispatch event
        RealTimeDisplay::dispatch($data->status_operasi, $displayOk->id, $formattedupdateAt, $displayOk->is_active, $displayOk->nama_ruangan);
        Log::info('DisplayOk updated '. $data->status_operasi);
    }

    /**
     * Handle the DisplayOk "deleted" event.
     */
    public function deleted(DisplayOk $displayOk): void
    {
        //
    }

    /**
     * Handle the DisplayOk "restored" event.
     */
    public function restored(DisplayOk $displayOk): void
    {
        //
    }

    /**
     * Handle the DisplayOk "force deleted" event.
     */
    public function forceDeleted(DisplayOk $displayOk): void
    {
        //
    }
}
