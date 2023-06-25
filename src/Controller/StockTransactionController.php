<?php

namespace App\Controller;

use App\Message\PurchaseConfirmationNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class StockTransactionController extends AbstractController
{
    #[Route('/buy', name: 'buy-stocks')]
    public function buy(MessageBusInterface $bus): Response
    {
        $order = new class {
            public function getId(): int
            {
                return 1;
            }
            public function getBuyer(): object
            {
                return new class {
                    public function getEmail(): string
                    {
                        return 'email@example.com';
                    }
                };
            }
        };

        $bus->dispatch(new PurchaseConfirmationNotification($order->getId()));

        return $this->render('stocks/example.html.twig');
    }
}