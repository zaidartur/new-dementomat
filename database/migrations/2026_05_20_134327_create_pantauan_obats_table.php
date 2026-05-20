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
        Schema::create('pantauan_obats', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid_keluarga')->nullable();
            $table->foreign('uid_keluarga')->references('uid_keluarga')->on('data_keluargas')->nullOnDelete()->cascadeOnUpdate();

            $table->date('tanggal');
            $table->text('gejala_awal')->nullable();
            $table->boolean('efek_mual');
            $table->boolean('efek_pipis_merah');
            $table->boolean('efek_pendengaran');
            $table->boolean('efek_penglihatan');
            $table->boolean('efek_pegal');
            $table->boolean('efek_batuk');
            $table->boolean('efek_demam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pantauan_obats');
    }
};
