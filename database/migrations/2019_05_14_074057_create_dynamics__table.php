<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('question_id')->nullable();
            $table->unsignedInteger('topic_id')->nullable();
            $table->unsignedInteger('answer_id')->nullable();
            $table->unsignedInteger('comments_id')->nullable();
            $table->unsignedInteger('user_question')->nullable();
            $table->smallInteger('type');
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
        Schema::dropIfExists('dynamics');
    }
}
