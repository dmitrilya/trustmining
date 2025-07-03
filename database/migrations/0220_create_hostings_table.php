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
        Schema::create('hostings', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->unsignedInteger('ordering_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->json('images');
            $table->text('description');
            $table->string('address');
            $table->string('video')->nullable();
            $table->json('documents');
            $table->float('price', 5, 2);
            $table->json('peculiarities');
            $table->json('expenses');
            $table->json('conditions');
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
        Schema::dropIfExists('hostings');
    }
};
