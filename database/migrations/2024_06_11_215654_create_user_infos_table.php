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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name_nep')->nullable();
            $table->string('middle_name_nep')->nullable();
            $table->string('last_name_nep')->nullable();
            $table->date('dob_eng')->nullable();
            $table->date('dob_nep')->nullable();
            $table->enum('sex', ['male','female','other'])->default('male')->nullable();
            $table->enum('marital_status', ['married', 'unmarried'])->default('unmarried')->nullable();
            $table->string('ethinic')->nullable();
            $table->string('citizenship_number')->nullable();
            $table->date('citizenship_issue_date')->nullable();
            $table->string('citizenship_issue_district')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_name_nep')->nullable();
            $table->string('grandfather_name')->nullable();
            $table->string('grandfather_name_nep')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_name_nep')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('municipality_id')->nullable();
            $table->string('ward_no')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('citizenship_front')->nullable();
            $table->string('citizenship_back')->nullable();
            $table->string('signature_image')->nullable();
            $table->enum('profile_state', ['student','operator', 'officer', 'registrar','subject_committee','exam_committee','council','onhold'])->default('student')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
