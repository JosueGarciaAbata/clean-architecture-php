<?php

namespace Domain\exception;

class UserEmailAlreadyTakenException extends \RuntimeException
{
    public function UserEmailAlreadyTakenException(string $message) {
        parent::__construct($message);
    }
}