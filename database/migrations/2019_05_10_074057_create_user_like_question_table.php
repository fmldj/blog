<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLikeQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_like_question', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->string('user_name');
            $table->string('question_title');
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
        Schema::dropIfExists('user_like_question');
    }
}
