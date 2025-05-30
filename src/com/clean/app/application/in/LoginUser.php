<?php

namespace Application\in;

use Domain\model\User;

interface LoginUser
{

    public function login(User $user): User;

}