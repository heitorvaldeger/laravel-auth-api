<?php

namespace App\Repository\Contracts;

interface IUserRepository{
    public function login(array $data);
    public function register(array $data);
}