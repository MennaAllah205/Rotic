<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionsStoreRequest;
use App\Http\Requests\PermissionsUpdateRequest;
use App\Http\Resources\PermissionsResources;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;


class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:permission_view')->only(['index', 'show']);
        $this->middleware('permission:permission_create')->only(['store']);
        $this->middleware('permission:permission_update')->only(['update']);
        $this->middleware('permission:permission_delete')->only(['destroy']);
    }
    public function index()
    {
        $permissions = Permission::paginate(10);
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

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return new PermissionsResources($permission);
    }

    /**
     * Update the specified resource in storage.
     */
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
