<?php

namespace App\Repositories;

use App\Interfaces;
use App\Models\User;

class UserRepository implements Interfaces\UserRepositoryInterface
{
    /**
     * The relations to eager load.
     *
     * @var
     */
    protected $with = [];

    protected $model;

    function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update(array $data)
    {
        return $this->model->update($data);
    }

    public function findByEmail($email)
    {
        return $this->model->where(['email' => $email])->firstOrFail();
    }

    public function load(User $user, array $relations)
    {
        $user->load($relations);
    }
}
