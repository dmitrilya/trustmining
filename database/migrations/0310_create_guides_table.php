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
        Schema::create('guides', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->string('subtitle');
            $table->text('guide');
            $table->json('tags');
            $table->string('preview');
            $table->boolean('moderation')->default(1);
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
        Schema::dropIfExists('guides');
    }
};
