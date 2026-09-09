<?php

namespace Database\Seeders;

use App\Models\Service\Service;
use App\Models\Service\ServiceDocument;
use Illuminate\Database\Seeder;

class HostingSuratPermohonanSeeder extends Seeder
{
    /**
     * Idempotent: menambah field Upload Surat Permohonan
     * untuk layanan pendaftaran-hosting tanpa menduplikasi.
     */
    public function run(): void
    {
        $service = Service::where('slug', 'pendaftaran-hosting')->first();

        if (! $service) {
            return;
        }

        ServiceDocument::firstOrCreate(
            [
                'service_id' => $service->id,
                'name' => 'Upload Surat Permohonan',
            ],
            [
                'type' => 'file',
                'is_required' => true,
            ]
        );
    }
}
