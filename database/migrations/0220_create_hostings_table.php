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
        Schema::create('hostings', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->unsignedInteger('ordering_id');
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->json('images');
            $table->text('description');
            $table->string('address');
            $table->foreignId('city_id')->constrained()->cascadeOnUpdate();
            $table->string('video')->nullable();
            $table->string('contract')->nullable();
            $table->json('contract_deficiencies');
            $table->string('territory')->nullable();
            $table->string('energy_supply')->nullable();
            $table->json('tariffs');
            $table->json('peculiarities');
            $table->json('expenses');
            $table->json('conditions');
            $table->boolean('moderation')->default(1);
            $table->timestamps();
        });

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
        Schema::dropIfExists('hostings');
        Schema::dropIfExists('hosting_capacities');
        Schema::dropIfExists('hosting_expansions');
    }
};
