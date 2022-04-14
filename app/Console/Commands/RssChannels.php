<?php

namespace App\Console\Commands;

use App\Jobs\RssChannelsJob;
use Illuminate\Console\Command;

class RssChannels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:channels';

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
        RssChannelsJob::dispatch();
    }
}
