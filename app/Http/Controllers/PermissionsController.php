<?php
namespace App\Http\Controllers;

use App\Http\Requests\PermissionsStoreRequest;
use App\Http\Requests\PermissionsUpdateRequest;
use App\Http\Resources\PermissionsResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:permission_show')->only(['index', 'show']);
        $this->middleware('permission:permission_create')->only(['store']);
        $this->middleware('permission:permission_update')->only(['update']);
        $this->middleware('permission:permission_delete')->only(['destroy']);
    }
    public function index(Request $request)
    {

        $permissions = Permission::paginate(getPerPage(($request)));

        return PermissionsResources::collection($permissions);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionsStoreRequest $request)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data) {
                Permission::create($data);

            });
            return backWithSuccess();

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function update(PermissionsUpdateRequest $request, Permission $permission)
    {
        $data = $request->validated();

        try {
            
            DB::transaction(function () use ($data, $permission) {

                $permission->update($data);

            });
            return backWithSuccess();

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            
            $permission->roles()->detach();
            $permission->users()->detach();

            $permission->delete();

            return backWithSuccess();
        } catch (\Exception $e) {
            return backWithError($e->getMessage());
        }
    }
}
