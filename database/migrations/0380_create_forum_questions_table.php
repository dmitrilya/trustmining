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
            $table->foreignId('forum_subcategory_id')->constrained()->cascadeOnUpdate()->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
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
