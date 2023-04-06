<?php

namespace BrankoDragovic\Webhook\Tests\Unit;


use BrankoDragovic\Webhook\Tests\TestCase;
use BrankoDragovic\Webhook\Event\StatusUpdated;
use BrankoDragovic\Webhook\Tests\Model\TestModel;
use Illuminate\Support\Facades\Event;

class EventTest extends TestCase
{
    public function testStatusUpdatedEvent()
    {
        $model = new TestModel();
        $model->uuid = '123';
        $model->title = 'Test Title';
        $model->updated_at = '2022-01-01 00:00:00';

        Event::fake();
        event(new StatusUpdated($model));
        Event::assertDispatched(
            StatusUpdated::class,
            function ($event) use ($model) {
                return $event->uuid === $model->uuid
                    && $event->title === $model->title
                    && $event->updatedAt === '2022-01-01 00:00:00';
            }
        );
    }
}
