<?php

namespace App;

use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\RawMessage;

class CustomMailer implements MailerInterface
{

    protected TransportInterface $transport;

    public function __construct(protected string $dsn)
    {
        $this->transport = Transport::fromDsn($dsn);
    }

    public function send(RawMessage $message, Envelope $envelope = null): void
    {
        //todo add some logic before mail sending
        $this->transport->send($message, $envelope);
        //todo add some logic after mail sending
    }
}