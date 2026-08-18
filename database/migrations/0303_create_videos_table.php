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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
