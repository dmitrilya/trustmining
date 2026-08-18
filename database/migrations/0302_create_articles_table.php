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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
