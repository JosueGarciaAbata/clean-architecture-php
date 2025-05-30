<?php

namespace Domain\exception;

class UserWithoutEmailException extends \RuntimeException
{
    public function  __construct(string $message)
    {
        parent::__construct($message);
    }

}