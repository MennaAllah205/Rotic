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
        $this->middleware('permission:show_user')->only(['index', 'show']);
        $this->middleware('permission:create_user')->only(['store']);
        $this->middleware('permission:update_user')->only(['update']);
        $this->middleware('permission:delete_user')->only(['destroy']);
    }

    public function index(Request $request)
    {

        $users = User::where('is_owner', false)->with('roles:id,name')->paginate(getPerPage($request));

        return UsersResources::collection($users);

    }

    public function store(UsersStoreRequest $request)
    {
        try {

            $data  = $request->validated();
            $roles = $data['roles'];

            DB::transaction(function () use ($data, $roles, &$users) {

                $users = User::create($data);

                if (! empty($roles)) {
                    $users->roles()->sync($roles);
                }

                $users->load('roles');
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

        $user  = User::with('roles')->where('is_owner', false)->findOrFail($id);
        $data  = $request->validated();
        $roles = $data['roles'];

        try {

            DB::transaction(function () use ($data, $user, $roles) {

                $user->update($data);

                if (! empty($roles)) {
                    $user->roles()->sync($roles);
                } 

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
