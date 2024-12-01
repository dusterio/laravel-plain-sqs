<?php

namespace Dusterio\PlainSqs\Integrations;

use Dusterio\PlainSqs\Sqs\Connector;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;

/**
 * Class CustomQueueServiceProvider
 * @package App\Providers
 */
class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/sqs-plain.php' => config_path('sqs-plain.php')
        ]);
    }

    /**
     * @return void
     */
    public function register()
    {
         $this->app->booted(function () {
            $this->app['queue']->extend('sqs-plain', function () {
                return new Connector();
            });
        });
    }
}
