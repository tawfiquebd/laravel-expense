<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;

class ReportController extends Controller
{
    public function reportDaily() {

        $date = new \DateTime('tomorrow -1 year'); // from last 1 month till today

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

        return view('backend.report.reportDaily', compact('days'));
    }

    public function printDailyReport($date) {
        $userDetails = Auth::user();
        $isValidDate = $this->isDate($date);

        try {
            if($isValidDate) {
                \DB::statement("SET SQL_MODE=''");

                // Get total cost
                $totalCost = Expense::select(array(
                    DB::raw('date(created_at) as date'),
                    DB::raw('sum(cost) as total')
                ))
                    ->where('user_id', Auth::id())
                    ->where('created_at', 'like', "$date%")
//                    ->pluck('total', 'date')
                    ->get(['total', 'date']);

                // Get single expense data
                $expenses = DB::table('expenses')
                    ->where('user_id', Auth::id())
                    ->where('created_at', 'like', "$date%")
                    ->get();

                return view('backend.report.printDailyReport', compact('expenses', 'date', 'userDetails', 'totalCost'));
            }
            else {
                throw new Exception();
            }
        }
        catch (Exception $e) {
            return abort('403');
        }

    }

    // check the given date is valid or not
    public function isDate($date, $format = 'Y-m-d') {
        $d = \DateTime::createFromFormat($format, $date);

        if($d && $d->format($format) == $date){
            return true;
        }
    }

    public function reportWeekly() {

        $todayDate = date('Y-m-d');
        $previousDateTime = new \DateTime('tomorrow -1 week');  // 1 week ago to today's date
        $previousDate = $previousDateTime->format('Y-m-d');

        $expense = DB::table('expenses')->select(
            DB::raw('sum(cost) as total')
        )
            ->where('user_id', Auth::id())
            ->where('created_at', '>', $previousDate)
            ->get(['total']);

        return view('backend.report.reportWeekly', compact('todayDate', 'previousDate', 'expense'));
    }

    public function reportMonthly() {

        $expenseByMonth = DB::table('expenses')
            ->select(array(
                DB::raw('sum(cost) as total'),
                DB::raw('monthname(created_at) as month'),
                DB::raw('year(created_at) as year')
            ))
            ->where('user_id', '=', Auth::id())
            ->groupby(['month', 'year'])
            ->latest()
            ->get();
        return view('backend.report.reportMonthly', compact('expenseByMonth'));
    }

}
