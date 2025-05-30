<?php

namespace Application\usecases;

use Application\in\LoginUser;
use Application\out\UserRepository;
use Domain\exception\PasswordIncorrectException;
use Domain\exception\UserWithoutEmailException;
use Domain\model\User;

class LoginUserInteractor implements LoginUser
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function login(User $user): User
    {
        $bool = $this->userRepository->existsByEmail($user->getEmail());

        if (!$bool) {
            throw new UserWithoutEmailException("User with email {$user->getEmail()} not found");
        }

        $found = $this->userRepository->findByEmail($user->getEmail());

        $ok = password_verify($user->getPassword(), $found->getPassword());

        if (!$ok) {
            throw new PasswordIncorrectException("Incorrect password");
        }

        return $found;
    }
}