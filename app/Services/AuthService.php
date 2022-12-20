<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Exceptions\ValidationException;
use App\Repository\UserRepository;
use Valitron\Validator;

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

        $v = new Validator(array('name' => 'Chester Tester'));
        $v->rule('required', ['name', 'email', 'password', 'confirmPassword']);
        $v->rule('email', 'email');
        $v->rule('equals', ['password', 'confirmPassword']);

        $v->rule(fn($field, $value, $params, $fields) => $this->userRepository->count(
            ['email' => $value]), 'email'
        )->message("User with given email already exists");

        if ($v->validate()) {
            echo "All fine!";
        } else {
            throw new ValidationException($v->errors());
        }
    }
}