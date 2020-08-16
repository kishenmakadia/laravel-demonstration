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
            'products' => Product::with('categories')->orderBy('is_active', 'desc')->get()
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
            'categories' => Category::where('is_active', true)->get()
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
            'description' => 'required',
        ]);

        $product = Product::create([
            'name' => request()->name,
            'description' => request()->description,
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
            'categories' => Category::where('is_active', true)->get(),
            'product' => $product
        ]);
    }

    /**
     * Change status of record.
     *
     * @param  Product  $category
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Product $product)
    {
        $product->update([
            'is_active' => !$product->is_active,
        ]);

        return redirect('products')->with('status', 'Product status changed.');
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
            'description' => 'required',
        ]);

        $product->update(request()->only('name', 'description'));

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
