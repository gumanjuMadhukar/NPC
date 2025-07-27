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
        Schema::create('certificate_renew_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('level_id')->nullable();
            $table->string('program_id')->nullable();
            $table->string('cert_registration_number')->nullable();
            $table->string('voucher_image')->nullable();
            $table->boolean('status')->default(0)->comment('0 = inactive, 1 = active');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_renew_requests');
    }
};
