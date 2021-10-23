<?php

namespace App\Repository\Task;

use App\Models\TaskSchedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repository\Task\Contracts\TaskScheduleRepositoryInterface;

class TaskScheduleRepository implements TaskScheduleRepositoryInterface
{

    public function __construct(TaskSchedule $task)
    {
        $this->task = $task;
        $this->task_inputs = [
            'employee_id',
            'task_title',
            'tast_description',
            'start_date',
            'end_date',
            'status',
        ];
    }

    public function getData()
    {
        $user_roles = User::find(Auth::user()->id)->getRoleNames();
        $roles = [];
        foreach ($user_roles as $role) {
            $roles[] = $role;
        }
        if (in_array("Admin", $roles)) {
            return $this->task->with('employee')->latest()->get();
        } else {
            return $this->task->with('employee')->where('employee_id', Auth::user()->id)->latest()->get();
        }
    }

    public function store($request)
    {
        $input = $request->only($this->task_inputs);
        $input['password'] = bcrypt($request->password);

        return TaskSchedule::create($input);
    }

    public function update($request, $id)
    {
        $input = $request->only('end_date', 'status');
        if (!empty($request->password)) {
            $input->password = bcrypt($request->password);
        }
        $task = $this->task->findOrFail($id);

        return $task->update($input);
    }

    public function view($id)
    {
        return $this->task->findOrFail($id);
    }

    public function delete($id)
    {
        return $this->task->findOrFail($id)->delete();
    }
}
