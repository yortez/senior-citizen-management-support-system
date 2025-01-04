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
        Schema::table('senior_citizens', function (Blueprint $table) {
            $table->string('full_name')->virtualAs("
                last_name || ' ' ||
                first_name || ' ' ||
                COALESCE(middle_name, '') || ' ' ||
                COALESCE(extension, '')
            ")->after('extension')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('senior_citizens', function (Blueprint $table) {
            $table->dropColumn('full_name');
        });
    }
};
