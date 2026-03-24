<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesStoreRequest;
use App\Http\Requests\CategoriesUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_category')->only(['store']);
        $this->middleware('permission:update_category')->only(['update']);
        $this->middleware('permission:delete_category')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $categories = Category::paginate(getPerPage($request));

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return new CategoryResource($category);
    }

    public function store(CategoriesStoreRequest $request)
    {
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, &$categories) {

                $categories = Category::create($data);

            });

            return backWithSuccess(
                data: new CategoryResource($categories)
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
    public function update(CategoriesUpdateRequest $request, $id)
    {

        $category = Category::findOrFail($id);
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, &$category) {

                $category->update($data);

            });

            return backWithSuccess(
                data: new CategoryResource($category)
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
        $category = Category::findOrFail($id);

        try {
            $category->delete();

            return backWithSuccess();
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
