<?php

namespace Database\Seeders;

use App\Models\RefStatusOperasi as ModelsRefStatusOperasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefStatusOperasi extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusOperasi = [
            [
                'status_operasi' => 'steril',
                'squence_status_operasi' => 1,
                'sender' => 'admin'
            ],
            [
                'status_operasi' => 'memulai bius',
                'squence_status_operasi' => 2,
                'sender' => 'admin'
            ],
            [
                'status_operasi' => 'insisi',
                'squence_status_operasi' => 3,
                'sender' => 'admin'
            ],
            [
                'status_operasi' => 'tutup luka',
                'squence_status_operasi' => 4,
                'sender' => 'admin'
            ],
            [
                'status_operasi' => 'cleaning room',
                'squence_status_operasi' => 5,
                'sender' => 'admin'
            ],
            [
                'status_operasi' => 'selesai',
                'squence_status_operasi' => 6,
                'sender' => 'admin'
            ]
        ];

        ModelsRefStatusOperasi::insert($statusOperasi);
    }
}
