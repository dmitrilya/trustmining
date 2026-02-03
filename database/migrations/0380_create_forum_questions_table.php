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
        Schema::create('forum_questions', function (Blueprint $table) {
            $table->id();
            $table->string('theme');
            $table->text('text');
            $table->json('images');
            $table->json('files');
            $table->json('keywords');
            $table->boolean('moderation')->default(1);
            $table->json('similar_questions');
            $table->boolean('published')->default(0);
            $table->unsignedBigInteger('forum_subcategory_id')->nullable();
            $table->foreign('forum_subcategory_id')->references('id')
                ->on('forum_subcategories')->onUpdate('cascade');
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
        Schema::dropIfExists('forum_questions');
    }
};
