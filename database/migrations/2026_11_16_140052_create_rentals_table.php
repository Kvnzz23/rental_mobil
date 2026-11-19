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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id('id_rental');
            $table->foreignId('customer_id')->constrained(table: 'customers', column: 'id_customer')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('car_id')->constrained(table: 'cars', column: 'id_cars')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->decimal('total_harga', 12, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
