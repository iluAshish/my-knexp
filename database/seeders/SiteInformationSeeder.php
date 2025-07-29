<?php

namespace Database\Seeders;

use App\Models\SiteInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteInformation::create([
            'brand_name' => 'Your Brand Name',
            'adminemail' => 'admin@example.com',
            'logo' => 'logo.png',
            'logo_webp' => 'logo.webp',
            'logo_attribute' => 'Your logo attributes',
            'dashboard_logo' => 'dashboard_logo.png',
            'footer_logo' => 'footer_logo.png',
            'footer_logo_webp' => 'footer_logo.webp',
            'footer_logo_attribute' => 'Your footer logo attributes',
            'phone' => '1234567890',
            'landline' => null,
            'whatsapp_number' => null,
            'email' => 'contact@example.com',
            'alternate_email' => null,
            'email_recipient' => null,
            'working_hours' => null,
            'facebook_url' => null,
            'instagram_url' => null,
            'linkedin_url' => null,
            'twitter_url' => null,
            'youtube_url' => null,
            'snapchat_url' => null,
            'pinterest_url' => null,
            'tiktok_url' => null,
            'address' => null,
            'location' => null,
            'footer_text' => null,
            'header_tag' => null,
            'footer_tag' => null,
            'body_tag' => null,
        ]);
    }
}
