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
        Schema::create('data_screenings', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_screening')->unique();
            
            $table->string('nik', '16');
            $table->foreign('nik')->references('nik')->on('detail_users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_screenings');
    }
};
