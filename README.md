# Plain Sqs
[![Build Status](https://travis-ci.org/dusterio/laravel-plain-sqs.svg)](https://travis-ci.org/dusterio/laravel-plain-sqs)
[![Code Climate](https://codeclimate.com/github/dusterio/link-preview/badges/gpa.svg)](https://codeclimate.com/github/dusterio/link-preview/badges)
[![Total Downloads](https://poser.pugx.org/dusterio/laravel-plain-sqs/d/total.svg)](https://packagist.org/packages/dusterio/laravel-plain-sqs)
[![Latest Stable Version](https://poser.pugx.org/dusterio/laravel-plain-sqs/v/stable.svg)](https://packagist.org/packages/dusterio/laravel-plain-sqs)
[![Latest Unstable Version](https://poser.pugx.org/dusterio/laravel-plain-sqs/v/unstable.svg)](https://packagist.org/packages/dusterio/laravel-plain-sqs)
[![License](https://poser.pugx.org/dusterio/laravel-plain-sqs/license.svg)](https://packagist.org/packages/dusterio/laravel-plain-sqs)

A custom SQS connector for Laravel (or Lumen) that supports custom format JSON payloads. Out of the box, Laravel expects
SQS messages to be generated in specific format - format that includes job handler class and a serialized job.

But in certain cases you may want to parse messages from third party applications, custom JSON messages and so on.

## Dependencies

* PHP >= 5.5
* Laravel (or Lumen) >= 5.2

## Installation via Composer

To install simply run:

```
composer require dusterio/laravel-plain-sqs
```

Or add it to `composer.json` manually:

```json
{
    "require": {
        "dusterio/laravel-plain-sqs": "~0.1"
    }
}
```

## Configuration

```php
// Generate standard config file (Laravel only)
php artisan vendor:publish

// In Lumen, create it manually (see example below) and load it in bootstrap/app.php
$app->configure('sqs-plain');
```

Edit config/sqs-plain.php to suit your needs. This config matches SQS queues with handler classes.

```php
return [
    'handlers' => [
        'base-integrations-updates' => App\Jobs\HandlerJob::class,
    ],

    'default-handler' => App\Jobs\HandlerJob::class
];
```

If queue is not found in 'handlers' array, SQS payload is passed to default handler.

Add sqs-plain connection to your config/queue.php, eg:
```php
        ...
        'sqs-plain' => [
            'driver' => 'sqs-plain',
            'key'    => env('AWS_KEY', ''),
            'secret' => env('AWS_SECRET', ''),
            'prefix' => 'https://sqs.ap-southeast-2.amazonaws.com/123123/',
            'queue'  => 'important-music-updates',
            'region' => 'ap-southeast-2',
        ],
        ...
```

In your .env file, choose sqs-plain as your new default queue driver:
```
QUEUE_DRIVER=sqs-plain
```

## Dispatching to SQS

If you plan to push plain messages from Laravel or Lumen, you can rely on DispatcherJob:

```php
use Dusterio\PlainSqs\Jobs\DispatcherJob;

class ExampleController extends Controller
{
    public function index()
    {
        // Create a PHP object
        $object = [
            'music' => 'M.I.A. - Bad girls',
            'time' => time()
        ];

        // Pass it to dispatcher job
        $job = new DispatcherJob($object);

        // Dispatch the job as you normally would
        // By default, your data will be encapsulated in 'data' and 'job' field will be added
        $this->dispatch($job);

        // If you wish to submit a true plain JSON, add setPlain()
        $this->dispatch($job->setPlain());
    }
}

```

This will push the following JSON object to SQS:

```
{"job":"App\\Jobs\\HandlerJob@handle","data":{"music":"M.I.A. - Bad girls","time":1462511642}}
```

'job' field is not used, actually. It's just kept for compatibility sake.

### Receiving from SQS

If a third-party application is creating custom-format JSON messages, just add a handler in the config file and
implement a handler class as follows:

```php
use Illuminate\Contracts\Queue\Job as LaravelJob;

class HandlerJob extends Job
{
    protected $data;

    /**
     * @param LaravelJob $job
     * @param array $data
     */
    public function handle(LaravelJob $job, array $data)
    {
        // This is incoming JSON payload, already decoded to an array
        var_dump($data);

        // Raw JSON payload from SQS, if necessary
        var_dump($job->getRawBody());
    }
}

```

### Usage in Laravel 5

```php
// Add in your config/app.php

'providers' => [
    '...',
    'Dusterio\PlainSqs\Integrations\LaravelServiceProvider',
];
```

### Usage in Lumen 5

```php
// Add in your bootstrap/app.php
$app->loadComponent('queue', 'Dusterio\PlainSqs\Integrations\LumenServiceProvider');
```

## Todo

1. Add more unit and integration tests

## License

The MIT License (MIT)
Copyright (c) 2016 Denis Mysenko

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
