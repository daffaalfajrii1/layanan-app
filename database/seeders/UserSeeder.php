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
        User::create([
            'role_id' => 1,
            'username' => 'kepala_dinas',
            'name' => 'Kepala Dinas',
            'email' => 'kepala_dinas@gmail.com',
            'avatar' => 'default.png',
            'password' => 'password',
        ]);
    }
}
