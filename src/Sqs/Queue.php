<?php

namespace App\Services;

use App\Jobs\DispatcherJob;
use Illuminate\Queue\SqsQueue;
use Illuminate\Support\Facades\Config;

/**
 * Class CustomSqsQueue
 * @package App\Services
 */
class CustomSqsQueue extends SqsQueue
{
    /**
     * Create a payload string from the given job and data.
     *
     * @param  string  $job
     * @param  mixed   $data
     * @param  string  $queue
     * @return string
     */
    protected function createPayload($job, $data = '', $queue = null)
    {
        if (!$job instanceof DispatcherJob) {
            return parent::createPayload($job, $data, $queue);
        }

        $handlerJob = $this->getClass($queue) . '@handle';

        return json_encode(['job' => $handlerJob, 'data' => $job->getPayload()]);
    }

    /**
     * @param $queue
     * @return string
     */
    private function getClass($queue = null)
    {
        if (!$queue) return Config::get('sqs-plain.default-handler');

        $queue = end(explode('/', $queue));

        return (array_key_exists($queue, Config::get('sqs-plain.handlers')))
            ? Config::get('sqs-plain.handlers')[$queue]
            : Config::get('sqs-plain.default-handler');
    }
}