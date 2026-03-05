<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserProfileResources;
use Illuminate\Http\Request;

class UserProfile extends Controller
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

        return new UserProfileResources($user);

    }
}


