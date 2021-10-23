<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('phone_number', 'password');

        try {
            if ($token = $this->guard()->attempt($credentials)) {
                return $this->respondWithToken($token);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Auth failed.'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
            'user' => [
                'name' => $this->guard()->user()->name
            ],
            'roles' => $this->guard()->user()->roles->pluck('name')->first(),
            'permissions' => $this->guard()->user()->getAllPermissions()->pluck('name')->all()
        ]);
    }

    public function permissions()
    {
        return response()->json([
            'permissions' => $this->guard()->user()->getAllPermissions()->pluck('name')->all()
        ]);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
