<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthDataResources;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthDataController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __construct()
    {
        $this->middleware('permission:auth_data_show')->only(['__invoke']);
    }
    public function __invoke(Request $request)
    {
        $user = User::with('roles:id,name', 'permissions')->findOrFail(Auth::id());

        return new AuthDataResources($user);

    }
}
