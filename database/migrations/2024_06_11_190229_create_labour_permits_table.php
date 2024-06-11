<?php

use App\Models\User;
use App\Models\Company;
use App\Models\CompanyDemand;
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
        Schema::create('labour_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Company::class, 'company_id');
            $table->foreignIdFor(CompanyDemand::class, 'demand_id')->nullable();
            $table->string('demand_code')->nullable();
            $table->enum('status', ['N/A', 'Pending', 'In Progress', 'Successed', 'Rejected'])->default('N/A');
            $table->longText('reason')->nullable();
            $table->string('permit')->nullable();
            $table->boolean('is_new')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labour_permits');
    }
};
