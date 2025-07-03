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
            $table->unsignedBigInteger('asic_model_id');
            $table->foreign('asic_model_id')->references('id')
                ->on('asic_models')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedFloat('hashrate', 10, 4);
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
