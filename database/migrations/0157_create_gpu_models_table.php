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
            $table->foreignId('gpu_brand_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('gpu_engine_model_id')->constrained()->cascadeOnUpdate();
            $table->string('name');
            $table->string('slug');
            $table->unsignedSmallInteger('max_power');
            $table->unsignedTinyInteger('phases');
            $table->unsignedFloat('fuel_consumption', 6,3);
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
