<?php

namespace App\Repositories;

use App\Models\UserLog;

class UserRepository
{
    protected $model;

    public function __construct(UserLog $user)
    {
        $this->model = $user;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

}