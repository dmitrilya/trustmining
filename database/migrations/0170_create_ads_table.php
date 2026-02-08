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
            $table->id()->startingValue(10000000);
            $table->unsignedInteger('ordering_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('ad_category_id');
            $table->foreign('ad_category_id')->references('id')
                ->on('ad_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('asic_version_id')->nullable();
            $table->foreign('asic_version_id')->references('id')
                ->on('asic_versions')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('gpu_model_id')->nullable();
            $table->foreign('gpu_model_id')->references('id')
                ->on('gpu_models')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('office_id')->nullable();
            $table->foreign('office_id')->references('id')
                ->on('offices')->onUpdate('cascade')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->string('preview');
            $table->json('props');
            $table->boolean('moderation')->default(1);
            $table->boolean('hidden')->default(0);
            $table->boolean('unique_content')->default(0);
            $table->float('price');
            $table->boolean('with_vat')->default(0);
            $table->unsignedBigInteger('coin_id');
            $table->foreign('coin_id')->references('id')
                ->on('coins')->onUpdate('cascade')->onDelete('cascade');
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
