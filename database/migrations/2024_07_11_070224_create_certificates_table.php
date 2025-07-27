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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registration_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->string('program_certificate_code')->nullable();
            $table->unsignedBigInteger('srn');
            $table->string('cert_registration_number');
            $table->string('registrar')->nullable();
            $table->string('name');
            $table->string('date_of_birth');
            $table->string('address')->comment('zone, district, vdc, ward_no');
            $table->string('qualification')->nullable();
            $table->date('decision_date');
            $table->integer('issued_year')->nullable();
            $table->date('issued_date')->nullable();
            $table->date('valid_till')->nullable();
            $table->string('certificate')->default('new');
            $table->string('type')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('is_printed')->default(0);
            $table->date('printed_date')->nullable();
            $table->unsignedBigInteger('printed_by')->nullable();
            $table->boolean('is_edited')->default(0);
            $table->unsignedBigInteger('issued_by')->nullable();
            $table->enum('certificate_status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('program_id')->references('id')->on('programs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('printed_by')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete()->nullable();
            $table->foreign('issued_by')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
