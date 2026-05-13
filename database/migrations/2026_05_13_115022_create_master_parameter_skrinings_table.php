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
        Schema::create('master_parameter_skrinings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid_parameter')->unique();
            $table->foreignId('kategori_id')->nullable()->constrained('master_kategori_skrinings')->nullOnDelete()->cascadeOnUpdate();
            $table->string('kode', '10');
            $table->text('pertanyaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_parameter_skrinings');
    }
};
