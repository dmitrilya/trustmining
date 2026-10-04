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
        Schema::create('channels', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brief_description');
            $table->text('description');
            $table->string('logo');
            $table->string('banner');
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->timestamps();
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('channel_id')->constrained()->cascadeOnUpdate();
            $table->timestamp('subscribed_at')->useCurrent();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->index(['channel_id', 'unsubscribed_at']);
        });

        Schema::create('series', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->string('name');
            $table->text('description');
            $table->foreignId('channel_id')->constrained()->cascadeOnUpdate();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->string('preview');
            $table->text('content');
            $table->timestamp('published_at');
            $table->boolean('moderation')->default(1);
            $table->foreignId('channel_id')->constrained()->cascadeOnUpdate();
            $table->timestamps();

            $table->index(['moderation', 'published_at'], 'posts_published_index');
            $table->index(['channel_id', 'moderation', 'published_at'], 'posts_channel_published_index');
            $table->index(['moderation', 'published_at', 'channel_id'], 'posts_published_channels_index');
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->string('title');
            $table->string('subtitle');
            $table->string('preview');
            $table->text('content');
            $table->json('tags');
            $table->timestamp('published_at');
            $table->boolean('moderation')->default(1);
            $table->foreignId('channel_id')->constrained()->cascadeOnUpdate();
            $table->timestamps();

            $table->index(['moderation', 'published_at'], 'articles_published_index');
            $table->index(['channel_id', 'moderation', 'published_at'], 'articles_channel_published_index');
            $table->index(['moderation', 'published_at', 'channel_id'], 'articles_published_channels_index');
        });
        
        Schema::create('videos', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->string('title');
            $table->string('preview');
            $table->string('url');
            $table->timestamp('published_at');
            $table->boolean('moderation')->default(1);
            $table->foreignId('channel_id')->constrained()->cascadeOnUpdate();
            $table->timestamps();

            $table->index(['moderation', 'published_at'], 'videos_published_index');
            $table->index(['channel_id', 'moderation', 'published_at'], 'videos_channel_published_index');
            $table->index(['moderation', 'published_at', 'channel_id'], 'videos_published_channels_index');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->morphs('commentable');
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnUpdate();
            $table->text('text');
            $table->timestamps();
            $table->index(['commentable_id', 'commentable_type']);
        });

        Schema::create('comment_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->string('type');
            $table->unique(['comment_id', 'user_id']);
            $table->timestamps();
        });

        Schema::create('series_content', function (Blueprint $table) {
            $table->id();
            $table->foreignId('series_id')->constrained()->cascadeOnUpdate();
            $table->morphs('contentable');
            $table->integer('sort_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('series');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('comment_reactions');
        Schema::dropIfExists('series_content');
    }
};
