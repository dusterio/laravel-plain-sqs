<?php

namespace Dusterio\PlainSqs\Tests;
use Aws\Sqs\SqsClient;
use Dusterio\PlainSqs\Jobs\DispatcherJob;
use Dusterio\PlainSqs\Sqs\Queue;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;

/**
 * Class QueueTest
 * @package Dusterio\PlainSqs\Tests
 */
class QueueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|SqsClient
     */
    private $sqsClientMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Container
     */
    private $containerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Illuminate\Contracts\Config\Repository
     */
    private $configMock;

    /**
     * @var string
     */
    private $phpVersion;

    protected function setUp()
    {
        parent::setUp();

        $this->sqsClientMock = $this
            ->getMockBuilder(SqsClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['receiveMessage'])
            ->getMock();

        $this->configMock = $this
            ->getMockBuilder(Repository::class)
            ->setMethods(['has', 'set', 'get', 'all', 'prepend', 'push'])
            ->getMock();

        $this->containerMock = $this
            ->getMockBuilder(Container::class)
            ->setMethods(['version', 'offsetGet'])
            ->getMock();

        $this->containerMock
            ->expects($this->any())
            ->method('offsetGet')
            ->will($this->returnValue($this->configMock));

        preg_match("#^\d.\d#", phpversion(), $match);

        $this->phpVersion = $match[0];

        $this->containerMock
            ->expects($this->any())
            ->method('version')
            ->will($this->returnValue('5.8.0'));
    }

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

    public function testSettingJobDisplayName()
    {
        if ($this->phpVersion < 5.6) {
            $this->markTestIncomplete('Needs tests for Laravel versions < 5.4');
        }

        $this->sqsClientMock
            ->expects($this->once())
            ->method('receiveMessage')
            ->will($this->returnValue([
                'Messages' => [
                    json_encode([
                        'Body' => json_encode([
                            'data' => [
                                'foo' => 'bar'
                            ]
                        ])
                    ])
                ]
            ]));


        $this->configMock
            ->expects($this->any())
            ->method('get')
            ->with('sqs-plain.handlers')
            ->will($this->returnValue([
                'default-queue' => 'SomeClass'
            ]));

        $queue = new Queue($this->sqsClientMock, 'default-queue');

        $queue->setContainer($this->containerMock);

        $queue->setConnectionName('default-connection');

        $result = $queue->pop();

        $this->assertEquals('SomeClass', $result->resolveName());
    }
}
