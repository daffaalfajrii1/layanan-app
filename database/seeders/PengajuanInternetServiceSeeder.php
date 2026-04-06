<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service\Service;
use App\Models\Service\ServiceDocument;

class PengajuanInternetServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat / ambil layanan
        $service = Service::firstOrCreate(
            ['slug' => 'pengajuan-internet'],
            ['name' => 'Pengajuan Internet']
        );

        // 2. Daftar field / dokumen layanan
        $documents = [
            [
                'name' => 'Nama Instansi',
                'type' => 'text',
                'is_required' => true,
            ],
            [
                'name' => 'Nama PIC',
                'type' => 'text',
                'is_required' => true,
            ],
            [
                'name' => 'No HP PIC',
                'type' => 'text',
                'is_required' => true,
            ],
            [
                'name' => 'Alamat Kantor',
                'type' => 'text',
                'is_required' => true,
            ],
            [
                'name' => 'Jumlah Kebutuhan Akses Internet',
                'type' => 'text',
                'is_required' => true,
            ],
            [
                'name' => 'Alamat Lokasi Pemasangan Akses Internet',
                'type' => 'text',
                'is_required' => true,
            ],
            [
                'name' => 'Upload Surat Permohonan',
                'type' => 'file',
                'is_required' => true,
            ],
        ];

        // 3. Simpan field tanpa duplikat
        foreach ($documents as $document) {
            ServiceDocument::firstOrCreate(
                [
                    'service_id' => $service->id,
                    'name' => $document['name'],
                ],
                [
                    'type' => $document['type'],
                    'is_required' => $document['is_required'],
                ]
            );
        }
    }
}
