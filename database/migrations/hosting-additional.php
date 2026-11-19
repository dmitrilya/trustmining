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
        Schema::create('hosting_capacities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hosting_id')->constrained()->cascadeOnUpdate();
            $table->integer('total');
            $table->integer('occupied')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['hosting_id', 'created_at']);
        });

        Schema::create('hosting_expansions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hosting_id')->constrained()->cascadeOnUpdate();
            $table->integer('capacity');
            $table->date('planned_at');
            $table->date('completed_at')->nullable();
            $table->timestamps();

            $table->index(['hosting_id', 'planned_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hosting_capacities');
        Schema::dropIfExists('hosting_expansions');
    }
};
