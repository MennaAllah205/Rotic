<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectsStoreRequest;
use App\Http\Requests\ProjectsUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:create_project')->only(['store']);
        $this->middleware('permission:update_project')->only(['update']);
        $this->middleware('permission:delete_project')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $projects = Project::with('client')->paginate(getPerPage($request));

        return ProjectResource::collection($projects);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectsStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $project = DB::transaction(function () use ($data, $request) {

                $project = Project::create($data);

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        $project->addMedia($file)->toMediaCollection('images');
                    }
                }

                return $project;
            });

            return backWithSuccess(
                data: new ProjectResource($project)
            );

            return backWithSuccess(
                data: new ProjectResource($projects)
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
    public function show(string $id)
    {
        $project = Project::with('client')->findOrFail($id);

        return new ProjectResource($project);
    }

    public function update(ProjectsUpdateRequest $request, string $id)
    {
        $project = Project::findOrFail($id);
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data, $project, $request) {
                $project->update($data);

                if ($request->hasFile('images')) {

                    foreach ($request->file('images') as $file) {

                        $project->addOptimizedMediaToCollection($file, 'images');
                    }
                }
            });

            return backWithSuccess(
                data: new ProjectResource($project)
            );
        } catch (\Exception $e) {
            return backWithError($e);
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
