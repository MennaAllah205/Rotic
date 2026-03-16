<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonialClientStoreRequest;
use App\Http\Requests\TestimonialClientUpdateRequest;
use App\Http\Resources\TestimonialClientResources;
use App\Models\TestimonialClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:testimonial_clients_create')->only(['store']);
        $this->middleware('permission:testimonial_clients_update')->only(['update']);
        $this->middleware('permission:testimonial_clients_delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $testimonials = TestimonialClient::paginate(getPerPage($request));

        return TestimonialClientResources::collection($testimonials);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show(string $id)
    {
        $testimonial = TestimonialClient::findOrFail($id);

        return new TestimonialClientResources($testimonial);
    }

    public function store(TestimonialClientStoreRequest $request)
    {
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, &$testimonials) {

                $testimonials = TestimonialClient::create($data);

            });

            return backWithSuccess(
                data: new TestimonialClientResources($testimonials)
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
    public function update(TestimonialClientUpdateRequest $request, $id)
    {

        $category = TestimonialClient::findOrFail($id);
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, &$category) {

                $category->update($data);

            });

            return backWithSuccess(
                data: new TestimonialClientResources($category)
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
        $category = TestimonialClient::findOrFail($id);

        try {
            $category->delete();

            return backWithSuccess();
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
