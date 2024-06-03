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
        Schema::create('document_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id');
            $table->foreignIdFor(Company::class, 'company_id');
            $table->foreignIdFor(CompanyDemand::class, 'demand_id');
            $table->string('demand_code')->nullable();
            $table->enum('status', ['Started', 'In Progress', 'Completed'])->default('Started');
            $table->boolean('is_notified')->default(false);
            $table->timestamp('notified_date')->nullable();
            $table->longText('notified_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_processes');
    }
};
