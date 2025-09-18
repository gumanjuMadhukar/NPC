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
            $table->string('phone_number', 20)->after('last_name_nep');
            $table->string('emergency_number', 20)->after('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_infos', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'emergency_number']);
        });
    }
};
