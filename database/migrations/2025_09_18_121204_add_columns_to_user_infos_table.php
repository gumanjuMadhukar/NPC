<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_infos', function (Blueprint $table) {
            $table->string('father_number', 20)->after('father_name_nep');
            $table->string('father_email')->after('father_number');
            $table->string('mother_number', 20)->after('mother_name_nep');
            $table->string('mother_email')->after('mother_number');
            $table->string('grandfather_number', 20)->after('grandfather_name_nep');
            $table->string('grandfather_email')->after('grandfather_number');
            $table->string('spouse_name')->nullable()->after('grandfather_email');
            $table->string('spouse_name_nep')->nullable()->after('spouse_name');
            $table->string('spouse_number', 20)->after('spouse_name_nep');
            $table->string('spouse_email')->after('spouse_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_infos', function (Blueprint $table) {
            $table->dropColumn(['father_number', 'father_email','mother_number', 'mother_email','grandfather_number', 'grandfather_email','spouse_name', 'spouse_name_nep','spouse_number', 'spouse_email',]);
        });
    }
};
