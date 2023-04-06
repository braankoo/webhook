<?php

namespace BrankoDragovic\Webhook\Listeners;

use BrankoDragovic\Webhook\Event\StatusUpdated;
use BrankoDragovic\Webhook\HttpService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class Notify
{

    private HttpService $httpService;

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
    }

    public function handle(StatusUpdated $event): void
    {
        try {
            $this->httpService->sendRequest(
                config('webhook.webhook_url'),
                'post',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $this->getCard(
                        $event->name,
                        $event->uuid,
                        $event->updatedAt,
                        $event->title
                    )
                ]
            );
        } catch (GuzzleException $e) {
            Log::error('Error sending request: ' . $e->getMessage());
        }
    }


    public function getCard(
        string $model,
        string $uuid,
        string $updatedAt,
        string $status
    ): array {
        return [
            "type" => "AdaptiveCard",
            "body" => [
                "container1" => [
                    "type" => "Container",
                    "items" => [
                        [
                            "type" => "TextBlock",
                            "text" => $model . ' updated',
                            "wrap" => true
                        ]
                    ]
                ],
                "container2" => [
                    "type" => "Container",
                    "items" => [
                        [
                            "type" => "TextBlock",
                            "text" => "UUID " . $uuid,
                            "wrap" => true
                        ]
                    ]
                ],
                "container3" => [
                    "type" => "Container",
                    "items" => [
                        [
                            "type" => "TextBlock",
                            "text" => 'Updated at ' . $updatedAt,
                            "wrap" => true
                        ]
                    ]
                ],
                "container4" => [
                    "type" => "Container",
                    "items" => [
                        [
                            "type" => "Container",
                            "items" => [
                                [
                                    "type" => "Container",
                                    "items" => [
                                        [
                                            "type" => "TextBlock",
                                            "text" => "Status :" . $status,
                                            "wrap" => true
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                '$schema' => "http://adaptivecards.io/schemas/adaptive-card.json",
                "version" => "1.5"
            ]
        ];
    }

}
