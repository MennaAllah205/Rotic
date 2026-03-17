<?php
namespace App\Http\Controllers;

use App\Http\Requests\RolesStoreRequest;
use App\Http\Requests\RolesUpdateRequest;
use App\Http\Resources\RolesResources;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_role')->only(['index', 'show']);
        $this->middleware('permission:create_role')->only(['store']);
        $this->middleware('permission:update_role')->only(['update']);
        $this->middleware('permission:delete_role')->only(['destroy']);
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
    public function store(RolesStoreRequest $request)
    {
        $data               = $request->validated();
        $data['guard_name'] = 'web';
        try {
            DB::transaction(function () use ($data, &$role) {

                $role = Role::create($data);

                $this->syncRolePermissions($role, $data['permissions']);

            });

            return backWithSuccess(
                data: new RolesResources($role),
            );
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
    public function update(RolesUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $role = Role::findOrFail($id);

        try {
            DB::transaction(function () use ($data, $role) {

                $role->update($data);

                $this->syncRolePermissions($role, $data['permissions']);

            });

            return backWithSuccess(data: new RolesResources($role));
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

                if ($role->id == 1) {
                    return backWithWarning('لا يمكنك حذف دور المالك', 'Cannot delete the owner role.');
                }
                if ($role->users()->count() > 0) {
                    return backWithWarning('يوجد مستخدمين مرتبطين بهذا الدور', 'Cannot delete role because it has users.');
                }

                $role->delete();
            });

            return backWithSuccess();

        } catch (\Exception $e) {

            return backWithError($e->getMessage());
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    private function syncRolePermissions(Role $role, array $permissionNames): void
    {
        $existingPermissions = Permission::whereIn('name', $permissionNames)
            ->pluck('name')
            ->toArray();

        $newPermissions = array_diff($permissionNames, $existingPermissions);

        if (! empty($newPermissions)) {
            $insertData = collect($newPermissions)->map(fn($name) => [
                'name'       => $name,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray();

            Permission::insertOrIgnore($insertData);
        }

        $role->syncPermissions($permissionNames);
    }

}
