<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad;
use Illuminate\Support\Carbon;

class AdSeeder extends Seeder
{
    public function run()
    {
        Ad::updateOrCreate(
            ['position' => 'search-ad-1'],
            [
                'name' => 'Search Banner 1',
                'image_path' => 'images/ads/ad-1.png',
                'url' => 'https://example.com/promo-1',
                'is_active' => true,
                'starts_at' => Carbon::now()->subDays(30),
                'ends_at' => null,
                'priority' => 1,
            ]
        );

        Ad::updateOrCreate(
            ['position' => 'search-ad-2'],
            [
                'name' => 'Search Banner 2',
                'image_path' => 'images/ads/ad-2.png',
                'url' => 'https://example.com/promo-2',
                'is_active' => true,
                'starts_at' => Carbon::now()->subDays(30),
                'ends_at' => null,
                'priority' => 2,
            ]
        );
    }
}