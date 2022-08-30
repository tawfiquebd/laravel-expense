<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{

    public function reportDaily() {

        $categories = Category::query()
            ->with('expenses')
            ->withCount('expenses')
            ->latest()
            ->get();

        return view('backend.report.expenseCategoryWiseReport', compact('categories'));
    }

    public function printDailyReport(Request $request) {
        $userDetails = Auth::user();
        $date = $request->get('date');
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
                    ->where('category_id', $category)
                    ->dd();

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
            ->where('expense_type', 'withdraw')
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
            ->where('expense_type', 'withdraw')
            ->groupby(['month', 'year'])
            ->latest()
            ->get();
        return view('backend.report.reportMonthly', compact('expenseByMonth'));
    }


    // Report PDF Download
    public function dailyReportDownloadPdf(Request $request)
    {

        $date = $request->date;
        $category = $request->category;

        $userDetails = Auth::user();
        $isValidDate = $this->isDate($date);

        if($isValidDate) {
            \DB::statement("SET SQL_MODE=''");

            // Get total cost
            $totalCost = Expense::select(array(
                DB::raw('date(created_at) as date'),
                DB::raw('sum(cost) as total')
            ))
                ->where('user_id', Auth::id())
                ->where('category_id', $category)
                ->where('created_at', 'like', "$date%")
                ->where('expense_type', 'withdraw')
//                ->where('category_id', 31)
//                    ->pluck('total', 'date')
                ->get(['total', 'date']);

            // Get single expense data
            $expenses = DB::table('expenses')
                ->where('user_id', Auth::id())
                ->where('category_id', $category)
                ->where('created_at', 'like', "$date%")
                ->get();
        }
        $totalDepositAmount = Expense::query()
            ->where('user_id', Auth::id())
            ->where('category_id', $category)
            ->where('expense_type', "deposit")
            ->where('created_at', 'like', "$date%")
            ->sum('cost');

        $totalCashOutAmount = Expense::query()
            ->where('user_id', Auth::id())
            ->where('category_id', $category)
            ->where('created_at', 'like', "$date%")
            ->where('expense_type', "withdraw")
            ->sum('cost');

        $finalAvailableBalance = $totalDepositAmount - $totalCashOutAmount;

        $finalWholeAvailableBalance = 0;

        if ($totalDepositAmount <= 0) {

            $totalWholeDepositAmount = Expense::query()
                ->where('user_id', Auth::id())
                ->where('category_id', $category)
                ->where('expense_type', "deposit")
                ->sum('cost');


            $totalWholeCashOutAmount = Expense::query()
                ->where('user_id', Auth::id())
                ->where('category_id', $category)
                ->where('expense_type', "withdraw")
                ->sum('cost');

            $finalWholeAvailableBalance = $totalWholeDepositAmount - $totalWholeCashOutAmount;
        }




        $datas = [
            "date" => $date,
            "expenses" => $expenses,
            "userDetails" => $userDetails,
            "totalCost" => $totalCost,
            "totalDepositAmount" => $totalDepositAmount,
            "totalCashOutAmount" => $totalCashOutAmount,
            "finalAvailableBalance" => $finalAvailableBalance,
            "finalWholeAvailableBalance" => $finalWholeAvailableBalance,
        ];


//        return view('backend.report.pdf.reportDaily', ['datas' => $datas]);


//        dd($datas['date']);

        $pdf = Pdf::loadView('backend.report.pdf.reportDaily', $datas);

        return $pdf->stream('invoice.pdf');

    }


    public function reportDailyCategoryWise(Request $request)
    {
        $category = $request->query('category');

        $categoryName = Category::query()->where('id', $category)->pluck('name');

        $date = new \DateTime('tomorrow -1 year'); // from last 1 month till today

        \DB::statement("SET SQL_MODE=''");

        $days = Expense::query()->select(array(
            DB::raw('date(created_at) as date'),
            DB::raw('sum(cost) as total')
        ))
        ->where('expense_type', 'withdraw')
        ->where('category_id', $category)
        ->where('user_id', Auth::id())
        ->groupBy('date')
        ->pluck('total', 'date');


        return view('backend.report.reportDaily', compact('days', 'category', 'categoryName'));
    }

}
