<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsUpdateRequest;
use App\Http\Requests\SendContactRequest;
use App\Http\Resources\ContactUsResources;
use App\Models\ContactUs;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:contact_us_show')->only(['index', 'show']);
        $this->middleware('permission:contact_us_create')->only(['store']);
        $this->middleware('permission:contact_us_update')->only(['update']);
        $this->middleware('permission:contact_us_delete')->only(['destroy']);
    }

    public function index(Request $request)
    {

        $contactUs = ContactUs::paginate(getPerPage($request));

        return ContactUsResources::collection($contactUs);

    }

    public function store(SendContactRequest $request)
    {
        try {

            $data = $request->validated();

            DB::transaction(function () use ($data, &$contactUs) {

                $contactUs = ContactUs::create($data);
            });

            return backWithSuccess(
                data: new ContactUsResources($contactUs)
            );

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function update(ContactUsUpdateRequest $request, $id)
    {

        $contactUs = ContactUs::findOrFail($id);
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, $contactUs) {

                $contactUs->update($data);

            });

            return backWithSuccess(
                data: new ContactUsResources($contactUs)
            );
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function destroy($ids)
    {
        try {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $deleted = ContactUs::whereIn('id', $ids)->delete();

            if (! $deleted) {
                return backWithWarning('لا يوجد سجلات للحذف', 'No records to delete');
            }

            return backWithSuccess();

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
