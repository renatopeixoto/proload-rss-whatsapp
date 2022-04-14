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

class CreatePersonNotifivationByRssItemJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private RssItem $rssItem;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(RssItem $rssItem)
    {
        $this->rssItem = $rssItem;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $iChunk = 500;

        Person::whereActive()->chunk($iChunk, function ($people){

            $data = [];

            foreach ($people as $person){

                if(!$this->hasCreatedPersonNotificationToday($this->rssItem->id, $person->id)){

                    $now = now()->format('Y-m-d H:i:s');
                    $data[] = [
                        'rss_item_id' => $this->rssItem->id,
                        'person_id' => $person->id,
                        'status' => PersonNotification::STATUS_WAITING,
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                }
            }

            if(!empty($data)){
                PersonNotification::insert($data);
            }

        });

    }

    private function hasCreatedPersonNotificationToday($rss_item_id, $person_id){
        $count = PersonNotification::whereActive()
            ->whereToday()
            ->whereByPersonId($person_id)
            ->whereByRssItemId($rss_item_id)
            ->count();

        return $count > 0;
    }
}
