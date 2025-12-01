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
        Schema::create('forum_answers', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->json('images');
            $table->boolean('moderation')->default(1);
            $table->unsignedBigInteger('forum_question_id');
            $table->foreign('forum_question_id')->references('id')
                ->on('forum_questions')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
                ->on('users')->onUpdate('cascade');
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
        Schema::dropIfExists('forum_answers');
    }
};
