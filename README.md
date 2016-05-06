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

## Direct usage

```php
```

**Output**

```
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
$app->loadComponent('queue', 'Dusterio\PlainSqs\Integrations\LaravelServiceProvider');
```

## Todo

1. Add more unit and integration tests

## License

The MIT License (MIT)
Copyright (c) 2016 Denis Mysenko

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
