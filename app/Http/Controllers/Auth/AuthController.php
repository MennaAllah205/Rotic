<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function register(RegisterRequest $request)
    // {
    //     try {
    //         $result = DB::transaction(function () use ($request) {
    //             $data = $request->validated();
    //             $user = User::create($data);
    //             $token = $user->createToken('auth_token')->plainTextToken;
    //             return [
    //                 'user' => $user->only('name'),
    //                 'token' => $token
    //             ];
    //         });

    //         return backWithSuccess(data: $result);
    //     } catch (\Exception $e) {
    //         return backWithError($e);
    //     }
    // }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        try {

            $loginField = filter_var($data['credential'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

            DB::beginTransaction();

            $user = User::where($loginField, $data['credential'])->first();

            if (! $user || ! Hash::check($data['password'], $user->password)) {
                return backWithWarning('بيانات غير صالحة', 'Invalid Credentials', 401);
            }

            $token = $user->createToken($request->userAgent())->plainTextToken;

            DB::commit();

            return backWithSuccess(data: [
                'user' => $user->only('name'),
                'token' => $token,
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

            return backWithSuccess();
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
