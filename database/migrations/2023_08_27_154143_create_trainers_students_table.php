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
        Schema::create('trainers_students', function (Blueprint $table) {
            $table->foreignId("student_id")->constrained("students")->cascadeOnDelete();
            $table->foreignId("personal_id")->constrained("personal_trainers")->cascadeOnDelete();
            $table->timestamps();
            $table->primary(["student_id", "personal_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainers_students');
    }
};
