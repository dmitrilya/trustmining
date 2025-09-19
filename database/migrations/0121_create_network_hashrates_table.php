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
        Schema::create('network_hashrates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coin_id');
            $table->foreign('coin_id')->references('id')
                ->on('coins')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedDouble('hashrate', 24, 2);
            $table->unsignedDouble('minutes_between_blocks', 8, 4);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('network_hashrates');
    }
};
