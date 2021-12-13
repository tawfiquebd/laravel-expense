<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function reportDaily() {

        $date = new \DateTime('tomorrow -1 month'); // from last 1 month till today

        \DB::statement("SET SQL_MODE=''");

        $days = Expense::select(array(
            DB::raw('date(created_at) as date'),
            DB::raw('sum(cost) as total')
        ))
            ->where('user_id', Auth::id())
            ->where('created_at', '>', $date)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->pluck('total', 'date');
//            ->get(['id', 'total', 'date', 'name']);
//        print_r($days);

        return view('backend.report.reportDaily', compact('days'));
    }

    public function printDailyReport(Request $request, $date) {

        if($date) {
            $expenses = DB::table('expenses')
                ->where('user_id', Auth::id())
                ->where('created_at', 'like', "$date%")
                ->get();

            dd($expenses);
        }
    }


}
