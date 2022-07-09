<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function books()
    {
        $books = Category::query()
            ->with('expenses')
            ->withCount('expenses')
            ->latest()
            ->get();

        return view('backend.books', compact('books'));
    }

    public function index(Request $request)
    {
        $book = $request->get('category');
        $query = Expense::query();
        $expenses = $query->with([
            'category',
            'user',
        ])
            ->where('category_id', $book)
            ->latest()->get();

        $balanceSummary = $this->balanceSummary($book);

        return view('backend.expense', [
            'expense' => null,
            'expenses' => $expenses,
            'book' => $book,
            'balanceSummary' => $balanceSummary,
        ]);
    }

    private function balanceSummary($categoryId)
    {
        $query = Expense::query()->get();
        $deposit = $query->where('expense_type', 'deposit')
            ->where('category_id', $categoryId)
            ->sum('cost');

        $withdraw = $query->where('expense_type', 'withdraw')
            ->where('category_id', $categoryId)
            ->sum('cost');

        $available_balance = $deposit - $withdraw;

        $balanceRatio = $deposit * 30 / 100;
        $lowerBalance = null;
        if (($deposit > $available_balance) && ($available_balance < $balanceRatio)) {
            $lowerBalance = "Your remaining balance is low";
        }

        $balance = [
            'deposit' => $deposit,
            'withdraw' => $withdraw,
            'available_balance' => $available_balance,
            'lowerBalance' => $lowerBalance,
        ];

        return $balance;
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'cost' => 'required|numeric|regex:/^([\d]{0,10})(\.[\d]{1,2})?$/',    // regex for decimal 2 places
            'expense_type' => 'required',
            'created_at' => 'required',
        ]);

        $expense_type = $request->input('expense_type');
        $cost = $request->input('cost');
        $time = date('H:i:s', time());
        $date = $request->input('created_at') . " " . $time;

        $messages = [
            $expense_type => null,
        ];

        Expense::query()->create([
            'name' => $request->input('name'),
            'cost' => $cost,
            'expense_type' => $expense_type,
            'category_id' => $request->input('category'),
            'user_id' => Auth::id(),
            'created_at' => $date,
        ]);

        $messages = [
            'deposit' => "$cost Tk Deposit successful",
            'withdraw' => "$cost Tk Withdraw successful",
        ];

        return redirect()->back()->with('success', $messages[$expense_type]);

    }

    public function edit(Request $request)
    {
        $book = $request->get('category');
        $query = Expense::query();
        $expenses = $query->with([
            'category',
            'user',
        ])
            ->where('category_id', $book)
            ->latest()->get();

        $expense = $expenses->where('id', $request->get('id'))->first();

        $balanceSummary = $this->balanceSummary($book);

        return view('backend.expense', [
            'expense' => $expense,
            'expenses' => $expenses,
            'book' => $book,
            'balanceSummary' => $balanceSummary,
        ]);
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
