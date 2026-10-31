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
        Schema::create('external_sources_mapping', function (Blueprint $table) {
            $table->id();
            $table->morphs('ratable');
            $table->string('rating_source_id');
            $table->string('external_id');
            $table->timestamps();

            $table->unique(['rating_source_id', 'external_id'], 'source_external_unique');
        });

        Schema::create('external_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapping_id')->constrained('external_sources_mapping')->cascadeOnDelete();
            $table->decimal('rating', 3, 2);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->timestamps();

            $table->index('mapping_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_sources_mapping');
        Schema::dropIfExists('external_ratings');
    }
};
