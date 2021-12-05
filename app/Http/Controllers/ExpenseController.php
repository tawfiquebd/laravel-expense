<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index() {
        $userId = Auth::id();
        $expenses = Expense::all()->where('user_id', $userId);

        return view('backend.expense', compact('expenses'));
    }
}
