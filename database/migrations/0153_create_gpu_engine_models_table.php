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
            $table->foreignId('gpu_engine_brand_id')->constrained()->cascadeOnUpdate();
            $table->string('name');
            $table->string('slug');
            $table->unsignedFloat('volume', 6, 3);
            $table->unsignedTinyInteger('cylinders');
            $table->unsignedSmallInteger('rpm');
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
