<?php

namespace App\Jobs;

use App\Models\Rss;
use App\Models\RssItem;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\Response;

class RssChannelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Rss $rss;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Rss $rss)
    {
        $this->rss = $rss;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $client = new Client();

        $response = $client->get($this->rss->url);

        if($response->getStatusCode() == Response::HTTP_OK){
            $data = simplexml_load_string($response->getBody());

            if(count($data)){

                foreach ($data->channel->item as $item){
                    RssItem::updateOrCreate([
                        'rss_id' => $this->rss->id,
                        'title' => $item->title,
                        'link' => $item->link,
                        'active' => true
                    ]);
                }
            }
        }
    }
}
