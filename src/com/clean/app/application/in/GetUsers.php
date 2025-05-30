<?php

namespace Application\in;

use Domain\model\User;

interface GetUsers
{

    /**
     * @return User[]
     */
    public function getAll(): array;

}