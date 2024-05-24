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
        Schema::create('category_company', function (Blueprint $table) {
            $table->foreignId('company_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->integer('user_id')->constrained();
            $table->primary(['company_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_company');
    }
};
