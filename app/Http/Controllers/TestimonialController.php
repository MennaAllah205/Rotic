<?php
namespace App\Http\Controllers;

use App\Http\Requests\TestimonialStoreRequest;
use App\Http\Requests\TestimonialUpdateRequest;
use App\Http\Resources\TestimonialResources;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:testimonial_create')->only(['store']);
        $this->middleware('permission:testimonial_update')->only(['update']);
        $this->middleware('permission:testimonial_delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $testimonials = Testimonial::paginate(getPerPage($request));

        return TestimonialResources::collection($testimonials);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        return new TestimonialResources($testimonial);
    }

    public function store(TestimonialStoreRequest $request)
    {
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, &$testimonials) {

                $testimonials = Testimonial::create($data);

            });

            return backWithSuccess(
                data: new TestimonialResources($testimonials)
            );
        } catch (\Exception $e) {
            return backWithError($e);
        }

    }

    public function update(TestimonialUpdateRequest $request, $id)
    {

        $testimonial = Testimonial::findOrFail($id);
        $data        = $request->validated();

        try {

            DB::transaction(function () use ($data, &$testimonial) {

                $testimonial->update($data);

            });

            return backWithSuccess(
                data: new TestimonialResources($testimonial)
            );
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function destroy(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        try {
            $testimonial->delete();

            return backWithSuccess();
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
