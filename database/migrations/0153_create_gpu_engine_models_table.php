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
        Schema::create('gpu_engine_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gpu_engine_brand_id');
            $table->foreign('gpu_engine_brand_id')->references('id')
                ->on('gpu_engine_brands')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->unsignedSmallInteger('volume');
            $table->unsignedTinyInteger('cylinders');
            $table->unsignedSmallInteger('rpm');
            $table->string('cooling_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gpu_engine_models');
    }
};
