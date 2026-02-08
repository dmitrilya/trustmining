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
        Schema::create('gpu_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gpu_brand_id');
            $table->foreign('gpu_brand_id')->references('id')
                ->on('gpu_brands')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('gpu_engine_model_id');
            $table->foreign('gpu_engine_model_id')->references('id')
                ->on('gpu_engine_models')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->unsignedSmallInteger('max_power');
            $table->unsignedTinyInteger('phases');
            $table->string('gas_type');
            $table->unsignedTinyInteger('fuel_consumption');
            $table->string('enclosure');
            $table->unsignedSmallInteger('length');
            $table->unsignedSmallInteger('width');
            $table->unsignedSmallInteger('height');
            $table->unsignedSmallInteger('weight');
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
        Schema::dropIfExists('gpu_models');
    }
};
