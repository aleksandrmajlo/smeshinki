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
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();

            $table->string('photo')->nullable();
            $table->string('thumb')->nullable();
            $table->string('video')->nullable();
            $table->text('description')->nullable();

            $table->integer('telegram_id')->index()->nullable()->comment('message_id с телеги');

            $table->string('slug')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->float('rating_avg')->default(0)->comment('средняя оценка');
            $table->integer('total_votes')->default(0)->comment('количество оценок');
            $table->integer('total_rating')->default(0)->comment('сумма оценок');
            $table->tinyInteger('twitter_send')->default(0)->comment('0-не отправлялось 1-отправлялось');

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
        Schema::dropIfExists('words');
    }
};
