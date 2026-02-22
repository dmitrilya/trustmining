<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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

            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('ad_category_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('asic_version_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('gpu_model_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('office_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('coin_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->string('preview');
            $table->json('props');
            $table->boolean('moderation')->default(true);
            $table->boolean('hidden')->default(false);
            $table->boolean('unique_content')->default(false);
            $table->float('price');
            $table->boolean('with_vat')->default(false);
            $table->unsignedInteger('ordering_id');
            $table->index(['ad_category_id', DB::raw('ordering_id DESC')], 'ads_category_ordering');
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
