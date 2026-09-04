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
        Schema::create('before_after_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_title'); // e.g. "Acne Gd 3, EPA"
            $table->string('image_path'); // path to uploaded before-after split image
            $table->string('doctor_or_branch')->nullable()->default('Gitania Skin Clinic'); // e.g. "Treatment by : dr. Farah"
            $table->string('hashtag')->nullable(); // e.g. "#JUARANYA ATASI MASALAH KULIT"
            $table->text('description'); // Patient case explanation
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('before_after_cases');
    }
};
