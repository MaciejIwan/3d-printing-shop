<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;

class AuthService
{

    public function __construct(
        private readonly UserRepository $userRepository)
    {

    }

    public function register(User $new_user)
    {
        //todo validate data
        #$this->validateRegisterData($new_user);
        $this->userRepository->addUser($new_user);
    }

    private function validateRegisterData(User $new_user)
    {
//        throw error if user with given email exists
        #$this->userRepository->findOneBy($new_user->getEmail());
    }
}