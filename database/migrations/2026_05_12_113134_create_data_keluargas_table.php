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
            $table->uuid('uid_keluarga')->unique();
            $table->uuid('parent_user')->nullable();
            $table->foreign('parent_user')->references('uuid')->on('users')->nullOnDelete()->cascadeOnUpdate();

            $table->boolean('is_auth')->default(0);
            $table->string('nama_lengkap', '150');
            $table->string('nik', '16')->unique();
            $table->text('alamat_nik')->nullable();
            $table->string('telepon', '15')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenkel', ['L', 'P'])->nullable();
            $table->string('status_keluarga', '100')->nullable();

            $table->integer('kec_id')->nullable();
            $table->foreign('kec_id')->references('kec_id')->on('kecamatans')->nullOnDelete()->cascadeOnUpdate();
            
            $table->bigInteger('desakel_id')->nullable();
            $table->foreign('desakel_id')->references('desakel_id')->on('desas')->nullOnDelete()->cascadeOnUpdate();
            
            $table->uuid('id_faskes')->nullable();
            $table->foreign('id_faskes')->references('faskes_id')->on('faskes');

            $table->string('status_tbc', '200')->nullable();
            $table->text('catatan_perubahan_status')->nullable();
            $table->date('tgl_mulai_obat')->nullable();
            $table->dateTime('deleted_at')->nullable();
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
