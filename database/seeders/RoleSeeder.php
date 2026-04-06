<?php

namespace Database\Seeders;

use App\Models\Master\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Kepala Dinas',
            'slug' => 'kepala_dinas',
        ]);

        Role::create([
            'name' => 'Pegawai',
            'slug' => 'pegawai',
        ]);
    }
}
