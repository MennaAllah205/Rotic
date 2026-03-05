<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $data = $request->validated();
                $user = User::create($data);
                $token = $user->createToken('auth_token')->plainTextToken;
                return [
                    'user' => $user->only('name'),
                    'token' => $token
                ];
            });
            
            return backWithSuccess('User registered successfully', $result);

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $user = User::where('email', $data['email'])
                ->orWhere('phone', $data['phone'])
                ->first();
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return backWithWarning('بيانات الاعتماد غير صالحة', 'Invalid Credentials');
            }
            $token = $user->createToken('auth_token')->plainTextToken;
            DB::commit();
            return backWithSuccess('Login successful', [
                'user' => $user->only('name'),
                'token' => $token
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return backWithError($e);
        }
    }

    public function logout(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $request->user()->currentAccessToken()->delete();
            });
            return backWithSuccess('Logout successful');
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
