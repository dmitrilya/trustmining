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
        Schema::create('moderations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moderation_status_id')->default(1)->constrained('moderation_statuses')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedBigInteger('moderationable_id');
            $table->string('moderationable_type');

            $table->json('data');
            $table->string('comment')->nullable();

            $table->timestamps();

            $table->index(['moderationable_type', 'moderationable_id', 'moderation_status_id'], 'moderations_morph_status_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moderations');
    }
};
