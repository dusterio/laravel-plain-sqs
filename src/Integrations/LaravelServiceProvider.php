<?php

namespace App\Providers;

use Illuminate\Queue\QueueServiceProvider;
use App\Services\CustomSqsConnector;
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
            return new CustomSqsConnector();
        });
    }
}