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
        Schema::create('fees', function (Blueprint $table){
            $table->id();

            // Relationships
            $table->unsignedBigInteger('name')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('amount')->nullable();
            $table->unsignedBigInteger('student_type')->nullable();
            $table->unsignedBigInteger('description')->nullable();
            $table->boolean('status')->default(1)->comment('0 = hide, 1 = show');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
