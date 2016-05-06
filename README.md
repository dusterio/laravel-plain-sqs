# Plain Sqs
[![Build Status](https://travis-ci.org/dusterio/link-preview.svg)](https://travis-ci.org/dusterio/link-preview)
[![Code Climate](https://codeclimate.com/github/dusterio/link-preview/badges/gpa.svg)](https://codeclimate.com/github/dusterio/link-preview/badges)
[![Test Coverage](https://codeclimate.com/github/dusterio/link-preview/badges/coverage.svg)](https://codeclimate.com/github/dusterio/link-preview/badges)
[![Total Downloads](https://poser.pugx.org/dusterio/link-preview/d/total.svg)](https://packagist.org/packages/dusterio/link-preview)
[![Latest Stable Version](https://poser.pugx.org/dusterio/link-preview/v/stable.svg)](https://packagist.org/packages/dusterio/link-preview)
[![Latest Unstable Version](https://poser.pugx.org/dusterio/link-preview/v/unstable.svg)](https://packagist.org/packages/dusterio/link-preview)
[![License](https://poser.pugx.org/dusterio/link-preview/license.svg)](https://packagist.org/packages/dusterio/link-preview)

A custom SQS connector for Laravel (or Lumen) that supports custom format JSON payloads. Out of the box, Laravel expects
SQS messages to be generated in specific format - format that includes job handler class and a serialized job.

But in certain cases you may want to parse messages from third party applications, custom JSON messages and so on.

## Dependencies

* PHP >= 5.5
* Laravel (or Lumen) >= 5.2

## Installation via Composer

To install simply run:

```
composer require dusterio/plainsqs
```

Or add it to `composer.json` manually:

```json
{
    "require": {
        "dusterio/plainsqs": "~0.1"
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

## Todo

1. Add more unit and integration tests

## License

The MIT License (MIT)
Copyright (c) 2016 Denis Mysenko

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
