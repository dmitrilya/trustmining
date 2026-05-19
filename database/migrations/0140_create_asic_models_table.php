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
            $table->foreignId('asic_brand_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('algorithm_id')->constrained()->cascadeOnUpdate();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->json('characteristics');
            $table->json('images');
            $table->date('release');
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
