<?php

namespace Application\out;

use Domain\model\User;

interface UserRepository
{
    public function save(User $user): User;
    public function existsByEmail(string $email): bool;

    public function findByEmail(string $email): User;

    public function getAll();
}