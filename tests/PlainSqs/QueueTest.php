<?php

namespace Dusterio\PlainSqs\Tests;

use Dusterio\PlainSqs\Jobs\DispatcherJob;
use Dusterio\PlainSqs\Sqs\Queue;
use PHPUnit\Framework\TestCase;

/**
 * Class QueueTest
 * @package Dusterio\PlainSqs\Tests
 */
class QueueTest extends TestCase
{
    /**
     * @test
     */
    public function class_named_is_derived_from_queue_name()
    {

        $content = [
            'test' => 'test'
        ];

        $job = new DispatcherJob($content);

        $queue = $this->getMockBuilder(Queue::class)
            ->disableOriginalConstructor()
            ->getMock();

        $method = new \ReflectionMethod(
            'Dusterio\PlainSqs\Sqs\Queue', 'createPayload'
        );

        $method->setAccessible(true);

        //$response = $method->invokeArgs($queue, [$job]);
    }
}
