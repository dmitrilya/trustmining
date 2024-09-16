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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('ad_category_id');
            $table->foreign('ad_category_id')->references('id')
                ->on('ad_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('asic_version_id')->nullable();
            $table->foreign('asic_version_id')->references('id')
                ->on('asic_versions')->onUpdate('cascade')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->string('preview');
            $table->boolean('new')->nullable();
            $table->unsignedTinyInteger('warranty')->nullable();
            $table->boolean('in_stock')->nullable();
            $table->boolean('moderation')->default(1);
            $table->boolean('hidden')->default(0);
            $table->unsignedTinyInteger('waiting')->nullable();
            $table->float('price');
            $table->unsignedInteger('contacts')->default(0);
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
        Schema::dropIfExists('ads');
    }
};
