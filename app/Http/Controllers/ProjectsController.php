<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectsStoreRequest;
use App\Http\Requests\ProjectsUpdateRequest;
use App\Http\Resources\ProjectsResources;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function store(ProjectsStoreRequest $request)
    {
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, $request, &$projects) {

                $projects = Project::create($data);

                if ($request->hasFile('logo')) {

                    $file = $request->file('logo');

                    $this->addOptimizedMedia($projects, $file, 'logo');
                }

                return $projects;
            });

            return backWithSuccess(
                data: new ProjectsResources($projects)
            );
        } catch (\Exception $e) {
            return backWithError($e);
        }

    }
    /**
     * Display the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectsUpdateRequest $request, string $id)
    {
        $project = Project::findOrFail($id);
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data, $project) {
                $project->update($data);
            });

            return backWithSuccess(
                data: new ProjectsResources($project)
            );
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
