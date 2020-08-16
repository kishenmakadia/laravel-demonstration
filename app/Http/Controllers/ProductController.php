<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index', [
            'products' => Product::with('categories')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.form', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'categories' => 'required|array',
        ]);

        $product = Product::create([
            'name' => request()->name,
        ]);

        $product->categories()->sync(request()->categories);

        return redirect('products')->with('status', 'Product created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.form', [
            'categories' => Category::all(),
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product)
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'categories' => 'required|array',
        ]);

        $product->update(request()->only('name'));

        $product->categories()->sync(request()->categories);

        return redirect('products')->with('status', 'Product updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('products')->with('status', 'Product deleted.');
    }
}
