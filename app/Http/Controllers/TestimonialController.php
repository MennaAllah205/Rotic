<?php
namespace App\Http\Controllers;

use App\Http\Requests\TestimonialStoreRequest;
use App\Http\Requests\TestimonialUpdateRequest;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $testimonials = Testimonial::paginate(getPerPage($request));

        return TestimonialResource::collection($testimonials);
    }

    public function show(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        return new TestimonialResource($testimonial);
    }

    public function store(TestimonialStoreRequest $request)
    {
        $data        = $request->validated();
        $testimonial = null;

        try {
            DB::transaction(function () use ($data, &$testimonial, $request) {
                $testimonial = Testimonial::create($data);

                // إضافة اللوجو في حالة الرفع
                if ($request->hasFile('logo')) {
                    $testimonial->addMediaFromRequest('logo')->toMediaCollection('logo');
                }
            });

            return backWithSuccess(
                data: new TestimonialResource($testimonial)
            );
        } catch (\Exception $e) {
            return backWithError($e->getMessage());
        }
    }

    public function update(TestimonialUpdateRequest $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $data        = $request->validated();

        try {
            DB::transaction(function () use ($data, $testimonial, $request) {
                $testimonial->update($data);

                // تحديث اللوجو: إذا تم رفع ملف جديد، سيقوم Spatie باستبدال القديم تلقائياً
                // بشرط وجود singleFile() في الموديل
                if ($request->hasFile('logo')) {
                    $testimonial->addMediaFromRequest('logo')->toMediaCollection('logo');
                }
            });

            return backWithSuccess(
                data: new TestimonialResource($testimonial->fresh())
            );
        } catch (\Exception $e) {
            return backWithError($e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        try {
            // ملاحظة: مكتبة Spatie ستحذف الملفات من القرص تلقائياً عند حذف الموديل
            $testimonial->delete();

            return backWithSuccess();
        } catch (\Exception $e) {
            return backWithError($e->getMessage());
        }
    }
}
