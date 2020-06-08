<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:managers');
    }

    /**
     * Fetch the months transactions where made for current user
     * @param Illuminate\Database\Eloquent\Model $model
     * @param string $model
     * @param string $year
     * @return array $month_array
     */
    public function getAllMonths($model, $year = null)
    {
        $model = "\\App\\$model";
        $year = $year ?? date('Y');
        $month_array = array();
        $sales_dates = $model::orderBy('date', 'ASC')->whereYear("date", $year)
            ->where('farm_id', auth()->user()->farm_id)->pluck("date");
        $sales_dates = json_decode($sales_dates);

        if (!empty($sales_dates)) {
            foreach ($sales_dates as $unformatted_date) {
                $date = new \DateTime($unformatted_date);
                $month_no = $date->format('m');
                $month_name = $date->format('F');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }

    /**
     * Get monthly Expense
     * @param Illuminate\Database\Eloquent\Model $model
     * @param string $month
     * @param string $year
     * @param string $category
     * @return Illuminate\Database\Eloquent\Collection $monthly_expense
     */

    public function getMonthlyExpense($model, $month, $year = null, $category = 'chicken')
    {
        $year = $year ?? date("Y");
        $monthly_expense_collection = null;

        switch ($model) {
            case 'Birds':
                $model = "\\App\\$model";
                $monthly_expense_collection = $model::selectRaw('number * unit_price as expense')->where("farm_id", auth()->user()->farm_id)
                    ->where("bird_category", $category)->whereMonth("date", $month)->whereYear("date", $year)->pluck('expense');
                break;
            case 'Feed':
                $model = "\\App\\$model";
                $monthly_expense_collection = $model::selectRaw("price as expense")->where('farm_id', auth()->user()->farm_id)
                    ->where("feed_type", $category)->whereMonth("date", $month)->whereYear("date", $year)->pluck('expense');
                break;
            case 'Medicine':
                $model = "\\App\\$model";
                $monthly_expense_collection = $model::selectRaw("price * quantity as expense")->where('farm_id', auth()->user()->farm_id)
                    ->where("animal", $category)->whereMonth("date", $month)->whereYear("date", $year)->pluck('expense');
                break;
            case 'Transaction':
                $model = "\\App\\$model";
                $monthly_expense_collection = $model::selectRaw("amount as expense,description")->where('farm_id', auth()->user()->farm_id)
                    ->where("farm_category", $category)->where('type', 'expense')->whereMonth("date", $month)->whereYear("date", $year)->get();
                    return $monthly_expense_collection;
        }
        $monthly_expense = [];
        if (!empty($monthly_expense_collection)) {
            foreach ($monthly_expense_collection as $expense) {
                    array_push($monthly_expense,(float) $expense);
            }
        }

        return $monthly_expense == [] ? [0] :$monthly_expense;
    }

    /**
     * Get monthly sales data for chart js
     * @param Illuminate\Database\Eloquent\Model $model
     * @param string $year
     * @param string $category
     * @return array $monthly_sales_data_array
     */
    public function getMonthlyExpenseData($model, $year = null, $category = null)
    {

        $year = $year ?? date("Y");
        $monthly_expense_array = array();
        $month_array = $this->getAllMonths($model, $year);
        $month_name_array = array();
        if (!empty($month_array)) {
            foreach ($month_array as $month_no => $month_name) {
                $monthly_expense = $this->getMonthlyExpense($model, $month_no, $year, $category);
                array_push($monthly_expense_array, $monthly_expense);
                array_push($month_name_array, $month_name);
            }
        }
        return [
            'months' => $month_name_array,
            'expense' => !empty($monthly_expense_array) ? $monthly_expense_array : [0],
        ];
    }

    public function test()
    {
        $models = ['Birds', 'Feed', 'Medicine', 'Transaction'];
        $expenses = ['Birds' => [], 'Feed' => [], 'Medicine' => [], 'Transaction' => []];
        foreach ($models as $model) {
            $expense = $this->getMonthlyExpenseData($model, 2020, 'chicken');
            array_push($expenses[$model], $expense);
        }
        return response()->json($expenses);

    }

    public function getAllExpenses(Request $request)
    {
        $year = $request->year ?? date('Y');
        $type = $request->type ?? 'chicken';
        $models = ['Birds', 'Feed', 'Medicine', 'Transaction'];
        $expenses = ['Birds' => [], 'Feed' => [], 'Medicine' => [], 'Transaction' => []];
        foreach ($models as $model) {
            $expense = $this->getMonthlyExpenseData($model, $year, $type);
            array_push($expenses[$model], $expense);
        }
        return response()->json($expenses);
    }
}
