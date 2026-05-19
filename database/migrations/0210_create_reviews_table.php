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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->morphs('reviewable');
            $table->text('review');
            $table->unsignedTinyInteger('rating');
            $table->string('image')->nullable();
            $table->string('document')->nullable();
            $table->boolean('fake')->default(0);
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
        Schema::dropIfExists('reviews');
    }
};
