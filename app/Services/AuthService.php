<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Exceptions\AuthenticationException;
use App\Exceptions\ValidationException;
use App\Repository\UserRepository;
use Valitron\Validator;

class AuthService
{
    private static int $MIN_PASSWORD_LENGTH = 6;
    private static int $MAX_PASSWORD_LENGTH = 32;

    public function __construct(
        public readonly UserRepository $userRepository)
    {

    }

    public function register(array $userFormData): void
    {
        $this->validateRegisterData($userFormData);
        $newUser = $this->buildUserFromFormData($userFormData);
        $this->userRepository->addUser($newUser);
    }

    private function validateRegisterData(array $newUserData): void
    {
        $v = new Validator($newUserData);
        $v->rule('required', ['name', 'email', 'password', 'confirmPassword']);
        $v->rule('email', 'email')->message(ValidationException::$EMAIL_NOT_CORRECT)->label('Email');;
        $v->rule('equals', 'confirmPassword', 'password')
            ->message(ValidationException::$PASSWORDS_NOT_MATCH)
            ->label('ConfirmPassword');
        $v->rule('lengthBetween', ['password', 'confirmPassword'], static::$MIN_PASSWORD_LENGTH, static::$MAX_PASSWORD_LENGTH)
            ->message(ValidationException::$PASSWORD_LENGTH)
            ->label('Password');
        $v->rule(
            fn($field, $value, $params, $fields) => !$this->userRepository->isEmailTaken($value),
            'email'
        )->message(ValidationException::$EMAIL_TAKEN);

        if ($v->validate()) {
            echo "Yay! We're all good!";
        } else {
            throw new ValidationException($v->errors());
        }
    }

    /**
     * @param array $userData
     * @return User
     */
    public function buildUserFromFormData(array $userData): User
    {
        $newUser = new User();
        $password_hash = password_hash($userData['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        $newUser
            ->setName($userData['name'])
            ->setEmail($userData['email'])
            ->setPaaswordHash($password_hash);
        return $newUser;
    }

    public function validateLoginData(array $userData)
    {
        $v = new Validator($userData);
        $v->rule('required', ['email', 'password']);
        $v->rule('email', 'email')->message(ValidationException::$EMAIL_NOT_CORRECT)->label('Email');;

        if (!$v->validate()) {
            throw new ValidationException(['password' => ['email or password is not valid']]);
        }
    }

    public function checkCredentials(array $userData): User
    {
        $user = $this->userRepository->findOneBy(['email' => $userData['email']]);

        if (!$user) {
            throw new ValidationException(["email" => "Wrong email or password"]);
        }

        $isPasswordValid = password_verify($userData['password'], $user->getPaaswordHash());
        if (!$isPasswordValid) {
            throw new ValidationException(["password" => "Wrong email or password"]);
        }

        return $user;
    }
}