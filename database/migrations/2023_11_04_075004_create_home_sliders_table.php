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
        Schema::create('home_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title');
            $table->string('image'); // File path for the image
            $table->string('image_webp'); // File path for the WebP version of the image
            $table->string('image_attribute')->nullable(); // Additional image attributes if needed
            $table->string('button_txt');
            $table->string('button_url');
            $table->integer('sort_order')->default(0); // Sort order for displaying sliders
            $table->tinyInteger('status')->default(1); // 1: Active, 0: Inactive

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
        Schema::dropIfExists('home_sliders');
    }
};
