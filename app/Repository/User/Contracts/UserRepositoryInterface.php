<?php

namespace App\Repository\User\Contracts;


interface UserRepositoryInterface
{
    public function getData();
    public function store($request);
    public function update($request, $id);
    public function view($id);
    public function delete($id);
}
