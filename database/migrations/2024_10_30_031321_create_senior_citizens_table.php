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
        Schema::create('senior_citizens', function (Blueprint $table) {
            $table->id();
            $table->integer('osca_id');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('extension');
            $table->date('birthday');
            $table->integer('age');
            $table->string('gender');
            $table->string('civil_status');
            $table->string('religion');
            $table->string('birth_place');

            $table->foreignId('city_id')
                ->constrained('cities')
                ->cascadeOnDelete();
            $table->foreignId('barangay_id')
                ->constrained('barangays')
                ->cascadeOnDelete();
            $table->foreignId('purok_id')
                ->constrained('puroks')
                ->cascadeOnDelete();

            $table->string('gsis_id');
            $table->string('philhealth_id');
            $table->string('illness');
            $table->string('disability');
            $table->string('educational_attainment');
            $table->boolean('is_active')->default(true);



            $table->text('registry_number')->default('none');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('senior_citizens');
    }
};
