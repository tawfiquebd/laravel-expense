<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard() {
        $adminsCount = Role::query()->where('id', 1)->first()->users()->count();
        $usersCount = Role::query()->where('id', 2)->first()->users()->count();

        $totalDeposits = $this->totalDeposits();

        $totalExpenses = $this->totalExpenses();

        return view("backend.admin.adminDashboard", compact(
            'adminsCount', 'usersCount', 'totalDeposits', 'totalExpenses'));
    }

    private function totalDeposits()
    {
        $deposits = Expense::query()
            ->where('expense_type', 'deposit')
            ->sum('cost');

        return $deposits;
    }

    private function totalExpenses()
    {
        $expenses = Expense::query()
            ->where('expense_type', 'withdraw')
            ->sum('cost');

        return $expenses;
    }

    public function users() {
        $basicUsers = Role::all()
            ->where('id', 2)
            ->first()
            ->users()
            ->get();

        return view('backend.admin.users', compact('basicUsers'));
    }

    public function userStatus($userId) {

        $getStatus = User::query()->where('id', $userId)->first();

        if($getStatus->status == 1) {
            $getStatus->status = 0;
            $getStatus->save();

            return redirect()->back();
        }
        else {
            $getStatus->status = 1;
            $getStatus->save();

            return redirect()->back();
        }
//        dd($updateStatus->status);
    }
}
