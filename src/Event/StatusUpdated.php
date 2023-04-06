<?php

namespace BrankoDragovic\Webhook\Event;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class StatusUpdated
{
    use Dispatchable,
        SerializesModels;

    public array $notification;
    public string $uuid;
    public string $status;
    public string $title;
    public string $updatedAt;

    public function __construct(
        Model $model
    ) {
        $this->name = $this->getName($model);
        $this->uuid = $model->uuid;
        $this->title = $model->title;
        $this->updatedAt = Carbon::parse($model->updated_at)
            ->format('Y-m-d H:i:s');
    }

    /**
     * @param Model $model
     * @return string
     */
    public function getName(Model $model): string
    {
        $name = get_class($model);
        $name = explode('\\', $name);
        return $name[count($name) - 1];
    }
}
