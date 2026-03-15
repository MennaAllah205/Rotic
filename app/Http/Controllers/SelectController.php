<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;

class SelectController extends Controller
{
    public function clients()
    {
        $clients = Client::select('id', 'name')->get();

        return response()->json([
            'data' => $clients,
        ]);
    }

    public function categories()
    {
        $category = Category::select('id', 'name')->get();

        return response()->json([
            'data' => $category,
        ]);
    }
}
