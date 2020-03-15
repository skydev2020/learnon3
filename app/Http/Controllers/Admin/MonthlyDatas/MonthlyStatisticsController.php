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

use Illuminate\Http\Request;

class MonthlyStatisticsController extends Controller
{
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            'month'     => 'nullable|int',
            'year'      => 'nullable|int'
        ]);

        if (!isset($request_data['month'])) $request_data['month'] = intval(date('m'));

        if (!isset($request_data['year'])) $request_data['year'] = intval(date('Y'));

        $total_package_profit = $this->getMonthlyPackageProfit($request_data['year'], $request_data['month']);
        $total_student_profit = $this->getMonthlyInvoiceProfit($request_data['year'], $request_data['month']);
        $total_essays_profit = $this->getMonthlyEssayProfit($request_data['year'], $request_data['month']);
        $total_other_profit = $this->getMonthlyOtherIncome($request_data['year'], $request_data['month']);

        $total_paycheque_expenses = $this->getMonthlyPaychequeExpense($request_data['year'], $request_data['month']);
        $total_other_expenses = $this->getMonthlyExpense($request_data['year'], $request_data['month']);
        $active_students = $this->getActiveStudents($request_data['year'], $request_data['month']);
        $active_tutors = $this->getActiveTutors($request_data['year'], $request_data['month']);

        $result = [
            'tutoring_revenue'      => round(($total_package_profit + $total_student_profit), 2),
            'assignment_revenue'    => round($total_essays_profit, 2),
            'other_revenue'         => round($total_other_profit, 2),
            'total_revenue'         => round(($total_package_profit + $total_student_profit 
                                     + $total_essays_profit + $total_other_profit), 2),
            'payroll'               => round($total_paycheque_expenses, 2),
            'other_expense'         => round($total_other_expenses, 2),
            'total_expense'         => round(($total_paycheque_expenses + $total_other_expenses), 2),
            'total_profit'          => round($total_package_profit + $total_student_profit - $total_essays_profit
                        + $total_other_profit - $total_paycheque_expenses - $total_other_expenses, 2),
            'active_students'       => $active_students,
            'active_tutors'         => $active_tutors,
        ];

        $data = [
            'result'    => $result
        ];

        return view('admin.monthlydata.monthlystatistics.index')->with('result', $result);
    }

    public function getMonthlyPackageProfit(Int $year, Int $month)
    {
        // $orders = Order::where('status_id', 5)->where('package_id', '!=', 0)
        // -> where(date('m', strtotime('updated_at')), $month) 
        // -> where(date('Y', strtotime('updated_at')), $year)->get('total') -> pluck('total') -> toArray();
        
        $order_total = Order::where(function ($order) {
            return $order->where(date('m', strtotime($order['updated_at'])), $month)
            -> where(date('Y', strtotime($order->updated_at)), $year);
        });

        

        if ($order_total == NULL) return 0;
        $result = array_sum($order_total);
        return $result;
    }

    public function getMonthlyInvoiceProfit(Integer $year, Integer $month)
    {
        $invoice_totalamount = Invoice::where(function ($invoice) {
            return $invoice->where(year('invoice_date'), $year) -> where(date("m", 'invoice_date'), $month);
        })->get('total_amount')->pluck('total_amount') -> toArray();
        
        if ($invoice_totalamount == NULL) return 0;
        $result = array_sum($invoice_totalamount);
        return $result;
    }

    public function getMonthlyEssayProfit(Integer $year, Integer $month)
    {
        $essay_owed = EssayAssignment::where(function ($essay_assignment) {
            return $essay_assignment -> where(year('date_completed'), $year)
            -> where(month('date_completed'), $month)
            -> where('status_id', 4);
        })->get('owed') -> pluck('owed') -> toArray();

        if ($essay_owed == NULL) return 0;
        $result = array_sum($essay_owed);
        return $result;
    }

    public function getMonthlyPaychequeExpense(Integer $year, Integer $month)
    {
        $paycheque_totalamount = Paycheque::where(function ($paycheque) {
            return $paycheque -> where(year('paycheque_date'), $year)
            -> where(month('paycheque_date'), $month)
            -> where('status', 'Paid');
        })->get('total_amount') -> pluck('total_amount') -> toArray();

        if ($paycheque_totalamount == NULL) return 0;
        $result = array_sum($paycheque_totalamount);
        return $result;
    }

    public function getMonthlyOtherIncome(Integer $year, Integer $month)
    {
        $other_amounts = OtherIncome::where(function ($otherIncome) use ($year, $month) {
            return $otherIncome -> where(year('date'), $year)
            -> where(month('date'), $month);
        }) -> get('amount') -> pluck('amount') -> toArray();

        if ($other_amounts == NULL) return 0;

        $result = array_sum($other_amounts);
        return $result;
    }

    public function getMonthlyExpense(Integer $year, Integer $month)
    {
        $profitIds = Profit::where(function ($essay_assignment) {
            return $essay_assignment -> where(year('date'), $year)
            -> where(month('date'), $month)
            -> where('name', '%Tutor Payments%');
        })->get('id') -> pluck('id') -> toArray();

        $profit_amounts = Profit::where(function ($profit) use ($profitIds) {
            return $profit->whereNotIn('id', $profitIds);
        })->get('amount')->pluck('amount')->toArray();

        if ($profit_amounts == NULL) return 0;
        $result = array_sum($profit_amounts);
        return $result;
    }

    public function getActiveStudents(Integer $year, Integer $month)
    {
        $sessions = Session::where(function ($session) {
            return $session -> has('assignments')
            -> where(year('session_date'), $year)
            -> where(month('session_date'), $month);
        })->get();

        if ($sessions == NULL) return 0;
        $result = count($sessions);
        return $result;
    }

    public function getActiveTutors(Integer $year, Integer $month)
    {
        $sessions = Session::where(function ($session) {
            return $session -> has('assignments')
            -> where(year('session_date'), $year)
            -> where(month('session_date'), $month)
            -> where('status_id', 4);
        })->get();

        if ($sessions == NULL) return 0;
        $result = count($sessions);
        return $result;
    }
}
