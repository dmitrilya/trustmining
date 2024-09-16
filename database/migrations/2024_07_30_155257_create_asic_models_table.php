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
        Schema::create('asic_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asic_brand_id');
            $table->foreign('asic_brand_id')->references('id')
                ->on('asic_brands')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('algorithm_id');
            $table->foreign('algorithm_id')->references('id')
                ->on('algorithms')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->unsignedTinyInteger('width');
            $table->unsignedTinyInteger('length');
            $table->unsignedTinyInteger('height');
            $table->unsignedTinyInteger('weight');
            $table->json('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asic_models');
    }
};
