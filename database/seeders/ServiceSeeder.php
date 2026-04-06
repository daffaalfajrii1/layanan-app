<?php

namespace Database\Seeders;

use App\Models\Service\Service;
use App\Models\Service\ServiceDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'Pendaftaran Email Dinas',
            'slug' => 'pendaftaran-email-dinas',
        ]);

        Service::create([
            'name' => 'Permohonan TTE',
            'slug' => 'permohonan-tte',
        ]);

        Service::create([
            'name' => 'Sub Domain Aplikasi/Website',
            'slug' => 'sub-domain-aplikasi-website',
        ]);

        Service::create([
            'name' => 'Pendaftaran Hosting',
            'slug' => 'pendaftaran-hosting',
        ]);

        Service::create([
            'name' => 'Permohonan Fasilitas Vidcon',
            'slug' => 'permohonan-fasilitas-vidcon',
        ]);

        Service::create([
            'name' => 'Coaching Clinic Aplikasi',
            'slug' => 'coaching-clinic-aplikasi',
        ]);

        Service::create([
            'name' => 'Fasilitas Peliputan',
            'slug' => 'fasilitas-peliputan',
        ]);

        Service::create([
            'name' => 'Pelaporan Konten Negatif',
            'slug' => 'pelaporan-konten-negatif',
        ]);

        Service::create([
        'name' => 'Permohonan Akses API',
        'slug' => 'permohonan-akses-api',
        ]);

        $documentLayanan1 = [
            ['name' => 'Nama Pegawai', 'type' => 'text', 'is_required' => true],
            ['name' => 'NIP', 'type' => 'text', 'is_required' => true],
            ['name' => 'Alamat Email', 'type' => 'text', 'is_required' => true],
            ['name' => 'Jabatan', 'type' => 'text', 'is_required' => true],
            ['name' => 'No. Kontak', 'type' => 'text', 'is_required' => true],
            ['name' => 'Upload Surat Permohonan', 'type' => 'file', 'is_required' => true],
        ];

        $documentLayanan2 = [
            ['name' => 'Nama Pegawai', 'type' => 'text', 'is_required' => true],
            ['name' => 'NIK Pegawai', 'type' => 'text', 'is_required' => true],
            ['name' => 'Email Dinas', 'type' => 'email', 'is_required' => true],
            ['name' => 'Jabatan', 'type' => 'text', 'is_required' => true],
            ['name' => 'No. Kontak', 'type' => 'text', 'is_required' => true],
            ['name' => 'Unit Kerja', 'type' => 'text', 'is_required' => true],
            ['name' => 'Kegunaan', 'type' => 'text', 'is_required' => true],
            ['name' => 'Upload KTP', 'type' => 'file', 'is_required' => true],
            ['name' => 'Upload Surat Permohonan', 'type' => 'file', 'is_required' => true],
        ];

        $documentLayanan3 = [
            ['name' => 'Nama Instansi', 'type' => 'text', 'is_required' => false],
            ['name' => 'Nama Kepala Instansi', 'type' => 'text', 'is_required' => true],
            ['name' => 'Nama Aplikasi/Website', 'type' => 'email', 'is_required' => true],
            ['name' => 'Nama PIC', 'type' => 'text', 'is_required' => true],
            ['name' => 'NIP', 'type' => 'text', 'is_required' => true],
            ['name' => 'Jabatan', 'type' => 'text', 'is_required' => true],
            ['name' => 'No. Kontak', 'type' => 'text', 'is_required' => true],
            ['name' => 'IP Address', 'type' => 'text', 'is_required' => true],
            ['name' => 'Nama Sub Domain', 'type' => 'text', 'is_required' => true],
            ['name' => 'Informasi Sub Domain', 'type' => 'text', 'is_required' => true],
        ];

        $documentLayanan4 = [
            ['name' => 'Nama Instansi', 'type' => 'text', 'is_required' => false],
            ['name' => 'Nama Kepala Instansi', 'type' => 'text', 'is_required' => true],
            ['name' => 'Nama PIC', 'type' => 'text', 'is_required' => true],
            ['name' => 'NIP', 'type' => 'text', 'is_required' => true],
            ['name' => 'Jabatan', 'type' => 'text', 'is_required' => true],
            ['name' => 'No. Kontak', 'type' => 'text', 'is_required' => true],
            ['name' => 'Nama Sub Domain', 'type' => 'text', 'is_required' => true],
            ['name' => 'Informasi Website/Aplikasi', 'type' => 'text', 'is_required' => true],
        ];

        $documentLayanan5 = [
            ['name' => 'Nama Instansi', 'type' => 'text', 'is_required' => true],
            ['name' => 'Nama Kepala Instansi', 'type' => 'text', 'is_required' => true],
            ['name' => 'Nama PIC', 'type' => 'text', 'is_required' => true],
            ['name' => 'No. Kontak', 'type' => 'text', 'is_required' => true],
            ['name' => 'Waktu Kegiatan', 'type' => 'date', 'is_required' => true],
            ['name' => 'Jam Kegiatan', 'type' => 'time', 'is_required' => true],
            ['name' => 'Nama Kegiatan', 'type' => 'text', 'is_required' => true],
            ['name' => 'Tempat Kegiatan', 'type' => 'text', 'is_required' => true],
            ['name' => 'Upload Surat Permohonan', 'type' => 'file', 'is_required' => true],
        ];

        $documentLayanan6 = [
            ['name' => 'Nama Instansi Pemohon', 'type' => 'text', 'is_required' => true],
            ['name' => 'Nama Kepala Instansi', 'type' => 'text', 'is_required' => true],
            ['name' => 'Nama Aplikasi yang Perlu Pendamping', 'type' => 'text', 'is_required' => true],
            ['name' => 'No. Kontak', 'type' => 'text', 'is_required' => true],
            ['name' => 'Tanggal Kegiatan', 'type' => 'date', 'is_required' => true],
            ['name' => 'Jam Kegiatan', 'type' => 'time', 'is_required' => true],
            ['name' => 'Nama PIC', 'type' => 'text', 'is_required' => true],
            ['name' => 'Jabatan', 'type' => 'text', 'is_required' => true],
            ['name' => 'Upload Surat Permohonan', 'type' => 'file', 'is_required' => true],
        ];

        $documentLayanan7 = [
            ['name' => 'Nama Instansi', 'type' => 'text', 'is_required' => true],
            ['name' => 'Nama Kepala Instansi', 'type' => 'text', 'is_required' => true],
            ['name' => 'Nama Aplikasi yang Perlu Pendamping', 'type' => 'text', 'is_required' => true],
            ['name' => 'No. Kontak', 'type' => 'text', 'is_required' => true],
            ['name' => 'Tanggal Kegiatan', 'type' => 'date', 'is_required' => true],
            ['name' => 'Jam Kegiatan', 'type' => 'time', 'is_required' => true],
            ['name' => 'Nama PIC', 'type' => 'text', 'is_required' => true],
            ['name' => 'Jabatan', 'type' => 'text', 'is_required' => true],
            ['name' => 'Upload Surat Permohonan', 'type' => 'file', 'is_required' => true],
        ];

        $documentLayanan8 = [
            ['name' => 'Nama Pelapor', 'type' => 'text', 'is_required' => true],
            ['name' => 'Alamat Pelapor', 'type' => 'text', 'is_required' => true],
            ['name' => 'Pekerjaan', 'type' => 'text', 'is_required' => true],
            ['name' => 'No. Kontak', 'type' => 'text', 'is_required' => true],
            ['name' => 'Alamat', 'type' => 'text', 'is_required' => true],
            ['name' => 'Email', 'type' => 'email', 'is_required' => true],
            ['name' => 'Jenis Konten yang dilapor', 'type' => 'text', 'is_required' => true],
            ['name' => 'Alamat/Link Konten', 'type' => 'text', 'is_required' => true],
            ['name' => 'Alasan Pelaporan', 'type' => 'text', 'is_required' => true],
            ['name' => 'Upload Screenshot Konten', 'type' => 'file', 'is_required' => true],
            ['name' => 'Upload Surat Permohonan', 'type' => 'file', 'is_required' => true],
        ];

        $documentLayanan9 = [
        ['name' => 'Nama Instansi', 'type' => 'text', 'is_required' => true],
        ['name' => 'Nama PIC', 'type' => 'text', 'is_required' => true],
        ['name' => 'Email', 'type' => 'email', 'is_required' => true],
        ['name' => 'No. Kontak', 'type' => 'text', 'is_required' => true],
        ['name' => 'Tujuan Akses API', 'type' => 'text', 'is_required' => true],
        ['name' => 'Dokumentasi Teknis', 'type' => 'file', 'is_required' => false],
        ];

        foreach (Service::all() as $service) {
            switch ($service->slug) {
                case 'pendaftaran-email-dinas':
                    foreach ($documentLayanan1 as $document) {
                        ServiceDocument::create([
                            'service_id' => $service->id,
                            'name' => $document['name'],
                            'type' => $document['type'],
                            'is_required' => $document['is_required'],
                        ]);
                    }
                    break;
                case 'permohonan-tte':
                    foreach ($documentLayanan2 as $document) {
                        ServiceDocument::create([
                            'service_id' => $service->id,
                            'name' => $document['name'],
                            'type' => $document['type'],
                            'is_required' => $document['is_required'],
                        ]);
                    }
                    break;
                case 'sub-domain-aplikasi-website':
                    foreach ($documentLayanan3 as $document) {
                        ServiceDocument::create([
                            'service_id' => $service->id,
                            'name' => $document['name'],
                            'type' => $document['type'],
                            'is_required' => $document['is_required'],
                        ]);
                    }
                    break;
                case 'pendaftaran-hosting':
                    foreach ($documentLayanan4 as $document) {
                        ServiceDocument::create([
                            'service_id' => $service->id,
                            'name' => $document['name'],
                            'type' => $document['type'],
                            'is_required' => $document['is_required'],
                        ]);
                    }
                    break;
                case 'permohonan-fasilitas-vidcon':
                    foreach ($documentLayanan5 as $document) {
                        ServiceDocument::create([
                            'service_id' => $service->id,
                            'name' => $document['name'],
                            'type' => $document['type'],
                            'is_required' => $document['is_required'],
                        ]);
                    }
                    break;
                case 'coaching-clinic-aplikasi':
                    foreach ($documentLayanan6 as $document) {
                        ServiceDocument::create([
                            'service_id' => $service->id,
                            'name' => $document['name'],
                            'type' => $document['type'],
                            'is_required' => $document['is_required'],
                        ]);
                    }
                    break;
                case 'fasilitas-peliputan':
                    foreach ($documentLayanan7 as $document) {
                        ServiceDocument::create([
                            'service_id' => $service->id,
                            'name' => $document['name'],
                            'type' => $document['type'],
                            'is_required' => $document['is_required'],
                        ]);
                    }
                    break;
                case 'pelaporan-konten-negatif':
                    foreach ($documentLayanan8 as $document) {
                        ServiceDocument::create([
                            'service_id' => $service->id,
                            'name' => $document['name'],
                            'type' => $document['type'],
                            'is_required' => $document['is_required'],
                        ]);
                    }
                    break;
                case 'permohonan-akses-api':
                foreach ($documentLayanan9 as $document) {
                    ServiceDocument::create([
                        'service_id' => $service->id,
                        'name' => $document['name'],
                        'type' => $document['type'],
                        'is_required' => $document['is_required'],
                    ]);
                }
                break;
                default:
                    break;
            }
        }
    }
}
