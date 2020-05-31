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
     * Fetch the months sales where made
     * @param Illuminate\Database\Eloquent\Model $model
     * @param string $field
     * @return array $month_array
     */
    public function getAllMonths($model, $field)
    {
        $model = "\\App\\$model";
        $month_array = array();
        $sales_dates = $model::orderBy("$field", 'ASC')->pluck("$field");
        $sales_dates = json_decode($sales_dates);

        if (!empty($sales_dates)) {
            foreach ($sales_dates as $unformatted_date) {
                $date = new \DateTime($unformatted_date);
                $month_no = $date->format('m');
                $month_name = $date->format('M');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }

    /**
     * Get monthly sales
     * @param Illuminate\Database\Eloquent\Model $model
     * @param string $field
     * @return Collection
     */
    public function getMonthlySales($model, $field = "date", $product = null,$price_field='price', $month)
    {
        $model = "\\App\\$model";
        $monthly_sales = $model::whereMonth("$field", $month)->get()->sum($price_field);
        return $monthly_sales;
    }

    /**
     * Get monthly sales data for chart js
     * @param Illuminate\Database\Eloquent\Model $model
     * @param string $field
     * @param string $product
     * @return array $monthly_sales_data_array
     */

    public function getMonthlySalesData($model, $field = "date", $product=null,$price_field='price')
    {

        $monthly_sales_array = array();
        $month_array = $this->getAllMonths($model, $field);
        $month_name_array = array();
        if (!empty($month_array)) {
            foreach ($month_array as $month_no => $month_name) {
                $monthly_sales = $this->getMonthlySales($model, $field, $product, $price_field, $month_no);
                array_push($monthly_sales_array, $monthly_sales);
                array_push($month_name_array, $month_name);
            }
        }

        $max_no = max($monthly_sales_array);
        $max = round(($max_no + 10 / 2) / 10) * 10;
        $monthly_sales_data_array = array(
            'months' => $month_name_array,
            'sales' => $monthly_sales_array,
            'max' => $max,
        );

        return $monthly_sales_data_array;

    }
    public function test(Request $request)
    {
        $model = 'BirdSale';
        $field = "date";
        // $months = $this->getAllMonths($model, $field);
        // $ms = [];
        // foreach ($months as $no => $name) {
        //     $sale = $this->getMonthlySales($model, $field, $no);
        //     array_push($ms, [$name => $sale]);
        // }
        // dd($ms);
        return $this->getMonthlySalesData($model, $field);

    }
    public function getSales($type = null)
    {
        $models = ['BirdSale', 'MeatSale', 'EggSale'];
        $field = 'date';
        $product = $type;
        $final_max = 0;
        $sales_array = ['BirdSale' => [], 'MeatSale' => [], 'EggSale' => []];
        foreach ($models as $key => $model) {
            $sales = ($model == "EggSale") ? $this->getMonthlySalesData($model, $field, $product,'price_per_dozen') :$this->getMonthlySalesData($model, $field, $product);
            array_push($sales_array[$model], $sales);
            $final_max = max($final_max, $sales['max']);
        }
        $sales_array['final_max'] = $final_max;
        return response()->json($sales_array);
    }
}