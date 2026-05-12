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
        Schema::create('data_keluargas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_user');
            $table->foreign('uuid_user')->references('uuid')->on('users');

            $table->string('nik_keluarga', '16')->unique();
            $table->string('nama_keluarga', '150');
            $table->date('tgl_lahir');
            $table->enum('jenkel', ['L', 'P']);
            $table->string('status_keluarga', '100');
            
            $table->foreignId('status_skrining')->nullable()->references('status_skrining')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_keluargas');
    }
};
