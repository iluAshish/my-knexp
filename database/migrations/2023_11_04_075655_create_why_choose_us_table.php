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
        Schema::create('why_choose_us', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title');
            $table->string('image'); // File path for the main image
            $table->string('image_webp'); // File path for the WebP version of the image
            $table->string('image_attribute')->nullable(); // Additional image attributes if needed
            $table->string('icon_1')->nullable(); // File path for the first icon (nullable)
            $table->string('icon_title_1')->nullable(); // Title for the first icon (nullable)
            $table->text('icon_desc_1')->nullable(); // Description for the first icon (nullable)
            $table->string('icon_2')->nullable(); // File path for the second icon (nullable)
            $table->string('icon_title_2')->nullable(); // Title for the second icon (nullable)
            $table->text('icon_desc_2')->nullable(); // Description for the second icon (nullable)
            $table->string('icon_3')->nullable(); // File path for the third icon (nullable)
            $table->string('icon_title_3')->nullable(); // Title for the third icon (nullable)
            $table->text('icon_desc_3')->nullable(); // Description for the third icon (nullable)

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
        Schema::dropIfExists('why_choose_us');
    }
};
