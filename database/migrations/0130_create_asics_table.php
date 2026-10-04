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
        Schema::create('asic_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
        });

        Schema::create('psus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asic_brand_id')->constrained()->cascadeOnUpdate();
            $table->string('name')->index();
            $table->string('connector');
            $table->unsignedDecimal('input_voltage_min', 5, 2)->nullable();
            $table->unsignedDecimal('input_voltage_max', 5, 2)->nullable();
            $table->unsignedTinyInteger('frequency_min')->nullable();
            $table->unsignedTinyInteger('frequency_max')->nullable();
            $table->unsignedDecimal('output1_voltage_min', 5, 2)->nullable();
            $table->unsignedDecimal('output1_voltage_max', 5, 2)->nullable();
            $table->unsignedDecimal('output1_rated_current', 5, 2)->nullable();
            $table->unsignedDecimal('output2_voltage_min', 5, 2)->nullable();
            $table->unsignedDecimal('output2_voltage_max', 5, 2)->nullable();
            $table->unsignedDecimal('output2_rated_current', 5, 2)->nullable();
            $table->unsignedSmallInteger('rated_power')->nullable();
            $table->unsignedTinyInteger('cooling_type');
            $table->text('notes')->nullable();
        });

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
            $table->unsignedTinyInteger('cooling_type');
        });

        Schema::create('asic_model_psu', function (Blueprint $table) {
            $table->foreignId('asic_model_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('psu_id')->constrained()->cascadeOnUpdate();
            $table->unsignedTinyInteger('compatibility_level');
            
            $table->unique(['asic_model_id', 'psu_id']);
        });

        Schema::create('asic_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asic_model_id')->constrained()->cascadeOnUpdate();
            $table->unsignedDecimal('hashrate', 10, 4);
            $table->unsignedFloat('efficiency', 7, 3);
            $table->string('measurement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asic_brands');
        Schema::dropIfExists('psus');
        Schema::dropIfExists('asic_models');
        Schema::dropIfExists('asic_model_psu');
        Schema::dropIfExists('asic_versions');
    }
};
