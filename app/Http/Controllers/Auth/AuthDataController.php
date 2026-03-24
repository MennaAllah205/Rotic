<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthDataResource;
use Illuminate\Http\Request;

class AuthDataController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user()->load(['roles:id,name', 'permissions']);

        return new AuthDataResource($user);

    }
}
