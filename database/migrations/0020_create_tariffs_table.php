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
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->unsignedTinyInteger('max_ads');
            $table->unsignedTinyInteger('max_offices');
            $table->boolean('can_have_hosting');
            $table->boolean('can_have_phone');
            $table->boolean('can_site_link');
            $table->unsignedSmallInteger('max_description');
            $table->boolean('can_create_insight');
            $table->boolean('priority_moderation');
            $table->unsignedInteger('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tariffs');
    }
};
