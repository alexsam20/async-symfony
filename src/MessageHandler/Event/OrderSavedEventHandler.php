<?php

namespace App\MessageHandler\Event;

use App\Message\Event\OrderSavedEvent;
use Mpdf\Mpdf;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class OrderSavedEventHandler
{

    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke(OrderSavedEvent $event)
    {
        $mpdf = new Mpdf();
        $content = "<h1>Contract Note For Order {$event->getOrderId()}</h1>";
        $content .= '<p>Total: <b>$ 1898.75</b></p>';
        $content .= '<hr>';
        $content .= '<p>alexsam2070@gmail.com</p>';

        $mpdf->writeHTML($content);
        $contractNotePdf = $mpdf->output('', 'S');

        $email = (new Email())
            ->from('sales@stacksapp.com')
            ->to('email@example.com')
            ->subject('Contact note for order ' . $event->getOrderId())
            ->text('Here is your contract note')
            ->attach($contractNotePdf, 'contract-note.pdf');

        $this->mailer->send($email);
    }
}