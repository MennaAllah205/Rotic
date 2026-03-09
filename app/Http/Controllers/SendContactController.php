<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendContactRequest;
use App\Models\ContactUs;

class SendContactController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SendContactRequest $request)
    {

        $data = $request->validated();
        try {
            ContactUs::create($data);

            return backWithSuccess();
        } catch (\Exception $e) {
            return backWithError($e);

        }
    }
}
