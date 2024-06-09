<?php

use App\Models\Company;
use App\Models\CompanyDemand;
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
        Schema::create('final_jobstatuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id');
            $table->foreignIdFor(Company::class, 'company_id');
            $table->foreignIdFor(CompanyDemand::class, 'demand_id');
            $table->string('demand_code')->nullable();
            $table->enum('status', [1, 2, 3, 4, 5, 6])->comment('1 for engaged, 2 for Open to Work');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_jobstatuses');
    }
};
