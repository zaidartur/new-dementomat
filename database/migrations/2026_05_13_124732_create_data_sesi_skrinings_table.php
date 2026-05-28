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
            $table->uuid('uid_keluarga')->nullable();
            $table->foreign('uid_keluarga')->references('uid_keluarga')->on('data_keluargas')->nullOnDelete()->cascadeOnUpdate();

            $table->integer('umur_saat_skrining');
            $table->foreignId('kategori_id')->nullable()->constrained('master_kategori_skrinings')->nullOnDelete()->cascadeOnUpdate();
            
            $table->uuid('triggered_rule_id')->nullable();
            $table->foreign('triggered_rule_id')->references('uid_rule')->on('data_rule_skrinings')->nullOnDelete()->cascadeOnUpdate();

            $table->string('location', '100')->nullable();
            $table->enum('status_skrining', ['valid', 'batal'])->default('valid');
            $table->text('alasan_batal')->nullable();
            $table->date('tgl_tcm')->nullable();
            $table->enum('hasil_tcm', ['positive', 'negative'])->nullable();
            $table->enum('jenis_tcm', ['mandiri', 'faskes'])->nullable();
            $table->string('file_tcm')->nullable();
            $table->dateTime('deleted_at')->nullable();
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
