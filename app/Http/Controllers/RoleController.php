<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRolesRequest;
use App\Http\Requests\UpdateRolesRequest;
use App\Http\Resources\RolesResources;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Request;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:role_show')->only(['index', 'show']);
        $this->middleware('permission:role_create')->only(['store']);
        $this->middleware('permission:role_update')->only(['update']);
        $this->middleware('permission:role_delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::with('permissions')
            ->paginate(getPerPage($request));

        return RolesResources::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRolesRequest $request)
    {
        $data = $request->validated();
        try {
            DB::transaction(function () use ($data, &$role) {

                $role = Role::create($data);

                $role->syncPermissions($data['permissions']);

            });
            return backWithSuccess();
        } catch (\Exception $e) {
            return backWithError($e);
        }

    }

    /**
     * Show the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRolesRequest $request, $id)
    {
        $data = $request->validated();
        $role = Role::findOrFail($id);

        try {
            DB::transaction(function () use ($data, $role) {
                $role->update($data);

                if (isset($data['permissions'])) {
                    $role->syncPermissions($data['permissions']);
                }

            });
            return backWithSuccess();
        } catch (\Exception $e) {
            return backWithError($e);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        try {

            DB::transaction(function () use ($role) {

                // if ($role->permissions()->count() > 0) {
                //     throw new \Exception('Cannot delete role that has permissions');
                // }

                //users

                $role->delete();
            });

            return backWithSuccess('Role deleted successfully');
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
