<?php

declare(strict_types=1);

namespace App\commands;

use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MyCommand extends Command
{
    public function __construct(protected UserRepository $userRepository)
    {
        parent::__construct();
    }

    protected static $defaultName = 'app:count-users';
    protected static $defaultDescription = 'show users count';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->userRepository->findAll();
        $output->write('User count: ' . count($users), true);
        return Command::SUCCESS;
    }
}