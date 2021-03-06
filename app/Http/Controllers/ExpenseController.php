<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index() {
        $userId = Auth::id();
        $expenses = Expense::all()->where('user_id', $userId)->sortDesc();

        return view('backend.expense', compact('expenses'));
    }

    public function add(Request $request) {
        $id = Auth::id();

        $validation = $request->validate([
           'name' => 'required|min:3|max:255',
           'cost' => 'required|numeric|regex:/^([\d]{0,5})(\.[\d]{1,2})?$/',    // regex for decimal 2 places
        ]);

        Expense::create([
            'user_id' => $id,
            'name' => $request->name,
            'cost' => $request->cost
        ]);

        return redirect()->back()->with('success', 'Successful.');

    }

    public function update(Request $request, $id) {

        $request->validate([
            'update_name' => 'required|min:3|max:255',
            'update_cost' => 'required|numeric|regex:/^([\d]{0,5})(\.[\d]{1,2})?$/'
        ]);

        $expense = Expense::find($id);

        if($expense) {
            $expense->name = $request->update_name;
            $expense->cost = $request->update_cost;
            $expense->save();

            return redirect()->back()->with('update-success', 'Expense updated successfully!');
        }
        else {
            return redirect()->back()->with('notfound', 'Expense not found to update');
        }

    }

    public function delete($id) {
        $expense = Expense::find($id);

        if($expense) {
            $expense->delete();
            return redirect()->back()->with('delete-success', 'Expense deleted successfully!');
        }
        else {
            return redirect()->back()->with('delete-failed', 'Expense not found to delete!');
        }
    }

}
