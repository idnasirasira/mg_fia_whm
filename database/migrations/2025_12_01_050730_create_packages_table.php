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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inbound_shipment_id')->nullable()->constrained('inbound_shipments')->onDelete('cascade');
            $table->foreignId('outbound_shipment_id')->nullable()->constrained('outbound_shipments')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->integer('quantity')->default(1);
            $table->decimal('weight', 10, 2)->nullable(); // in kg
            $table->string('dimensions')->nullable(); // format: "LxWxH" in cm
            $table->decimal('value', 15, 2)->default(0); // monetary value
            $table->string('status')->default('pending'); // pending, received, stored, packed, shipped, delivered
            $table->foreignId('location_id')->nullable()->constrained('warehouses')->onDelete('set null');
            $table->json('customs_info')->nullable(); // HS code, description, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
