<?php
namespace App\Http\Controllers;

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

        $users = User::where('is_owner', false)->paginate(getPerPage($request));

        return UsersResources::collection($users);

    }

    public function store(UsersStoreRequest $request)
    {
        try {

            $data = $request->validated();

            DB::transaction(function () use ($data, &$users) {

                $users = User::create($data);
                
            });

            return backWithSuccess(
                data: new UsersResources($users)
            );

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function update(UsersUpdateRequest $request, $id)
    {

        $user = User::where('is_owner', false)->findOrFail($id);
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, $user) {

                $user->update($data);

                if (isset($data['password'])) {
                    $user->tokens()->delete();
                }
            });

            return backWithSuccess(
                data: new UsersResources($user)
            );
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function destroy($id)
    {
        $user = User::where('is_owner', false)->findOrFail($id);

        try {

            $user->delete();

            return backWithSuccess();

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
