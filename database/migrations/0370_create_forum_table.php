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
        Schema::create('forum_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
        });

        Schema::create('forum_subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('forum_category_id')->constrained()->cascadeOnUpdate();
        });

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
            $table->foreignId('forum_subcategory_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->timestamps();
        });

        Schema::create('forum_answers', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->json('images');
            $table->json('files');
            $table->boolean('moderation')->default(1);
            $table->foreignId('forum_question_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->timestamps();
        });

        Schema::create('forum_comments', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->json('images');
            $table->json('files');
            $table->boolean('moderation')->default(1);
            $table->foreignId('forum_answer_id')->constrained()->cascadeOnUpdate();
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
        Schema::dropIfExists('forum_categories');
        Schema::dropIfExists('forum_subcategories');
        Schema::dropIfExists('forum_questions');
        Schema::dropIfExists('forum_answers');
        Schema::dropIfExists('forum_comments');
    }
};
