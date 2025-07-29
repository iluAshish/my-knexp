<?php

namespace Database\Seeders;

use App\Models\HomeAboutUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeAboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeAboutUs::create([
            'title' => 'Example Title',
            'sub_title' => 'Example Subtitle',
            'image' => 'example_image.jpg',
            'image_webp' => 'example_image.webp',
            'image_attribute' => 'example_attribute',
            'description' => 'Example description text',
            'title_2' => 'Example Title 2',
            'description_2' => 'Example description text 2',
            'created_by' => 1,
        ]);
    }
}
