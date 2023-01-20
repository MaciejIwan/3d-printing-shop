<?php

declare(strict_types=1);

namespace App\Commands;

use App\Contracts\UserProviderServiceInterface;
use App\Dto\RegisterUserData;
use App\Enum\UserRole;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddAdmin extends Command
{

    public function __construct(protected UserProviderServiceInterface $userProviderService)
    {
        parent::__construct();
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the admin')
            ->addArgument('email', InputArgument::REQUIRED, 'Email of the admin')
            ->addArgument('pass', InputArgument::REQUIRED, 'Password of the admin');
    }

    protected static $defaultName = 'app:add-admin';
    protected static $defaultDescription = 'Use as: app:add-admin';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument("name");
        $email = $input->getArgument("email");
        $password = $input->getArgument("pass");

        $newUserDto = new RegisterUserData($name, $email, $password, UserRole::Admin);
        $this->userProviderService->createUser($newUserDto);

        $output->write('Admin account added. You can login', true);
        return Command::SUCCESS;
    }
}
