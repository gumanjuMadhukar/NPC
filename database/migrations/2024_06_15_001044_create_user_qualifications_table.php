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
        Schema::create('user_qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->string('name')->nullable();
            $table->string('board_university')->nullable();
            $table->date('passed_year')->nullable();
            $table->date('admission_year')->nullable();
            $table->string('college_name')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('transcript_image')->nullable();
            $table->string('provisional_image')->nullable();
            $table->string('character_image')->nullable();
            $table->string('ojt_image')->nullable();
            $table->string('visa_image')->nullable();
            $table->string('noc_image')->nullable();
            $table->string('intership_image')->nullable();
            $table->string('passport_image')->nullable();
            $table->string('licence')->nullable();
            $table->string('council_registration_certificate')->nullable(); 
            $table->string('ojt_pcl_community_1_image')->nullable();
            $table->string('ojt_pcl_community_2_image')->nullable();
            $table->string('transcript_mas_marksheet')->nullable();
            $table->string('transcript_bac_1')->nullable();
            $table->string('transcript_bac_2')->nullable();
            $table->string('transcript_bac_3')->nullable();
            $table->string('transcript_bac_4')->nullable();
            $table->string('transcript_bac_5')->nullable();
            $table->string('transcript_bac_6')->nullable();
            $table->string('transcript_bac_7')->nullable();
            $table->string('transcript_bac_8')->nullable();
            $table->string('migration_image')->nullable();
            $table->string('equivalence_certificate')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_qualifications');
    }
};
