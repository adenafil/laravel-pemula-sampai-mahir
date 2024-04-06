<?php

namespace App\Services\Impl;

use App\Services\UserServices;

class UserServiceImpl implements UserServices
{
    private array $user = [
        "ade" => "rahasia"
    ];

    function login(string $user, string $password): bool
    {
        if (!isset($this->user[$user])) {
            return false;
        }

        $correctPassword = $this->user[$user];

        return $password == $correctPassword;

    }
}
