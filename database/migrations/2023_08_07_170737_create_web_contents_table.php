<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('chairman_name')->nullable();
            $table->string('chairman_profile')->nullable();
            $table->longText('chairman_message')->nullable();
            $table->string('about_us_banner')->nullable();
            $table->string('about_us_side_banner')->nullable();
            $table->string('about_us_title')->nullable();
            $table->longText('about_us_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_contents');
    }
};
