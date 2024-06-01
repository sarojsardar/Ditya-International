<?php

use App\Models\Company;
use App\Models\CompanyDemand;
use App\Models\Medical\Medical;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_checkups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Company::class, 'company_id');
            $table->foreignIdFor(Medical::class, 'medical_id');
            $table->foreignIdFor(CompanyDemand::class, 'demand_id')->nullable();
            $table->string('demand_code')->nullable();
            $table->timestamp('checkup_date');
            $table->boolean('is_tested')->default(false);
            $table->enum('status', ['N/A', 'Fit', 'Unfit'])->default('N/A');
            $table->boolean('is_re_scheduled')->default(false);
            $table->boolean('is_new')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_checkups');
    }
};
