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
        Schema::create('outbound_shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->date('shipping_date');
            $table->string('carrier')->nullable(); // shipping carrier name
            $table->string('destination_country');
            $table->string('status')->default('pending'); // pending, packed, shipped, in_transit, delivered, returned
            $table->decimal('customs_value', 15, 2)->default(0);
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->foreignId('shipping_zone_id')->nullable()->constrained('shipping_zones')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outbound_shipments');
    }
};
