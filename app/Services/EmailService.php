<?php

namespace App\Services;

use App\Contracts\UserInterface;
use Slim\Views\Twig;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

class EmailService implements MailerInterface
{

    protected TransportInterface $transport;

    public function __construct(
        protected string      $dsn,
        private readonly Twig $twig,
    )
    {
        $this->transport = Transport::fromDsn($dsn);
    }

    public function sendWelcomeEmail(UserInterface $user): void
    {
        $text = "Hello " . $user->getName() . ", Thank you for signing up!";
        $html = $this->twig->fetch("email/welcome.twig", ['name' => $user->getName()]);

        //todo should get these data from app config
        $email = (new Email())
            ->from('noreplay@3dprintingapp.com')
            ->to($user->getEmail())
            ->subject('Your Account At 3d-printing Lodz Has Been Created')
            ->text($text)
            ->html($html);

        $this->send($email);
    }

    public function send(RawMessage $message, Envelope $envelope = null): void
    {
        //todo add some logic before mail sending
        $this->transport->send($message, $envelope);
        //todo add some logic after mail sending
    }

}