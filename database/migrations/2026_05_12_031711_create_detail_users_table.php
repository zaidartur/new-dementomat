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
        Schema::create('detail_users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_user')->unique();
            $table->foreign('uuid_user')->references('uuid')->on('users');

            $table->string('nik', '16')->unique();
            $table->text('alamat_nik')->nullable();
            $table->string('telepon', '15')->nullable();
            $table->text('alamat')->nullable();

            $table->integer('kec_id')->nullable();
            $table->foreign('kec_id')->references('kec_id')->on('kecamatans');
            
            $table->bigInteger('desakel_id')->nullable();
            $table->foreign('desakel_id')->references('desakel_id')->on('desas');
            
            $table->uuid('id_faskes')->nullable();
            $table->foreign('id_faskes')->references('faskes_id')->on('faskes');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_users');
    }
};
