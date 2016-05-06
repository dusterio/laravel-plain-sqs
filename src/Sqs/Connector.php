<?php

namespace Dusterio\PlainSqs\Sqs;

use Aws\Sqs\SqsClient;
use Illuminate\Support\Arr;
use Illuminate\Queue\Connectors\SqsConnector;
use Illuminate\Queue\Jobs\SqsJob;

class Connector extends SqsConnector
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        $config = $this->getDefaultConfiguration($config);

        if ($config['key'] && $config['secret']) {
            $config['credentials'] = Arr::only($config, ['key', 'secret']);
        }

        $queue = new Queue(
            new SqsClient($config), $config['queue'], Arr::get($config, 'prefix', '')
        );

        $queue->createJobsUsing(function($container, $sqs, $queue, $response) {
            $queueId = explode('/', $queue);
            $queueId = array_pop($queueId);

            $class = (array_key_exists($queueId, $container['config']->get('sqs-plain.handlers')))
                    ? $container['config']->get('sqs-plain.handlers')[$queueId]
                    : $container['config']->get('sqs-plain.default-handler');

            $response = $response['Messages'][0];
            $body = json_decode($response['Body']);
            $body->job = $class . '@handle';
            $response['Body'] = json_encode($body);

            $job = new SqsJob($container, $sqs, $queue, $response);

            return $job;
        });

        return $queue;
    }
}
