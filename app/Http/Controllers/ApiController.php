<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BirdsExport;
use App\Exports\BirdMortalityExport;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Carbon\Carbon;

class ApiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:managers');
    }
    /**
     * Fetch bird population
     * @param string $type
     * @return Yajra\DataTables\Facades\DataTables
     */
    public function population($type)
    {

        $data = \App\Birds::where('bird_category',$type)
        ->join('farms','farms.id','=','birds.farm_id')
        ->select('farms.farm_name','birds.*')
        ->where('farms.id',auth()->user()->farm_id)->get();
        //return response()->json($data);
        return DataTables::of($data)
        ->editColumn('date', function ($user) {
            return $user->date ? with(new Carbon($user->date))->format('l, d M Y H:i A') : '';
        })
        ->addColumn('action', function($row){
            $div = "<div><span><a href=\"$row->batch_id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
             return $div;
        })->make(true);
    }

    public function exportPopulation($type)
    {
        return Excel::download(new BirdsExport(auth()->user()->farm_id,$type), "mortality.xlsx");
    }
    /*** Fetch bird mortality
     *
    */
    public function mortality($type)
    {
        $data = \App\BirdMortality::join('farms','farms.id','=','bird_mortality.farm_id')
        ->select('farms.farm_name','bird_mortality.*')
        ->where('farms.id',auth()->user()->farm_id)->get();
        return DataTables::of($data)
        ->editColumn('observation', function ($user) {
            return $user->observation == null ? "N/A" : $user->observation ;
        })
        ->editColumn('dod', function ($user) {
            return $user->dod ? with(new Carbon($user->dod))->format('l, d M Y H:i A') : '';
        })
         ->addColumn('action', function($row){
            $div = "<div><span><a href=\"$row->batch_id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
             return $div;
        })
        ->removeColumn('id')->make(true);
    }

    public function exportMortality($type)
    {
        return Excel::download(new BirdMortalityExport(auth()->user()->farm_id), "birds_$type.xlsx");
    }

    /**
     * Fetch Pen houses
     */
    public function pen()
    {
        $data = \App\PenHouse::join('farms','farms.id','=','pen_houses.farm_id')
        ->select('farms.farm_name','pen_houses.*')
        ->where('farms.id',auth()->user()->farm_id)->get();
        return DataTables::of($data)
        ->addColumn('action', function($row){
            $div = "<div><span><a href=\"$row->batch_id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
             return $div;
        })->make(true);
    }


    public function eggs($type)
    {
       return DataTables::of(\App\EggProduction::query())->make(true);
    }

    public function exportEggs($type)
    {
        # code...
    }
}
