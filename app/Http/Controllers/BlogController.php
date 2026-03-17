<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogStoreRequest;
use App\Http\Requests\BlogUpdateRequest;
use App\Http\Resources\BlogResources;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $products = Blog::paginate(getPerPage($request));

        return BlogResources::collection($products);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogStoreRequest $request)
    {
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, $request, &$products) {

                $products = Blog::create($data);

                if ($request->hasFile('image')) {

                    $file = $request->file('image');

                    $products->addOptimizedMediaToCollection($file, 'image');
                }

                return $products;
            });

            return backWithSuccess(
                data: new BlogResources($products)
            );
        } catch (\Exception $e) {
            return backWithError($e);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Blog::findOrFail($id);

        return new BlogResources($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, string $id)
    {
        $blog = Blog::findOrFail($id);
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data, $blog, $request) {
                $blog->update($data);

                if ($request->hasFile('image')) {
                    $file = $request->file('image');

                    $blog->clearMediaCollection('image');
                    $blog->addOptimizedMediaToCollection($file, 'image');
                }
            });

            return backWithSuccess(
                data: new BlogResources($blog)
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
        $blog = Blog::findOrFail($id);

        try {
            $blog->delete();

            return backWithSuccess();
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
