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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('enquiry_type');
            $table->string('request_url')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->unsignedBigInteger('service_id')->nullable(); // Foreign key referencing services table
            $table->text('message');
            $table->text('reply')->nullable();
            $table->timestamp('reply_date')->nullable();

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
        Schema::dropIfExists('enquiries');
    }
};
