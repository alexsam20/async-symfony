<?php

namespace App\MessageHandler;

use App\Message\PurchaseConfirmationNotification;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class PurchaseConfirmationNotificationHandler
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke(PurchaseConfirmationNotification $notification)
    {
        echo 'Emailing contract note to ' . $notification->getOrder()->getBuyer()->getEmail() . '<br>';

        $email = (new Email())
            ->from('sales@stacksapp.com')
            ->to($notification->getOrder()->getBuyer()->getEmail())
            ->subject('Contact note for order ' . $notification->getOrder()->getId())
            ->text('Here is your contract note');

        $this->mailer->send($email);
    }
}