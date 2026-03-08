<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersStoreRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Http\Resources\UsersResources;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:user_show')->only(['index', 'show']);
        $this->middleware('permission:user_create')->only(['store']);
        $this->middleware('permission:user_update')->only(['update']);
        $this->middleware('permission:user_delete')->only(['destroy']);
    }

    public function index(Request $request)
    {

        $users = User::paginate(getPerPage($request));

        return UsersResources::collection($users);

    }

    public function store(UsersStoreRequest $request)
    {
        try {

            $data = $request->validated();

            DB::transaction(function () use ($data) {

                User::create($data);
            });

            return backWithSuccess();

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
    public function show(User $user)
    {
        return new UsersResources($user);
    }

    public function update(UsersUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, &$user) {
                
                $user->update($data);




            });

            return backWithSuccess();

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            return backWithSuccess();

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
