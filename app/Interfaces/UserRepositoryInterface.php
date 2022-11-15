<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function create(array $data);
    public function find($id);
    public function update(array $data);
    public function findByEmail($email);
}
