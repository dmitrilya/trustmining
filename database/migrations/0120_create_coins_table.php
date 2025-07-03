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
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbreviation');
            $table->unsignedBigInteger('algorithm_id')->nullable();
            $table->foreign('algorithm_id')->references('id')
                ->on('algorithms')->onUpdate('cascade');
            $table->unsignedFloat('profit', 12, 8)->nullable();
            $table->unsignedFloat('rate', 16, 8)->nullable();
            $table->boolean('payment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coins');
    }
};
