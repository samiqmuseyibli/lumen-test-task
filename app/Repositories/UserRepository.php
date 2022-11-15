<?php

namespace App\Repositories;

use App\Interfaces;
use App\Models\User;

class UserRepository implements Interfaces\UserRepositoryInterface
{

    public function create(array $data)
    {
        return User::create($data);
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function update(array $data)
    {
        return User::update($data);
    }

    public function findByEmail($email)
    {
        return User::where(['email' => $email])->firstOrFail();
    }
}
