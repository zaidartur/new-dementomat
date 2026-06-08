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
        Schema::create('pantauan_berat_badans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid_keluarga')->nullable();
            $table->foreign('uid_keluarga')->references('uid_keluarga')->on('data_keluargas')->nullOnDelete()->cascadeOnUpdate();

            $table->uuid('uid_sesi')->nullable();
            $table->foreign('uid_sesi')->references('uid_sesi')->on('data_sesi_skrinings')->nullOnDelete()->cascadeOnDelete();

            $table->integer('bulan_live');
            $table->integer('bulan_ke');
            $table->decimal('berat_badan', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pantauan_berat_badans');
    }
};
