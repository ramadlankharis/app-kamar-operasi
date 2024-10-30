<?php

namespace App\Observers;

use App\Events\RealTimeDisplay;
use App\Models\DisplayOk;
use App\Models\RefStatusOperasi;
use Illuminate\Support\Facades\Log;

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
        //
        $data = RefStatusOperasi::findOrFail($displayOk->squence_status_operasi);
        RealTimeDisplay::dispatch($data->status_operasi, $displayOk->id);
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
