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
        Schema::create('data_rule_kondisis', function (Blueprint $table) {
            $table->id();
            $table->uuid('rule_uid')->nullable();
            $table->foreign('rule_uid')->references('uid_rule')->on('data_rule_skrinings')->nullOnDelete()->cascadeOnUpdate();

            $table->uuid('parameter_uid')->nullable();
            $table->foreign('parameter_uid')->references('uid_parameter')->on('master_parameter_skrinings')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_rule_kondisis');
    }
};
