<?php

namespace Database\Seeders;

use App\Models\keyFeature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeyFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        keyFeature::create([
            'title' => 'Key Feature 1',
            'counter' => 500,
            'image' => 'example_image.jpg',
            'image_webp' => 'example_image.webp',
            'image_attribute' => 'example_attribute',
            'sort_order' => 1,
            'status' => 1,
            'created_by' => 1,
        ]);
        keyFeature::create([
            'title' => 'Key Feature 1',
            'counter' => 500,
            'image' => 'example_image.jpg',
            'image_webp' => 'example_image.webp',
            'image_attribute' => 'example_attribute',
            'sort_order' => 2,
            'status' => 1,
            'created_by' => 1,
        ]);
    }
}
