<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\Create;
use App\Http\Requests\Task\Update;
use App\Repository\Task\TaskScheduleRepository;


class TaskScheduleController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:task-list|task-create|task-edit|task-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:task-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:task-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]);
    }

    /**
     * fetch all Tasks from database
     */

    public function index(TaskScheduleRepository $task)
    {
        try {
            $tasks = $task->getData();
            return response()->json([
                'status' => 'success',
                'tasks' => $tasks
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * store Task into database
     * 
     */

    public function store(Create $request, TaskScheduleRepository $task)
    {
        try {
            $task->store($request);
            return response()->json(['message' => 'Task added.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    /**
     * update existing Task into database
     * 
     */

    public function update(Update $request, $id, TaskScheduleRepository $task)
    {
        try {
            $data = $task->update($request, $id);
            return response()->json(['message' => 'Task updated.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    /**
     * Display the specified Task from database
     * 
     */

    public function show($id, TaskScheduleRepository $task)
    {
        try {
            $data = $task->view($id);
            return response()->json(['task' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    /**
     * Delete the specified task from database
     */

    public function destroy($id, TaskScheduleRepository $task)
    {
        try {
            $task->delete($id);
            return response()->json(['message' => "Task deleted"], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
