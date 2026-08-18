<?php

namespace App\Console\Commands;

use App\Models\User\User;
use App\Models\Forum\ForumSubcategory;
use App\Models\Insight\Content\Article;
use App\Models\User\NotificationType;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mycommand:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (Article::all() as $content) {
            $content->published_at = $content->created_at;
            $content->save();
        }

        return Command::SUCCESS;
    }
}
