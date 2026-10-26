<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('category_id'); 
            $table->morphs('voteable');
            $table->unsignedInteger('round_id');          
            $table->char('fingerprint_hash', 32)->unique('unique_vote_per_round');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['round_id', 'category_id'], 'idx_votes_period');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
