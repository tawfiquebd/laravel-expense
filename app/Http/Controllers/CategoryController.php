<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
            Category::query()->create([
                'name' => $request->input('name'),
                'user_id' => Auth::id(),
            ]);


            return redirect()->back()->with('success', "Book Created Successfully!");;
//            return redirect()->route('category.index')->with('success', "Book created successfully!");
        } catch (Exception $exception) {
            return redirect()->back()->with('error', "Something went wrong ".$exception->getMessage());
        }
    }
}
