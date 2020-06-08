<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:managers');
    }

    /**
     * Fetch the months sales where made for current user
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
     * Get monthly sales
     * @param Illuminate\Database\Eloquent\Model $model
     * @param string $month
     * @param string $year
     * @param string $category
     * @return Illuminate\Database\Eloquent\Collection $monthly_sales
     */
    public function getMonthlySales($model, $month, $year = null, $category = chicken)
    {
        // set default value of year to current year if not provided
        $year = $year ?? date("Y");
        $monthly_sales_collection = null;

        switch ($model) {
            case 'BirdSale':
                $model = "\\App\\$model";
                $monthly_sales_collection = $model::selectRaw("sum(number * price) as total_sales ")->where("farm_id", auth()->user()->farm_id)
                    ->where("bird_category", $category)->whereMonth("date", $month)->whereYear("date", $year)->pluck('total_sales');
                break;
            case 'MeatSale':
                $model = "\\App\\$model";
                $monthly_sales_collection = $model::selectRaw("sum(price) as total_sales")->where('farm_id', auth()->user()->farm_id)
                    ->where("type", $category)->whereMonth("date", $month)->whereYear("date", $year)->pluck('total_sales');
                break;
            case 'EggSale':
                $model = "\\App\\$model";
                $monthly_sales_collection = $model::selectRaw("sum(quantity * price_per_dozen) as total_sales")->where('farm_id', auth()->user()->farm_id)
                    ->where("egg_type", $category)->whereMonth("date", $month)->whereYear("date", $year)->pluck('total_sales');
                break;
        }
        $monthly_sales_collection = json_decode($monthly_sales_collection);
        $month_sales = null;
        if (!empty($monthly_sales_collection)) {
            foreach ($monthly_sales_collection as $sales) {
                $sales = $sales ?? 0; //set null values to 0;
                $month_sales = (float)$sales;
            }
        }
        return $month_sales;
    }

    /**
     * Get monthly sales data for chart js
     * @param Illuminate\Database\Eloquent\Model $model
     * @param string $year
     * @param string $category
     * @return array $monthly_sales_data_array
     */

    public function getMonthlySalesData($model, $year = null, $category = null)
    {

        $year = $year ?? date("Y");
        $monthly_sales_array = array();
        $month_array = $this->getAllMonths($model, $year);
        $month_name_array = array();
        if (!empty($month_array)) {
            foreach ($month_array as $month_no => $month_name) {
                $monthly_sales = $this->getMonthlySales($model, $month_no, $year, $category);
                array_push($monthly_sales_array, $monthly_sales);
                array_push($month_name_array, $month_name);
            }
        }

        // find the maximum sales
        $max_no = !empty($monthly_sales_array) ? max($monthly_sales_array) : 0;
        $max = round(($max_no + 10 / 2) / 10) * 10;
        $monthly_sales_data_array = array(
            'months' => $month_name_array,
            'sales' => !empty($monthly_sales_array) ? $monthly_sales_array : [0],
            'max' => $max,
        );
        return $monthly_sales_data_array;
    }

    public function getSales(Request $request,$type = null)
    {

        $models = ['BirdSale', 'MeatSale', 'EggSale'];
        $type =  $request->type ?? 'chicken' ;
        $year = $request->year ?? date('Y');
        $final_max = 0;
        $sales_array = ['BirdSale' => [], 'MeatSale' => [], 'EggSale' => []];
        foreach ($models as $key => $model) {
            $sales = $this->getMonthlySalesData($model, $year, $type);
            array_push($sales_array[$model], $sales);
            $final_max = max($final_max, $sales['max']);
        }
        $sales_array['final_max'] = $final_max;
        return response()->json($sales_array);
    }
}