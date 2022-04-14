<?php

namespace App\Jobs;

use App\Models\PersonNotification;
use App\Models\Rss;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\Response;

class SendPersonNotificationsTodayJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $iChunk = 30;

        $client = new Client([
            'base_uri' => env("WHATSAPP_SERVICE_BASE_URI", "http://172.0.0.1:8000")
        ]);

        $response =  $client->get('/sessions/find/' . env("WHATSAPP_SERVICE_SESSION_ID", 'jhon'));

        if($response->getStatusCode() == Response::HTTP_OK){

            PersonNotification::whereActive()
                ->whereToday()
                ->whereToStatus(PersonNotification::STATUS_WAITING)
                ->chunk($iChunk, function ($notifications){
                    $ids = $notifications->pluck('id')->toArray();
                    SendNotificationJob::dispatch($ids);
                });
        }

    }

}
