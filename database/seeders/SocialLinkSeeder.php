<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialLink;

class SocialLinkSeeder extends Seeder
{
    public function run(): void
    {
        $socialLinks = [
            [
                'platform' => 'x',
                'name' => 'X (Twitter)',
                'url' => null, // Belum punya
                'icon' => 'x.svg',
                'is_active' => false,
                'order' => 10,
            ],
            [
                'platform' => 'tiktok',
                'name' => 'TikTok',
                'url' => null, // Belum punya
                'icon' => 'tiktok.svg',
                'is_active' => false,
                'order' => 20,
            ],
            [
                'platform' => 'youtube',
                'name' => 'YouTube',
                'url' => null, // Belum punya
                'icon' => 'youtube.svg',
                'is_active' => false,
                'order' => 30,
            ],
            [
                'platform' => 'facebook',
                'name' => 'Facebook',
                'url' => null, // Belum punya
                'icon' => 'facebook. svg',
                'is_active' => false,
                'order' => 40,
            ],
            [
                'platform' => 'instagram',
                'name' => 'Instagram',
                'url' => 'https://www.instagram.com/dmdi_magazine', // SUDAH PUNYA
                'icon' => 'instagram.svg',
                'is_active' => true, // Aktif karena sudah punya
                'order' => 50,
            ],
        ];

        foreach ($socialLinks as $link) {
            SocialLink::create($link);
        }
    }
}