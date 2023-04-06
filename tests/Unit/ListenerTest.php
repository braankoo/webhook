<?php

namespace BrankoDragovic\Webhook\Tests\Unit;

use BrankoDragovic\Webhook\Event\StatusUpdated;
use BrankoDragovic\Webhook\HttpService;
use BrankoDragovic\Webhook\Listeners\Notify;
use BrankoDragovic\Webhook\Tests\TestCase;
use BrankoDragovic\Webhook\Tests\Model\TestModel;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Event;

class ListenerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->httpServiceMock = $this->createMock(HttpService::class);
        $this->notify = new Notify($this->httpServiceMock);
    }

    public function test_handle()
    {
        $model = new TestModel();
        $model->uuid = '123';
        $model->title = 'Test Title';
        $model->updated_at = '2022-01-01 00:00:00';
        $this->httpServiceMock->expects($this->once())->method('sendRequest');
        $this->notify->handle(new StatusUpdated($model));
    }

    public function test_handle_exception()
    {
        $model = new TestModel();
        $model->uuid = '123';
        $model->name = '123';
        $model->title = 'Test Title';
        $model->updated_at = '2022-01-01 00:00:00';


        $notify = new Notify($this->httpServiceMock);

        $this->httpServiceMock->expects($this->once())
            ->method('sendRequest')
            ->with(
                config('webhook.webhook_url'),
                'post',
                $this->equalTo(
                    [
                        'headers' =>
                            [
                                'Content-Type' => 'application/json'
                            ],
                        'json' => $notify->getCard(
                            'TestModel',
                            $model->uuid,
                            $model->updated_at,
                            $model->title
                        )
                    ]
                )
            );

        $notify->handle(new StatusUpdated($model));
    }


}
