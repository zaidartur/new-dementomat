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
        Schema::create('kontaks', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kontak', '100');
            $table->string('nama_kontak', '100');
            $table->string('nomor_wa', '15');
            $table->uuid('id_faskes')->nullable();
            $table->foreign('id_faskes')->references('faskes_id')->on('faskes')->nullOnDelete()->cascadeOnUpdate();

            $table->uuid('uid_user')->nullable();
            $table->foreign('uid_user')->references('uuid')->on('users')->nullOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontaks');
    }
};
