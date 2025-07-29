<?php

namespace Database\Seeders;

use App\Models\WhyChooseUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhyChooseUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WhyChooseUs::create([
            'title' => 'Example Title',
            'sub_title' => 'Example Subtitle',
            'image' => 'example_image.jpg',
            'image_webp' => 'example_image.webp',
            'image_attribute' => 'example_attribute',
            'icon_1' => 'example_icon_1.jpg',
            'icon_title_1' => 'Example Icon Title 1',
            'icon_desc_1' => 'Example Icon Description 1',
            'icon_2' => 'example_icon_2.jpg',
            'icon_title_2' => 'Example Icon Title 2',
            'icon_desc_2' => 'Example Icon Description 2',
            'icon_3' => 'example_icon_3.jpg',
            'icon_title_3' => 'Example Icon Title 3',
            'icon_desc_3' => 'Example Icon Description 3',
            'created_by' => 1,
        ]);

    }
}
