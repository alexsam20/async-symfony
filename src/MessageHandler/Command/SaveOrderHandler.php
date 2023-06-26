<?php

namespace App\MessageHandler\Command;

use App\Message\Command\SaveOrder;
use App\Message\Event\OrderSavedEvent;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SaveOrderHandler implements MessageHandlerInterface
{
    public function __construct(private MessageBusInterface $eventBus)
    {
    }

    public function __invoke(SaveOrder $saveOrder)
    {
        $orderId = 123;

        echo 'Order being saved' . PHP_EOL;

        $this->eventBus->dispatch(new OrderSavedEvent($orderId));
    }
}