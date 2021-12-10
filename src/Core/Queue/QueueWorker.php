<?php

declare(strict_types=1);

namespace Core\Queue;

class QueueWorker
{
    /** @var ConsumerMain[] */
    private array $consumers = [];

    public function __construct(array $consumers)
    {
        $this->consumers = $consumers;
    }

    public function run(): void
    {
        echo 'queue-worker start' . PHP_EOL;
        while (true) {
            foreach ($this->consumers as $consumer) {
                $consumer->run();
            }
        }
    }
}