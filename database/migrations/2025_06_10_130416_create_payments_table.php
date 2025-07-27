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
        Schema::create('payments', function (Blueprint $table){
            $table->id();

            // Relationships
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('exam_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();

            // Certificate details
            $table->string('cert_registration_number')->nullable();
            $table->string('transaction_id')->unique();
            $table->string('txnId')->nullable();
            $table->string('tidx')->nullable();
            $table->string('pidx')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->nullable();

            // Status fields
            $table->enum('status', ['active', 'inactive', 'expired'])->nullable();

            // PO and contact
            $table->string('purchase_order_name')->nullable();
            $table->string('purchase_order_id')->nullable();
            $table->string('mobile', 15)->nullable();

            // Image
            $table->string('voucher_image')->nullable();

            // System fields
            $table->boolean('is_active')->default(0)->comment('0 = inactive, 1 = active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
