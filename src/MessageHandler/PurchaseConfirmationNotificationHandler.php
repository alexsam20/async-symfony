<?php

namespace App\MessageHandler;

use App\Message\PurchaseConfirmationNotification;
use Mpdf\Mpdf;
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
        $mpdf = new Mpdf();
        $content = "<h1>Contract Note For Order {$notification->getOrderId()}</h1>";
        $content .= '<p>Total: <b>$1898.75</b></p>';

        $mpdf->writeHTML($content);
        $contractNotePdf = $mpdf->output('', 'S');

        $email = (new Email())
            ->from('sales@stacksapp.com')
            ->to('email@example.com')
            ->subject('Contact note for order ' . $notification->getOrderId())
            ->text('Here is your contract note')
            ->attach($contractNotePdf, 'contract-note.pdf');

        $this->mailer->send($email);
    }
}