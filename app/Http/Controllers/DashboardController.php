<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $dateToday = date('Y-m-d');
        $currentMonth = date('m');

        // today expense
        $expenseByToday = DB::table('expenses')
            ->select(
                DB::raw('date(created_at) as date'),
                DB::raw('sum(cost) as total')
            )
            ->where('user_id', Auth::id())
            ->where('created_at', 'like', "$dateToday%")
            ->groupBy('date')
            ->pluck('total');     // get only total sum as an array
//            ->get();    // get date and total sum

        // weekly expense
        $previousDateTime = new \DateTime('tomorrow -1 week');  // 1 week ago to today's date
        $previousDate = $previousDateTime->format('Y-m-d');

        $expenseByWeek = DB::table('expenses')->select(
            DB::raw('sum(cost) as total')
        )
            ->where('user_id', Auth::id())
            ->where('created_at', '>', $previousDate)
            ->get();

        // monthly expense
        $expenseByMonth = DB::table('expenses')
            ->select(array(
                DB::raw('sum(cost) as total'),
            ))
            ->where('user_id', '=', Auth::id())
            ->where('created_at', 'like', "%$currentMonth%" )
            ->get();

        return view('backend.dashboard', compact('expenseByToday', 'expenseByWeek', 'expenseByMonth'));
    }
}
