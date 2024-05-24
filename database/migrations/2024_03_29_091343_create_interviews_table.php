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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('interview_date')->nullable();
            $table->string('interview_time')->nullable();
            $table->string('interview_venue')->nullable();
            $table->string('reschedule_date')->nullable();
            $table->string('reschedule_time')->nullable();
            $table->string('reschedule_venue')->nullable();
            $table->text('reschedule_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
