<?php

namespace App\Http\Controllers;

use App\Http\Resources\SelectedCategoriesResources;
use App\Models\Category;

class SelectCategoryController extends Controller
{
    public function categories()
    {
        $category = Category::select('id', 'name')->get();

        return SelectedCategoriesResources::collection($category);
    }
}
