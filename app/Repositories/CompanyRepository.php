<?php

namespace App\Repositories;

use App\Interfaces;
use App\Models\Company;

class CompanyRepository implements Interfaces\CompanyRepositoryInterface
{

    public function create(array $data)
    {
        return Company::create($data);
    }

    public function find($id)
    {
        return Company::findOrFail($id);
    }

    public function get()
    {
        return Company::all();
    }
}
