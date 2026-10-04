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
        Schema::create('chats', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->foreignId('ad_id')->nullable()->constrained()->cascadeOnUpdate()->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->foreignId('chat_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->text('message')->nullable();
            $table->json('images');
            $table->json('files');
            $table->boolean('checked')->default(0);
            $table->timestamps();
        });

        Schema::create('chat_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('chat_id')->constrained()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('chat_user');
    }
};
