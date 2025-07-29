<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Service 1',
                'description' => 'Description for Service 1',
                'image' => 'path/to/image1.jpg',
                'image_webp' => 'path/to/webp/image1.webp',
                'image_attribute' => 'Additional attributes for Service 1 image',
                'icon' => 'path/to/icon1.jpg',
                'icon_webp' => 'path/to/webp/icon1.webp',
                'icon_attribute' => 'Additional attributes for Service 1 icon',
                'sort_order' => 1,
                'status' => 1,
            ],
            [
                'title' => 'Service 2',
                'description' => 'Description for Service 2',
                'image' => 'path/to/image2.jpg',
                'image_webp' => 'path/to/webp/image2.webp',
                'image_attribute' => 'Additional attributes for Service 2 image',
                'icon' => 'path/to/icon2.jpg',
                'icon_webp' => 'path/to/webp/icon2.webp',
                'icon_attribute' => 'Additional attributes for Service 2 icon',
                'sort_order' => 2,
                'status' => 1,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
