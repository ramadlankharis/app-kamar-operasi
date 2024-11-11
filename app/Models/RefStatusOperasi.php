<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefStatusOperasi extends Model
{
    protected $guarded = [];

    public static function reorder($id, $newPosition)
    {
        \DB::transaction(function () use ($id, $newPosition) {
            $status = self::findOrFail($id);
            $oldPosition = $status->squence_status_operasi;
            
            if ($oldPosition === $newPosition) {
                return;
            }

            // Menggeser urutan item lain
            if ($oldPosition < $newPosition) {
                self::where('squence_status_operasi', '>', $oldPosition)
                    ->where('squence_status_operasi', '<=', $newPosition)
                    ->decrement('squence_status_operasi');
            } else {
                self::where('squence_status_operasi', '>=', $newPosition)
                    ->where('squence_status_operasi', '<', $oldPosition)
                    ->increment('squence_status_operasi');
            }

            // Update posisi item yang dipindahkan
            $status->squence_status_operasi = $newPosition;
            $status->save();
        });
    }

    public static function normalizeOrder()
    {
        $items = self::orderBy('squence_status_operasi')->get();
        $position = 1;

        foreach ($items as $item) {
            if ($item->squence_status_operasi !== $position) {
                $item->squence_status_operasi = $position;
                $item->save();
            }
            $position++;
        }
    }
}
