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
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('full_name')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('temporary_address')->nullable();
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('marital_status');
            $table->string('spouse_name')->nullable();
            $table->string('gender');
            $table->string('height');
            $table->string('weight');
            $table->string('dob');
            $table->integer('age');
            $table->boolean('has_relatives_in_malaysia')->default(false);
            $table->boolean('has_been_in_accident')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
