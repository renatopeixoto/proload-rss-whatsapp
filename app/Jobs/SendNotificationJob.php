<?php

namespace App\Jobs;

use App\Models\PersonNotification;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\Response;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ids;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        PersonNotification::whereActive()
            ->whereToStatus(PersonNotification::STATUS_WAITING)
            ->whereIn('id', $this->ids)
            ->update([
                'status' => PersonNotification::STATUS_PROCCESS
            ]);

        $messages = $this->generateMessages($this->ids);

        $client = new Client([
            'base_uri' => env("WHATSAPP_SERVICE_BASE_URI", "http://172.0.0.1:8000"),
            'headers' => [
                'Content-type' => 'application/json; charset=utf-8',
                'Accept' => 'application/json'
            ]
        ]);

        try {
            $response = $client->post('/chats/send-bulk?id=' . env("WHATSAPP_SERVICE_SESSION_ID", 'jhon') ,
                [
                    'json' => $messages
                ]
            );
        }
        catch (\Exception $exception){
            PersonNotification::whereActive()->whereIn('id', $this->ids)->update([
                'status' => PersonNotification::STATUS_WAITING
            ]);
        }


        if($response->getStatusCode() == Response::HTTP_OK){
            PersonNotification::whereActive()->whereIn('id', $this->ids)->update([
                'status' => PersonNotification::STATUS_SENT
            ]);
        }


    }

    private function generateMessages($ids){

        return PersonNotification::whereActive()->whereIn('id', $this->ids)->get()->map(function ($q){
            return [
                'receiver' => $q->person->phone,
                'message' => "{$q->rss_item->title}\n{$q->rss_item->link}"
            ];
        });
    }

}
