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

        $expense = Expense::create([
            'user_id' => $id,
            'name' => $request->name,
            'cost' => $request->cost
        ]);

        if($expense) {
            return redirect()->back()->with('success', 'Successful.');
        }
//        else {
//            return redirect()->back()->with('warning', 'Error.');
//        }

    }
}
