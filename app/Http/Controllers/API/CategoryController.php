<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $query = Category::where('is_active', true);

        $categories = $query->get();

        return response()->json([
            'message' => 'List of categories.',
            'data' => [
                'categories' => $categories
            ]
        ]);
    }
}
