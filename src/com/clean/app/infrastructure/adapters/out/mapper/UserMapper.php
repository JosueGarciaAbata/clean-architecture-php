<?php

namespace Infrastructure\adapters\out\mapper;

use Infrastructure\adapters\out\UserEntity;
use Domain\model\User;

class UserMapper
{

    public static function toEntity(User $user): UserEntity {

        $entity = new UserEntity(
            $user->getName(),
            $user->getEmail(),
            $user->getPassword()
        );

        if ($user->getId() !== null) {
            $entity->setId($user->getId());
        }

        return $entity;
    }

    public static function toUser(UserEntity $entity): User
    {
        $user = new User(
            $entity->getEmail(),
            $entity->getEmail(),
            $entity->getPassword()
        );

        $user->setId($entity->getId());

        return $user;
    }
}