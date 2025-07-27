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
        Schema::create('exam_applies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('voucher_image')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('subject_committee_count')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->integer('attempt')->default(0);
            $table->boolean('is_admit_card_generate')->default(0)->comment('0 = No, 1 = Yes');
            $table->boolean('is_certificate_generate')->default(0)->comment('0 = No, 1 = Yes');
            $table->boolean('is_passed')->default(0)->comment('0 = No, 1 = Yes');
            $table->boolean('rejected')->default(0)->comment('0 = No, 1 = Yes');
            $table->enum('state', ['operator', 'officer', 'registrar','subject_committee','exam_committee','council','onhold'])->default('operator')->nullable();
            $table->enum('status', ['pending','progress','accepted','rejected','re-exam','onhold','re-check'])->default('pending')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('exam_id')->references('id')->on('exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('program_id')->references('id')->on('programs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_applies');
    }
};
