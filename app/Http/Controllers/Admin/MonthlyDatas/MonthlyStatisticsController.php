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

class MonthlyStatisticsController extends Controller
{
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            'month'     => 'nullable|string',
            'year'      => 'nullable|string'
        ]);

        if (!isset($request_data['month'])) $request_data['month'] = "0";
        if (!isset($request_data['year'])) $request_data['year'] = (date('Y'));
        
        $results = Array();
        if ($request_data['month'] == "0") // case of All Months
        {
            for ($index = 1; $index <= 12; $index ++)
            {
                $month = $index < 10 ? '0' . (String)$index : (String)$index;
                
                $result = $this->getMonthlyStatistics($request_data['year'], $month); 
                if ($result != NULL) $results[] = $result;
            }
            
        } else {
            $result = $this->getMonthlyStatistics($request_data['year'], $request_data['month']);
            if ($result != NULL) $results[] = $result;
        }

        $data = [
            'results'   => $results,
            'old'       => $request_data
        ];

        if (count($data['results']) == 0) $request->session()->flash('error', "No search result!");
        return view('admin.monthlydata.monthlystatistics.index')->with('data', $data);
    }

    public function getMonthlyStatistics(String $year, String $month)
    {
        $total_package_profit = $this->getMonthlyPackageProfit($year, $month);
        $total_student_profit = $this->getMonthlyInvoiceProfit($year, $month);
        $total_essays_profit = $this->getMonthlyEssayProfit($year, $month);
        $total_other_profit = $this->getMonthlyOtherIncome($year, $month);

        $total_paycheque_expenses = $this->getMonthlyPaychequeExpense($year, $month);
        $total_other_expenses = $this->getMonthlyExpense($year, $month);
        $active_students = $this->getActiveStudents($year, $month);
        $active_tutors = $this->getActiveTutors($year, $month);
        $result = [
            'tutoring_revenue'      => round(($total_package_profit + $total_student_profit), 2),
            'assignment_revenue'    => round($total_essays_profit, 2),
            'other_revenue'         => round($total_other_profit, 2),
            'total_revenue'         => round(($total_package_profit + $total_student_profit 
                                        + $total_essays_profit + $total_other_profit), 2),
            'payroll'               => round($total_paycheque_expenses, 2),
            'other_expense'         => round($total_other_expenses, 2),
            'total_expense'         => round(($total_paycheque_expenses + $total_other_expenses), 2),
            'total_profit'          => round($total_package_profit + $total_student_profit + $total_essays_profit
                        + $total_other_profit - $total_paycheque_expenses - $total_other_expenses, 2),
            'active_students'       => $active_students,
            'active_tutors'         => $active_tutors,
            'month_year'            => date("F", mktime(0, 0, 0, intval($month))) . ' ' . $year,
        ];
        
        $isNull = true;
        foreach($result as $component)
        {
            if ($component != 0)
            {
                $isNull = false;
                break;
            }
        }
        if ($isNull == true) return NULL;
        return $result;
    }

    public function getMonthlyPackageProfit(String $year, String $month)
    {
        $filter_date = "%" . $year . '-' . $month . "%";
        
        $order_total = Order::where(function ($order) use ($filter_date) {
            return $order->where('updated_at', 'like', $filter_date)
            -> where('status_id', '5')
            -> where('package_id', '!=', '0');
        })->get('total') -> pluck('total') -> toArray();

        if ($order_total == NULL) return 0;
        $result = array_sum($order_total);
        return $result;
    }

    public function getMonthlyInvoiceProfit(String $year, String $month)
    {
        $filter_date = "%" . $year . '-' . $month . "%";

        $invoice_totalamount = Invoice::where(function ($invoice) use ($filter_date) {
            return $invoice->where('invoice_date', 'like', $filter_date);
        })->get('total_amount')->pluck('total_amount') -> toArray();
        
        if ($invoice_totalamount == NULL) return 0;
        $result = array_sum($invoice_totalamount);
        return $result;
    }

    public function getMonthlyEssayProfit(String $year, String $month)
    {
        $filter_date = "%" . $year . '-' . $month . "%";
        $essay_owed = EssayAssignment::where(function ($essay_assignment) use ($filter_date) {
            return $essay_assignment -> where('date_completed', 'like', $filter_date);
        })->get('date_completed') -> pluck('date_completed') -> toArray();

        if ($essay_owed == NULL) return 0;
        $result = array_sum($essay_owed);
        return $result;
    }

    public function getMonthlyPaychequeExpense(String $year, String $month)
    {
        $filter_date = "%" . $year . '-' . $month . "%";

        $paycheque_totalamount = Paycheque::where(function ($paycheque) use ($filter_date) {
            return $paycheque -> where('paycheque_date', 'like', $filter_date)
            -> where('status', 'Paid');
        })->get('total_amount') -> pluck('total_amount') -> toArray();

        if ($paycheque_totalamount == NULL) return 0;
        $result = array_sum($paycheque_totalamount);
        return $result;
    }

    public function getMonthlyOtherIncome(String $year, String $month)
    {
        $filter_date = "%" . $year . '-' . $month . "%";

        $other_amounts = OtherIncome::where(function ($otherIncome) use ($filter_date) {
            return $otherIncome -> where('date', 'like', $filter_date);
        }) -> get('amount') -> pluck('amount') -> toArray();

        if ($other_amounts == NULL) return 0;

        $result = array_sum($other_amounts);
        return $result;
    }

    public function getMonthlyExpense(String $year, String $month)
    {
        $filter_date = "%" . $year . '-' . $month . "%";

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

    public function getActiveStudents(String $year, String $month)
    {
        $filter_date = "%" . $year . '-' . $month . "%";

        $sessions = Session::where(function ($session) use ($filter_date) {
            return $session -> has('assignments')
            -> where('session_date', 'like', $filter_date);
        })->get();

        if ($sessions == NULL) return 0;
        $result = count($sessions);
        return $result;
    }

    public function getActiveTutors(String $year, String $month)
    {
        $filter_date = "%" . $year . '-' . $month . "%";
        
        $sessions = Session::where(function ($session) use ($filter_date) {
            return $session -> has('assignments')
            -> where('session_date', 'like', $filter_date);
        })->get();

        if ($sessions == NULL) return 0;
        $result = count($sessions);
        return $result;
    }
}
