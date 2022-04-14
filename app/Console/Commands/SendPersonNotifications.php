<?php

namespace App\Console\Commands;

use App\Jobs\SendPersonNotificationsTodayJob;
use Illuminate\Console\Command;

class SendPersonNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:send-notifications';

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
        SendPersonNotificationsTodayJob::dispatch();
    }
}
