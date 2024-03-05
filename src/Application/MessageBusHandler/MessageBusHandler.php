<?php

namespace App\Application\MessageBusHandler;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class MessageBusHandler
{

    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly MessageBusInterface $queryBus,
        private readonly MessageBusInterface $eventBus,
    ){
    }


    public function handleCommand($message)
    {
        $res = $this->commandBus->dispatch($message);

        return $this->processMessage($res);
    }

    public function handleEvent($message, ?array $stamps = [])
    {
        $res = $this->eventBus->dispatch($message, $stamps);

        return $this->processMessage($res);
    }

    public function handleQuery($message)
    {
        $res = $this->queryBus->dispatch($message);

        return $this->processMessage($res);
    }

    private function processMessage(Envelope $envelope)
    {
        $handled = $envelope->last(HandledStamp::class);

        return $handled?->getResult();
    }


}
