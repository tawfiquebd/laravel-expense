<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Exception;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();

        return view('backend.categories', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
        ]);

        try {
            \App\Models\Category::create($request->except('_token'));

            return redirect()->route('category.index')->with('success', "Book created successfully!");
        } catch (Exception $exception) {
            return redirect()->route('category.index')->with('error', "Something went wrong ".$exception->getMessage());
        }
    }
}
