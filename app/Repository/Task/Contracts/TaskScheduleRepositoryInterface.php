<?php

namespace App\Repository\Task\Contracts;


interface TaskScheduleRepositoryInterface
{
    public function getData();
    public function store($request);
    public function update($request, $id);
    public function view($id);
    public function delete($id);
}
