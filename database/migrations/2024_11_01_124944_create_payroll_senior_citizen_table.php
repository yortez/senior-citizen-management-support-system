<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Payroll;
use App\Models\SeniorCitizen;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payroll_senior_citizen', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Payroll::class);
            $table->foreignIdFor(SeniorCitizen::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_senior_citizen');
    }
};
