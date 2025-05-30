<?php

namespace Application\usecases;

use Application\in\LoginUser;
use Application\in\RegisterUser;
use Application\out\UserRepository;
use Domain\exception\UserEmailAlreadyTakenException;
use Domain\model\User;

class RegisterUserInteractor implements RegisterUser
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(User $user): User
    {
        $exists = $this->userRepository->existsByEmail($user->getEmail());

        if ($exists) {
            throw new UserEmailAlreadyTakenException("Email already exists, email=" . $user->getEmail());
        }

        return $this->userRepository->save($user);
    }
}