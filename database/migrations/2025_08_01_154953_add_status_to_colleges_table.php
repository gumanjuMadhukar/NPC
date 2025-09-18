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
        Schema::table('colleges', function (Blueprint $table) {
            if (!Schema::hasColumn('colleges', 'status')) {
                $table->boolean('status')->default(1)->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            if (Schema::hasColumn('colleges', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
