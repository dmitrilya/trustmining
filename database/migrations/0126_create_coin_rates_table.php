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
        Schema::create('coin_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coin_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedFloat('rate', 16, 8);
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
        Schema::dropIfExists('coin_rates');
    }
};
