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
        Schema::table('welcomes', function (Blueprint $table) {
            $table->enum('type',['posts','anecdotes','words'])->default('posts')->comment('тип отправляемого материала');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('welcomes', function (Blueprint $table) {
            //
        });
    }
};
