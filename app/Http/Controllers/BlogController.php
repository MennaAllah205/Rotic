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
        // التحقق من أن الـ category_id المرسل هو رقم وموجود فعلياً في جدول categories
        $request->validate([
            'category_id' => 'nullable|integer|exists:categories,id',
        ]);

        $blogs = Blog::with('category:id,name')
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->paginate(getPerPage($request));

        return BlogResources::collection($blogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogStoreRequest $request)
    {
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, $request, &$blog) {

                $blog = Blog::create($data);

                if ($request->hasFile('image')) {

                    $file = $request->file('image');

                    $blog->addOptimizedMediaToCollection($file, 'image');
                }

                return $blog;
            });

            return backWithSuccess(
                data: new BlogResources($blog)
            );
        } catch (\Exception $e) {
            return backWithError($e);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $blog = Blog::with('category:id,name')->firstWhere('slug', $slug);

        return new BlogResources($blog);
    }

    public function select(Request $request)
    {
        $blogs = Blog::select('id', 'title')
            ->get();

        return backWithSuccess(
            data: $blogs
        );

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
