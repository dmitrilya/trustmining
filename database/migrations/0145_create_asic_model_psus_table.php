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
        Schema::create('asic_model_asic_psus', function (Blueprint $table) {
            $table->foreignId('asic_model_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('asic_psu_id')->constrained()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asic_model_asic_psus');
    }
};
