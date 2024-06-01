<?php

use App\Models\Medical\Medical;
use App\Models\User;
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
        Schema::create('medical_officer', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Medical::class, 'medical_id');
            $table->foreignIdFor(User::class, 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_officer');
    }
};
