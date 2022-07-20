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

        $lowerBalance = $this->calculateLowBalance($deposit, $available_balance);

        $balance = [
            'deposit' => $deposit,
            'withdraw' => $withdraw,
            'available_balance' => $available_balance,
            'lowerBalance' => $lowerBalance,
        ];

        return $balance;
    }

    private function calculateLowBalance($deposit, $available_balance)
    {
        $balanceRatio = $deposit * 30 / 100;
        $lowerBalance = "";

        // NB: IF (0 > -2000) -> true && (-2000 < 0 ) -> true
        if (($deposit > $available_balance) && ($available_balance < $balanceRatio)) {
            $lowerBalance = "Your remaining balance is low";
        }

        return $lowerBalance;
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
            'name' => 'required|min:3|max:255',
            'cost' => 'required|numeric|regex:/^([\d]{0,10})(\.[\d]{1,2})?$/',
            'expense_type' => 'required',
            'created_at' => 'required',
        ]);

        $expense = Expense::query()->find($id);
        $categoryId = $request->category;

        if ($expense) {
            $expense->name = $request->name;
            $expense->cost = $request->cost;
            $expense->created_at = $request->created_at;
            $expense->category_id = $categoryId;
            $expense->expense_type = $request->expense_type;
            $expense->save();

            return redirect("/expense/index?category=$categoryId")->with('success', 'Expense updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Expense not found to update');
        }

    }

    public function destroy(Request $request)
    {
        $expense = Expense::query()->where('id', $request->get('id'))->where('category_id', $request->get('category'))->first();

        if ($expense) {
            $expense->delete();
            return redirect()->back()->with('success', 'Expense deleted successfully!');
        } else {
            return redirect()->back()->with('warning', 'Expense not found to delete!');
        }
    }

}
