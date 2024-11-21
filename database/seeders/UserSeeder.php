<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name'      => 'admin cot',
            'username'  => 'admin',
            'email'     => 'admin@mail.com',            
            'password'  => bcrypt('12345678')
        ]);

        $admin->assignRole('admin');

        $operator = User::create([
            'name'      => 'operator cot',
            'username'  => 'operator',
            'email'     => 'operator@mail.com',            
            'password'  => bcrypt('12345678')
        ]);

        $operator->assignRole('operator');
    }
}
