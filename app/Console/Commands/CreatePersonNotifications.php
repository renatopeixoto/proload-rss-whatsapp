<?php

namespace App\Console\Commands;

use App\Jobs\CreatePersonNotificationsJob;
use Illuminate\Console\Command;

class CreatePersonNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:create-person-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CreatePersonNotificationsJob::dispatch();
    }
}
