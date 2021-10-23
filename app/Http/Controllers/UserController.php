<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\Create;
use App\Http\Requests\User\Update;
use App\Repository\User\UserRepository;


class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:employee-list|employee-create|employee-edit|employee-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:employee-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:employee-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:employee-delete', ['only' => ['destroy']]);
    }

    /**
     * fetch all users from database
     */

    public function index(UserRepository $user)
    {
        try {
            $users = $user->getData();
            return response()->json([
                'status' => 'success',
                'users' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * store user into database
     * 
     */

    public function store(Create $request, UserRepository $user)
    {
        try {
            $user->store($request);
            return response()->json(['message' => 'User added.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    /**
     * update existing user into database
     * 
     */

    public function update(Update $request, $id, UserRepository $user)
    {
        try {
            $data = $user->update($request, $id);
            return response()->json(['message' => 'User updated.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    /**
     * Display the specified user from database
     * 
     */

    public function show($id, UserRepository $user)
    {
        try {
            $data = $user->view($id);
            return response()->json(['user' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    /**
     * Delete the specified product from database
     */

    public function destroy($id, UserRepository $user)
    {
        try {
            $user->delete($id);
            return response()->json(['message' => "User deleted"], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
