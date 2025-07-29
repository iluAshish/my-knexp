<?php

namespace Database\Seeders;
use App\Models\HomeSlider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeSlider::create([
            'title' => 'Your Title',
            'sub_title' => 'Your Subtitle',
            'image' => 'path_to_your_image.jpg',
            'image_webp' => 'path_to_your_image_webp.webp',
            'image_attribute' => 'alt="Slider"',
            'button_txt' => 'Learn More',
            'button_url' => '#',
            'sort_order' => 0,
            'status' => 1,
            'created_by' => 1
        ]);
    }
}
