<?php

namespace Database\Seeders;

use App\Models\Master\Identity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Identity::create([
            'name' => 'Dinas Komunikasi dan Informatika Kabupaten Rejang Lebong',
            'description' => 'Dinas Komunikasi dan Informatika yang selanjutnya disebut Diskominfo adalah perangkat Daerah yang menyelenggarakan urusan pemerintahan Daerah bidang komunikasi dan informatika, bidang persandian, dan bidang statistik.
            Diskominfo mempunyai tugas membantu Bupati melaksanakan urusan pemerintahan yang menjadi kewenangan Daerah dan tugas pembantuan yang diberikan kepada Daerah di bidang komunikasi dan informatika, bidang persandian, dan bidang statistik.',
            'favicon' => 'favicon-diskominfo-rejang-lebong.png',
            'logo' => 'logo.png',
            'email' => 'diskominfo.rl@gmail.com',
            'address' => 'Talang Rimbo Lama, Curup Tengah, Kabupaten Rejang Lebong, Bengkulu',
            'google_maps' => '<iframe class="w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d773.896873197161!2d102.53107952635175!3d-3.47768392982418!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e313a1f915c2389%3A0x72712068e09a9f77!2sDISKOMINFO%20Kabupaten%20Rejang%20Lebong!5e0!3m2!1sid!2sid!4v1746873559344!5m2!1sid!2sid" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'phone' => '(0732) 3932323',
            'facebook' => 'https://www.facebook.com/',
            'instagram' => 'https://www.instagram.com/',
            'youtube' => 'https://www.youtube.com/',
            'twitter' => 'https://www.x.com/',
            'vision_mission' => 'Visi dan Misi Dinas Komunikasi dan Informatika adalah ....',
            'task_function' => 'Tugas dan Fungsi Dinas Komunikasi dan Informatika adalah ....',
        ]);
    }
}
