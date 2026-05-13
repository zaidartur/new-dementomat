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
        Schema::create('data_response_skrinings', function (Blueprint $table) {
            $table->id();
            $table->uuid('sesi_uid');
            $table->foreign('sesi_uid')->references('uid_sesi')->on('data_sesi_skrinings');

            $table->uuid('parameter_uid');
            $table->foreign('parameter_uid')->references('uid_parameter')->on('master_parameter_skrinings');

            $table->boolean('is_yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_response_skrinings');
    }
};
