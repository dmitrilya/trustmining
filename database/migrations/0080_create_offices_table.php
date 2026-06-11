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
        Schema::create('offices', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('city_id')->constrained()->cascadeOnUpdate();
            $table->string('address');
            $table->json('images');
            $table->string('video')->nullable();
            $table->unsignedInteger('postal_code');
            $table->json('peculiarities');
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
        Schema::dropIfExists('offices');
    }
};
