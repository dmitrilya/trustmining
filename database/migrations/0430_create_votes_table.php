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
            $table->unsignedInteger('year_month');            
            $table->char('fingerprint', 32);         
            $table->char('fingerprint_ip_hash', 32);
            $table->timestamp('created_at')->useCurrent();

            $table->index(['voteable_type', 'voteable_id'], 'idx_votes_voteable');
            $table->index(['year_month', 'category_id'], 'idx_votes_period');
            $table->unique('fingerprint_ip_hash', 'unique_vote_per_month');
        });

        DB::statement('ALTER TABLE `votes` ADD `ip_address` VARBINARY(16) NOT NULL AFTER `year_month`');
        DB::statement('ALTER TABLE `votes` ADD INDEX `idx_votes_ip_period` (`year_month`, `category_id`, `ip_address`)');
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
