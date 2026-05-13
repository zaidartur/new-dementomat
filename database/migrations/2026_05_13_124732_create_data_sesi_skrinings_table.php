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
        Schema::create('data_sesi_skrinings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid_sesi')->unique();
            $table->uuid('uid_keluarga');
            $table->foreign('uid_keluarga')->references('uid_keluarga')->on('data_keluargas');

            $table->integer('umur_saat_skrining');
            $table->foreignId('kategori_id')->nullable()->constrained('master_kategori_skrinings')->nullOnDelete()->cascadeOnUpdate();
            $table->uuid('triggered_rule_id')->nullable();
            $table->foreign('triggered_rule_id')->references('uid_rule')->on('data_rule_skrinings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_sesi_skrinings');
    }
};
