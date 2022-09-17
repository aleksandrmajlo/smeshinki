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
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('repetition')->nullable();
            $table->integer('typecalendar_id')->unsigned()->nullable();
            $table->string('slug')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });

        Schema::create('calendar_holiday', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('calendar_id')->unsigned()->index();
            $table->integer('holiday_id')->unsigned()->index();
            $table->integer('year')->default('2022');
            $table->unique(['calendar_id', 'holiday_id'], 'calendar_holiday');
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
        Schema::dropIfExists('holidays');
    }
};
