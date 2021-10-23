<?php

namespace App\Repository\User;

use App\Models\User;
use App\Repository\User\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->user_inputs = [
            'name',
            'designation',
            'address',
            'phone_number',
            'status',
            'password'
        ];
    }

    public function getData()
    {
        return $this->user->with('roles')->latest()->get();
    }

    public function store($request)
    {
        $input = $request->only($this->user_inputs);
        $input['password'] = bcrypt($request->password);
        $user = User::create($input);
        $user->assignRole($request->roles);
        return $user;
    }

    public function update($request, $id)
    {
        $input = $request->only($this->user_inputs);
        if (!empty($request->password)) {
            $input['password'] = bcrypt($request->password);
        }
        $user = $this->user->find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->roles);

        return $user;
    }

    public function view($id)
    {
        return $this->user->with('roles')->findOrFail($id);
    }

    public function delete($id)
    {
        return $this->user->findOrFail($id)->delete();
    }
}
