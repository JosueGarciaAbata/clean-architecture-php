<?php

namespace Application\usecases;

use Application\in\GetUsers;
use Application\out\UserRepository;

class GetUsersInteractor implements GetUsers
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function getAll(): array
    {
        return $this->userRepository->getAll();
    }
}