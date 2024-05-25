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
        Schema::create('company_demands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->string('demand_code');
            $table->string('quota');
            $table->string('gender');
            $table->string('age_from');
            $table->string('age_to');
            $table->string('height');
            $table->string('weight');
            $table->string('experience_year');
            $table->string('education');
            $table->integer('edu_level');
            $table->longText('demand_letter');
            $table->enum('status', ['Open', 'Close', 'Completed', 'New', 'Pending', 'Rejected', 'Approved', 'Interview'])->default('Pending'); // Default to 'pending'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('company_demands');
        Schema::enableForeignKeyConstraints();
    }
};
