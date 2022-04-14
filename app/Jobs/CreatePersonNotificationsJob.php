<?php

namespace App\Jobs;

use App\Models\Person;
use App\Models\PersonNotification;
use App\Models\RssItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use SebastianBergmann\Environment\Console;

class CreatePersonNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rssItems = RssItem::whereActive()->whereToday()->get();

        foreach ($rssItems as $rssItem){
            CreatePersonNotifivationByRssItemJob::dispatch($rssItem);
        }

    }


}
