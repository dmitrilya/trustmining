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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
