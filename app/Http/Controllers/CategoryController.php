<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()->latest()->paginate(10);

        return view('backend.categories', [
            'categories' => $categories,
            'category' => null,
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

            return redirect()->back()->with('success', "Book Created Successfully!");
        } catch (Exception $exception) {
            return redirect()->back()->with('error', "Something went wrong " . $exception->getMessage());
        }
    }

    public function edit($id)
    {
        $query = Category::query();
        $categories = $query->latest()->paginate(10);
        $category = $query->find($id);

        return view('backend.categories', [
            'categories' => $categories,
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        Category::query()->find($id)->update([
            'name' => $request->input('name'),
        ]);

        return redirect('/category')->with('success', 'Book Updated Successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        $category = Category::query()
            ->with('expenses', function ($query) {
                $query->delete();
            })
            ->find($id);

        $category->delete();

        return redirect()->back()->with('delete', 'Book Deleted Successfully');
    }
}
