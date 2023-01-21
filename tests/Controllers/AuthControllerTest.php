<?php

namespace Tests\Controllers;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Tests\App\Dto\EmailService;

class AuthControllerTest extends TestCase
{
    private ContainerInterface $container;
    private MailerInterface $mailer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = require(__DIR__ . '/../../bootstrap.php');
    }
    public function test_SendWelcomeEmail()
    {
        //todo test fail
        //given
        $this->mailer = $this->container->get(MailerInterface::class);
        $user = (new User())
            ->setName("Bogdan")
            ->setEmail("hello@edu.pl");

        $this->mailer->sendWelcomeEmail($user);
    }
}
