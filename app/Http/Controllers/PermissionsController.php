<?php

namespace App\Http\Controllers;

use App\ApiResponseTrait;
use App\Http\Resources\PermissionsResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    use ApiResponseTrait;

    public function __construct()
    {
        $this->middleware('permission:permission.view')->only(['index', 'show']);
        $this->middleware('permission:permission.create')->only(['store']);
        $this->middleware('permission:permission.update')->only(['update']);
        $this->middleware('permission:permission.delete')->only(['destroy']);
    }
    public function index()
    {
        $permissions = Permission::paginate(10);
        return PermissionsResources::collection($permissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionsResources $request)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data) {
                $permission = Permission::create($data);

                return $this->successResponse(
                    new PermissionsResources($permission)
                );
            });

        } catch (\Exception $e) {
            return $this->errorResponse($e);
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
    public function update(Request $request, Permission $permission)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data, $permission) {
                $permission->update($data);

                return $this->successResponse(
                    new PermissionsResources($permission)
                );
            });

        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();

            return $this->successResponse();

        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
