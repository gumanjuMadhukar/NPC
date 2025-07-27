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
        Schema::create('exam_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('system_user_id')->nullable();
            $table->unsignedBigInteger('exam_apply_id')->nullable();
            $table->string('remarks')->nullable();
            $table->enum('state', ['operator', 'officer', 'registrar','subject_committee','exam_committee','council'])->default('operator')->nullable();
            $table->enum('status', ['pending','progress','accepted','rejected'])->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('system_user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('exam_apply_id')->references('id')->on('exam_applies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_logs');
    }
};
