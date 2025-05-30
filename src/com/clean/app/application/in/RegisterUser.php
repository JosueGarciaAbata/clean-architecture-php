<?php

namespace Application\in;

use Domain\model\User;

interface RegisterUser
{

    public function register(User $user): User;

}