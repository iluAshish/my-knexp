<?php

namespace Database\Seeders;

use App\Models\Enquiry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enquiries = [
            [
                'enquiry_type' => 'General',
                'request_url' => 'https://example.com/contact',
                'name' => 'John Doe',
                'phone' => '1234567890',
                'email' => 'john@example.com',
                'service_id' => 1,
                'message' => 'This is a sample message for the enquiry.',
                'reply' => 'Thank you for your message. We will get back to you soon.',
                'reply_date' => now()
            ],
            [
                'enquiry_type' => 'General',
                'request_url' => 'https://example.com/contact',
                'name' => 'John Doe',
                'phone' => '1234567890',
                'email' => 'john@example.com',
                'service_id' => 1,
                'message' => 'This is a sample message for the enquiry.',
                'reply' => 'Thank you for your message. We will get back to you soon.',
                'reply_date' => now()
            ],
            [
                'enquiry_type' => 'General',
                'request_url' => 'https://example.com/contact',
                'name' => 'John Doe',
                'phone' => '1234567890',
                'email' => 'john@example.com',
                'service_id' => 1,
                'message' => 'This is a sample message for the enquiry.',
                'reply' => 'Thank you for your message. We will get back to you soon.',
                'reply_date' => now()
            ],
            [
                'enquiry_type' => 'General',
                'request_url' => 'https://example.com/contact',
                'name' => 'John Doe',
                'phone' => '1234567890',
                'email' => 'john@example.com',
                'service_id' => 1,
                'message' => 'This is a sample message for the enquiry.',
                'reply' => 'Thank you for your message. We will get back to you soon.',
                'reply_date' => now()
            ],
        ];

        foreach ($enquiries as $enquiry) {
            Enquiry::create($enquiry);
        }
    }
}
