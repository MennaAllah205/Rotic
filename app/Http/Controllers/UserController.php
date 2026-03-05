<?php

namespace App\Http\Controllers\API;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersStoreRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Http\Resources\UsersResources;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        $this->middleware('permission:user_view')->only(['index', 'show']);
        $this->middleware('permission:user_create')->only(['store']);
        $this->middleware('permission:user_update')->only(['update']);
        $this->middleware('permission:user_delete')->only(['destroy']);
    }

    public function index()
    {
        $users = User::paginate(10);

        return UsersResources::collection($users);
    }

    public function store(UsersStoreRequest $request)
    {
        try {
            $data = $request->validated();
            DB::transaction(function () use ($data, &$user) {

                $user = User::create($data);
            });

            return $this->successResponse(
                new UsersResources($user)
            );

        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function show(User $user)
    {
        return new UsersResources($user);
    }

    public function update(UsersUpdateRequest $request, User $user)
    {
        try {
            $data = $request->validated();

            DB::transaction(function () use ($data, &$user) {
                $user->update($data);
            });


            return $this->successResponse(
                new UsersResources($user)
            );

        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            return $this->successResponse();

        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
