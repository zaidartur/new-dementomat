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
        Schema::create('faskes', function (Blueprint $table) {
            $table->id();
            $table->uuid('faskes_id')->unique();
            $table->string('nama_faskes', '100');
            $table->text('alamat_faskes')->nullable();
            
            $table->integer('kec_id');
            $table->foreign('kec_id')->references('kec_id')->on('kecamatans');

            $table->bigInteger('desakel_id');
            $table->foreign('desakel_id')->references('desakel_id')->on('desas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faskes');
    }
};
