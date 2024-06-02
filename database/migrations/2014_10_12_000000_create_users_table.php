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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('email')->unique()->nullable();
            $table->enum('user_type', [1,2,3,4,5,6,7,8,9,10])->comment('1 for normal, 2 for company, 3 for candidate, 4 for medical officer, 5 for Document Officer and so on this my be added according to the requirement')->default(1);
            $table->string('mobile_no')->nullable();
            $table->integer('code')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('status');
            $table->string('demand_status')->default('New');
            $table->string('reference_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
