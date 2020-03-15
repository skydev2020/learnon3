<?php

namespace App\Http\Controllers\Admin\MonthlyDatas;

use App\Http\Controllers\Controller;
use App\Order;
use App\Invoice;
use App\Paycheque;
use App\Assignment;
use App\Expense;
use App\Profit;
use App\Package;
use App\EssayAssignment;
use App\OtherIncome;
use App\Session;
use Illuminate\Http\Request;

class YearlyStatisticsController extends Controller
{
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            'year'      => 'nullable|string'
        ]);

        if (!isset($request_data['year'])) $request_data['year'] = "0";
        
        $results = Array();
        if ($request_data['year'] == "0") // case of All Months
        {
            for ($index = intval(date('Y')); $index >= 1991; $index --)
            {
                $year = (String)$index;
                $result = $this->getYearlyStatistics($year); 
                if ($result != NULL) $results[] = $result;
            }
            
        } else {
            $result = $this->getYearlyStatistics($request_data['year']);
            if ($result != NULL) $results[] = $result;
        }

        $data = [
            'results'   => $results,
            'old'       => $request_data
        ];

        if (count($data['results']) == 0) $request->session()->flash('error', "No search result!");
        return view('admin.monthlydata.yearlystatistics.index')->with('data', $data);
    }

    public function getYearlyStatistics(String $year)
    {
        $total_package_profit = $this->getYearlyPackageProfit($year);
        $total_student_profit = $this->getYearlyInvoiceProfit($year);
        $total_essays_profit = $this->getYearlyEssayProfit($year);
        $total_other_profit = $this->getYearlyOtherIncome($year);

        $total_paycheque_expenses = $this->getYearlyPaychequeExpense($year);
        $total_other_expenses = $this->getYearlyExpense($year);
        $active_students = $this->getActiveStudents($year);
        $active_tutors = $this->getActiveTutors($year);
        $hours_tutors = $this->getYearlyHoursTutors($year);
        $result = [
            'total_revenue'         => round(($total_package_profit + $total_student_profit 
                                        + $total_essays_profit + $total_other_profit), 2),
            'hours_tutors'               => $hours_tutors,
            'total_expense'         => round(($total_paycheque_expenses + $total_other_expenses), 2),
            'total_profit'          => round($total_package_profit + $total_student_profit + $total_essays_profit
                        + $total_other_profit - $total_paycheque_expenses - $total_other_expenses, 2),
            'active_students'       => $active_students,
            'active_tutors'         => $active_tutors,
            'year'                  => $year
        ];
        
        $isNull = true;
        foreach($result as $key => $value)
        {
            if ($value != 0 && $key != 'year')
            {
                $isNull = false;
                break;
            }
        }
        if ($isNull == true) return NULL;
        return $result;
    }

    public function getYearlyPackageProfit(String $year)
    {
        $filter_date = "%" . $year . "%";
        
        $order_total = Order::where(function ($order) use ($filter_date) {
            return $order->where('updated_at', 'like', $filter_date)
            -> where('status_id', '5')
            -> where('package_id', '!=', '0');
        })->get('total') -> pluck('total') -> toArray();

        if ($order_total == NULL) return 0;
        $result = array_sum($order_total);
        return $result;
    }

    public function getYearlyInvoiceProfit(String $year)
    {
        $filter_date = "%" . $year . "%";

        $invoice_totalamount = Invoice::where(function ($invoice) use ($filter_date) {
            return $invoice->where('invoice_date', 'like', $filter_date);
        })->get('total_amount')->pluck('total_amount') -> toArray();
        
        if ($invoice_totalamount == NULL) return 0;
        $result = array_sum($invoice_totalamount);
        return $result;
    }

    public function getYearlyEssayProfit(String $year)
    {
        $filter_date = "%" . $year . "%";
        $essay_owed = EssayAssignment::where(function ($essay_assignment) use ($filter_date) {
            return $essay_assignment -> where('date_completed', 'like', $filter_date);
        })->get('date_completed') -> pluck('date_completed') -> toArray();

        if ($essay_owed == NULL) return 0;
        $result = array_sum($essay_owed);
        return $result;
    }

    public function getYearlyPaychequeExpense(String $year)
    {
        $filter_date = "%" . $year . "%";

        $paycheque_totalamount = Paycheque::where(function ($paycheque) use ($filter_date) {
            return $paycheque -> where('paycheque_date', 'like', $filter_date)
            -> where('status', 'Paid');
        })->get('total_amount') -> pluck('total_amount') -> toArray();

        if ($paycheque_totalamount == NULL) return 0;
        $result = array_sum($paycheque_totalamount);
        return $result;
    }

    public function getYearlyOtherIncome(String $year)
    {
        $filter_date = "%" . $year . "%";

        $other_amounts = OtherIncome::where(function ($otherIncome) use ($filter_date) {
            return $otherIncome -> where('date', 'like', $filter_date);
        }) -> get('amount') -> pluck('amount') -> toArray();

        if ($other_amounts == NULL) return 0;

        $result = array_sum($other_amounts);
        return $result;
    }

    public function getYearlyExpense(String $year)
    {
        $filter_date = "%" . $year . "%";

        $profitIds = Profit::where(function ($essay_assignment) {
            return $essay_assignment -> where('name', '%Tutor Payments%');
        })->get('id') -> pluck('id') -> toArray();

        $profit_amounts = Profit::where(function ($profit) use ($profitIds, $filter_date) {
            return $profit->whereNotIn('id', $profitIds)
            -> where('date', 'like', $filter_date);
        })->get('amount')->pluck('amount')->toArray();

        if ($profit_amounts == NULL) return 0;
        $result = array_sum($profit_amounts);
        return $result;
    }

    public function getActiveStudents(String $year)
    {
        $filter_date = "%" . $year . "%";

        $sessions = Session::where(function ($session) use ($filter_date) {
            return $session -> has('assignments')
            -> where('session_date', 'like', $filter_date);
        })->get();

        if ($sessions == NULL) return 0;
        $result = count($sessions);
        return $result;
    }

    public function getActiveTutors(String $year)
    {
        $filter_date = "%" . $year . "%";
        
        $sessions = Session::where(function ($session) use ($filter_date) {
            return $session -> has('assignments')
            -> where('session_date', 'like', $filter_date);
        })->get();

        if ($sessions == NULL) return 0;
        $result = count($sessions);
        return $result;
    }

    public function getYearlyHoursTutors(String $year)
    {
        $filter_date = "%" . $year . "%";

        $session_duration = Session::where(function ($session) use ($filter_date) {
            return $session -> has('assignments')
            -> where('session_date', 'like', $filter_date);
        })->get('session_duration') -> pluck('session_duration') -> toArray();

        if ($session_duration == NULL) return 0;
        $result = array_sum($session_duration);
        return $result;
    }
}
