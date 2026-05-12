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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nama', '100');
            $table->string('deskripsi');
            $table->text('alamat');
            $table->string('telepon', '15')->nullable();
            $table->string('email', '50')->nullable();
            $table->string('website', '150')->nullable();
            $table->string('koordinat', '100')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
