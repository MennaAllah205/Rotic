<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthDataResources;
use Illuminate\Http\Request;

class AuthDataController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __construct()
    {
        $this->middleware('permission:user_profile_show')->only(['__invoke']);
    }
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return new AuthDataResources($user);

    }
}


