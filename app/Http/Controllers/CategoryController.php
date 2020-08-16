<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index', [
            'categories' => Category::withCount('products')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.form');
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
        ]);

        Category::create([
            'name' => request()->name,
        ]);

        return redirect('categories')->with('status', 'Category created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.form', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category)
    {
        $category->update(request()->only('name'));
        return redirect('categories')->with('status', 'Category updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('categories')->with('status', 'Category deleted.');
    }
}
