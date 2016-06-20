<?php

namespace Dusterio\PlainSqs\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DispatcherJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var bool
     */
    protected $plain = false;

    /**
     * DispatchedJob constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        if (! $this->isPlain()) {
            return [
                'job' => app('config')->get('sqs-plain.default-handler'),
                'data' => $this->data
            ];
        }

        return $this->data;
    }

    /**
     * @param bool $plain
     * @return $this
     */
    public function setPlain($plain = true)
    {
        $this->plain = $plain;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPlain()
    {
        return $this->plain;
    }
}