<?php

namespace App\Console\Commands;

use App\Models\User\User;
use App\Models\Forum\ForumSubcategory;
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
        $notificationTypes = NotificationType::all();

        foreach (User::all() as $user) {
            $user->settings()->create([
                'notifications' => [
                    $notificationTypes->where('name', 'Moderation completed')->first()->id => ['e' => ['o' => true], 't' => ['o' => true]],
                    $notificationTypes->where('name', 'Moderation failed')->first()->id => ['e' => ['o' => true], 't' => ['o' => true]],
                    $notificationTypes->where('name', 'New message')->first()->id => ['e' => ['o' => true, 'f' => 'f'], 't' => ['o' => true, 'f' => 'a']],
                    $notificationTypes->where('name', 'New review')->first()->id => ['e' => ['o' => true, 'c' => 'n'], 't' => ['o' => true, 'c' => 'a']],
                    $notificationTypes->where('name', 'Review edited')->first()->id => ['e' => ['o' => true, 'c' => 'n'], 't' => ['o' => true, 'c' => 'a']],
                    $notificationTypes->where('name', 'Price change')->first()->id => ['e' => ['o' => true, 'c' => 'd'], 't' => ['o' => true, 'c' => 'c']],
                    $notificationTypes->where('name', 'Difficulty changing')->first()->id => ['c' => [], 'e' => ['o' => true, 'f' => 'c'], 't' => ['o' => true, 'f' => 'c']],
                ]
            ]);
        }

        return Command::SUCCESS;
    }
}
