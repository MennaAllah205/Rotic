<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectsRequest;
use App\Http\Resources\ProjectsResources;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:projects_show')->only(['index', 'show']);
        $this->middleware('permission:projects_create')->only(['store']);
        $this->middleware('permission:projects_update')->only(['update']);
        $this->middleware('permission:projects_delete')->only(['destroy']);
    }
    public function index(Request $request)
    {
        $projects = Project::paginate(getPerPage($request));
        return ProjectsResources::collection($projects);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectsRequest $request)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data) {
                $project = Project::create($data);

                return new ProjectsResources($project);
            });
        } catch (\Exception $e) {
            backWithError($e);
        }

    }

    /**
     * Display the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data, $project) {
                $project->update($data);

                return new ProjectsResources($project);
            });
        } catch (\Exception $e) {
            backWithError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        try {
            $project->delete();

            return backWithSuccess();
        } catch (\Exception $e) {
            backWithError($e);
        }
    }
}
