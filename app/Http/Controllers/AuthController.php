<?php

namespace App\Http\Controllers;

use App\ApiResponseTrait;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;
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
            
            return $this->successResponse($result);

        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $user = User::where('email', $data['login'])
                ->orWhere('phone', $data['login'])
                ->first();
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return $this->errorResponse('Invalid Credentials');
            }
            $token = $user->createToken('auth_token')->plainTextToken;
            DB::commit();
            return $this->successResponse([
                'user' => $user->only('name'),
                'token' => $token
            ], );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e);
        }
    }

    public function logout(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $request->user()->currentAccessToken()->delete();
            });
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
