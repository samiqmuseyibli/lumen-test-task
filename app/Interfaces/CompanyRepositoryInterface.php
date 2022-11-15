<?php

namespace App\Interfaces;

interface CompanyRepositoryInterface
{
    public function create(array $data);
    public function find($id);
    public function get();
}
