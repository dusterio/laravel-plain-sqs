<?php

namespace Dusterio\PlainSqs\Sqs;

use Dusterio\PlainSqs\Jobs\DispatcherJob;
use Illuminate\Queue\SqsQueue;
use Illuminate\Support\Facades\Config;

/**
 * Class CustomSqsQueue
 * @package App\Services
 */
class Queue extends SqsQueue
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

        return $job->isPlain() ? json_encode($job->getPayload()) : json_encode(['job' => $handlerJob, 'data' => $job->getPayload()]);
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
    
    /**
     * Push a raw payload onto the queue.
     *
     * @param  string  $payload
     * @param  string  $queue
     * @param  array   $options
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = [])
    {
        $payload = json_decode($payload, true);

        $response = $this->sqs->sendMessage(['QueueUrl' => $this->getQueue($queue), 'MessageBody' => array_key_exists('was_plain', $payload) ? json_encode($payload['data']) : json_encode($payload)]);

        return $response->get('MessageId');
    }
}
