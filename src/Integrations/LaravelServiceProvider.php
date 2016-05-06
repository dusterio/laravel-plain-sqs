<?php

namespace App\Providers;

use Dusterio\PlainSqs\Sqs\Connector;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;

/**
 * Class CustomQueueServiceProvider
 * @package App\Providers
 */
class CustomQueueServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('sqs-plain.php')
        ]);

        Queue::after(function (JobProcessed $event) {
            $event->job->delete();
        });
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app['queue']->addConnector('sqs-plain', function () {
            return new Connector();
        });
    }
}