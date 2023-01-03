<?php

namespace Tests\Controllers;

use App\Controllers\AuthController;
use App\Entity\User;
use App\Services\EmailService;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\Mailer\MailerInterface;

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
        //given
        $this->mailer = $this->container->get(MailerInterface::class);
        $user = (new User())
            ->setName("Bogdan")
            ->setEmail("hello@edu.pl");

        $this->mailer->sendWelcomeEmail($user);
    }
}
