<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_information', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name');
            $table->string('adminemail');
            $table->string('logo'); // File path for the main logo
            $table->string('logo_webp'); // File path for the WebP version of the main logo
            $table->string('logo_attribute')->nullable(); // Additional attributes for the main logo (nullable)
            $table->string('dashboard_logo'); // File path for the dashboard logo
            $table->string('footer_logo'); // File path for the footer logo
            $table->string('footer_logo_webp'); // File path for the WebP version of the footer logo
            $table->string('footer_logo_attribute')->nullable(); // Additional attributes for the footer logo (nullable)
            $table->string('phone');
            $table->string('landline')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('email');
            $table->string('alternate_email')->nullable();
            $table->string('email_recipient')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('snapchat_url')->nullable();
            $table->string('pinterest_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('address')->nullable();
            $table->string('location')->nullable();
            $table->text('footer_text')->nullable();
            $table->text('header_tag')->nullable();
            $table->text('footer_tag')->nullable();
            $table->text('body_tag')->nullable();

            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_information');
    }
};
