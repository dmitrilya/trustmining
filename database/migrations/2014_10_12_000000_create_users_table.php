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
            $table->unsignedBigInteger('role_id')->default(2);
            $table->foreign('role_id')->references('id')
                ->on('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('tariff_id')->nullable();
            $table->foreign('tariff_id')->references('id')
                ->on('tariffs')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('url_name');
            $table->unsignedInteger('balance')->default(0);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
