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
        Schema::create('asic_psus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asic_brand_id')->constrained()->cascadeOnUpdate();
            $table->string('name')->index();
            $table->string('revision')->nullable();
            $table->string('power_connector');
            $table->unsignedSmallInteger('voltage_min')->nullable();
            $table->unsignedSmallInteger('voltage_max')->nullable();
            $table->unsignedTinyInteger('frequency_min')->nullable();
            $table->unsignedTinyInteger('frequency_max')->nullable();
            $table->unsignedSmallInteger('output_power')->nullable();
            $table->unsignedTinyInteger('efficiency')->nullable();
            $table->unsignedTinyInteger('cooling_type');

            $table->unique(['asic_brand_id', 'name', 'revision']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asic_psus');
    }
};
