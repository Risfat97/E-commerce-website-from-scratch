<?php

namespace App\user\model;

use App\user\classes as classes;

interface UserRepository
{
    public function addUser(classes\User $user, string $username, string $password): bool;
    public function getUser(string $username, string $password): ?classes\User;
    public function getUsers(): array;
}
?>