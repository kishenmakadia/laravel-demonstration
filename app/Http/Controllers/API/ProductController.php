<?php

namespace App\Http\Controllers\API;

use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with('categories:id,name')->where('is_active', true);

        if (request()->search) {
            $query->where('name', 'like', '%' . request()->search . '%');
        }

        if (request()->category_id) {

            $query->whereHas('categories', function (Builder $query) {
                $query->where('category_id', request()->category_id);
            });
        }

        $products = $query->get();

        return response()->json([
            'message' => 'List of products.',
            'data' => [
                'products' => $products
            ]
        ]);
    }
}
