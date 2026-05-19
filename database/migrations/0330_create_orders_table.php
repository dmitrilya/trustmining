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
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->unsignedInteger('amount');
            $table->string('method');
            $table->string('invoice_id')->nullable();
            $table->string('invoice_url')->nullable();
            $table->string('status')->default('init');
            $table->string('token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
