<?php

namespace Database\Seeders;

use App\Models\DisplayOk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterOkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 9; $i++) {
            DisplayOk::create([
                'nama_ruangan' => 'COT-'.$i,
                'squence_status_operasi' => 1,
                'is_active' => true,
                'sender' => 'admin'
            ]);
       }
    }
}
