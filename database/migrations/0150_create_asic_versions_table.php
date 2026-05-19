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
        Schema::dropIfExists('asic_versions');
    }
};
