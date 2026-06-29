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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->startingValue(10000000);
            $table->unsignedInteger('ordering_id');
            $table->foreignId('role_id')->default(2)->constrained()->cascadeOnUpdate();
            $table->foreignId('tariff_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->date('tariff_from')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->unsignedTinyInteger('tf')->default(50);
            $table->unsignedSmallInteger('art')->default(0);
            $table->unsignedSmallInteger('forum_score')->default(0);
            $table->unsignedInteger('balance')->default(0);
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('tg_id')->nullable();
            $table->string('tg_contact')->nullable();
            $table->boolean('is_anchor')->default(0);
            $table->boolean('first')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
