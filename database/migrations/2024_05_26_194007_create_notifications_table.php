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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('generated_by')->default('System')->comment('this may be model or system only');
            $table->integer('generated_id')->default(0)->nullable()->comment('this is may be generated model id or null or 0');
            $table->string('generated_to')->default('All')->comment('this may be model or system only')->nullable();
            $table->integer('generated_id')->default(0)->comment('this is may be generated model id or null or 0');
            $table->longText('web_content')->nullable();
            $table->longText('mobile_content')->nullable();
            $table->boolean('is_auto');
            $table->enum('send_to', [1,2,3,4])->comment('1 for only system, 2 for only email through, 3 for only sms through', '4 for all');
            $table->text('go_to_url')->nullable()->comment('this may be the url of the content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
