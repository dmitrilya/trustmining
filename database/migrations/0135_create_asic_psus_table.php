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
