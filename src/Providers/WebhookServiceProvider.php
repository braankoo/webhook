<?php

namespace BrankoDragovic\Webhook\Providers;

use BrankoDragovic\Webhook\HttpService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class WebhookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/config.php' => config_path(
                    'webhook.php'
                ),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'webhook');

        $this->app->register(EventServiceProvider::class);

        $this->app->bind(HttpService::class, function () {
            return new HttpService(new Client());
        });
    }
}
