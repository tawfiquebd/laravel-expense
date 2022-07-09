<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function books()
    {
        $books = Category::query()->latest()->get();

        return view('backend.books', compact('books'));
    }

    public function index(Request $request)
    {
        $book = $request->get('category');

        return view('backend.expense', compact('book'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'cost' => 'required|numeric|regex:/^([\d]{0,5})(\.[\d]{1,2})?$/',    // regex for decimal 2 places
        ]);

        $expense_type = $request->input('expense_type');
        $cost = $request->input('cost');

        $messages = [
            $expense_type => null,
        ];

        Expense::query()->create([
            'name' => $request->input('name'),
            'cost' => $cost,
            'expense_type' => $expense_type,
            'category_id' => $request->input('category'),
            'user_id' => Auth::id(),
        ]);

        $messages = [
            'deposit' => "$cost Tk Deposit successful",
            'withdraw' => "$cost Tk Withdraw successful",
        ];

        return redirect()->back()->with('success', $messages[$expense_type]);

    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'update_name' => 'required|min:3|max:255',
            'update_cost' => 'required|numeric|regex:/^([\d]{0,5})(\.[\d]{1,2})?$/'
        ]);

        $expense = Expense::find($id);

        if ($expense) {
            $expense->name = $request->update_name;
            $expense->cost = $request->update_cost;
            $expense->save();

            return redirect()->back()->with('update-success', 'Expense updated successfully!');
        } else {
            return redirect()->back()->with('notfound', 'Expense not found to update');
        }

    }

    public function delete($id)
    {
        $expense = Expense::find($id);

        if ($expense) {
            $expense->delete();
            return redirect()->back()->with('delete-success', 'Expense deleted successfully!');
        } else {
            return redirect()->back()->with('delete-failed', 'Expense not found to delete!');
        }
    }

}
