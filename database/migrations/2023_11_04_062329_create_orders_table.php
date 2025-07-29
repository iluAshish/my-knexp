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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_number')->unique();

            $table->unsignedBigInteger('customer_id');
            $table->date('shipment_date');

            $table->string('status')->default('Shipment Received');

            $table->integer('items');
            $table->unsignedBigInteger('origin'); // Foreign key referencing branch_id
            $table->unsignedBigInteger('destination'); // Foreign key referencing state_id

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('servicetype')->nullable();

            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Index and foreign key declarations
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('origin')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('destination')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};