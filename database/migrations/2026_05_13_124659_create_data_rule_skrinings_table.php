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
        Schema::create('data_rule_skrinings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid_rule')->unique();
            $table->foreignId('kategori_id')->nullable()->constrained('master_kategori_skrinings')->nullOnDelete()->cascadeOnUpdate();
            $table->string('nama_aturan', '200');
            $table->text('rekomendasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_rule_skrinings');
    }
};
