<?php

namespace App\Http\Controllers;

use App\Exports\BirdMortalityExport;
use App\Exports\BirdSaleExport;
use App\Exports\BirdsExport;
use App\Exports\EggProductionExport;
use App\Exports\EggSaleExport;
use App\Exports\FeedExport;
use App\Exports\FeedingExport;
use App\Exports\MeatSaleExport;
use App\Exports\MedicineExport;
use App\Exports\VaccineExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

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

        $data = null;
        
         
        if ($type == 'all') {

            $data = \App\Birds::join('farms', 'farms.id', '=', 'birds.farm_id')
                ->select('farms.farm_name', 'birds.*')
                ->where('farms.id', auth()->user()->farm_id)->get();
        } else {

            $data = \App\Birds::where('bird_category', $type)
                ->join('farms', 'farms.id', '=', 'birds.farm_id')
                ->select('farms.farm_name', 'birds.*')
                ->where('farms.id', auth()->user()->farm_id)->get();
        }
        //return $data;
        
        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y H:i A') : '';
            })
            ->addColumn('action', function ($row) {
                $div = "<div><span><a href=\"$row->batch_id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
                return $div;
            })->make(true);
    }

    public function exportPopulation($type)
    {
        return Excel::download(new BirdsExport(auth()->user()->farm_id, $type), "birds_$type.xlsx");
    }
    /*** Fetch bird mortality
     *
     */
    public function mortality($type)
    {
        $data = \App\BirdMortality::join('farms', 'farms.id', '=', 'bird_mortality.farm_id')
            ->select('farms.farm_name', 'bird_mortality.*')
            ->where('farms.id', auth()->user()->farm_id)->get();
        return DataTables::of($data)
            ->editColumn('observation', function ($user) {
                return $user->observation == null ? "N/A" : $user->observation;
            })
            ->editColumn('dod', function ($user) {
                return $user->dod ? with(new Carbon($user->dod))->format('l, d M Y H:i A') : '';
            })
            ->addColumn('action', function ($row) {
                $div = "<div><span><a href=\"$row->batch_id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
                return $div;
            })
            ->removeColumn('id')->make(true);
    }

    public function exportMortality($type)
    {
        return Excel::download(new BirdMortalityExport(auth()->user()->farm_id), "mortality.xlsx");
    }

    /**
     * Fetch Pen houses
     */
    public function pen()
    {
        $data = \App\PenHouse::join('farms', 'farms.id', '=', 'pen_houses.farm_id')
            ->select('farms.farm_name', 'pen_houses.*')
            ->where('farms.id', auth()->user()->farm_id)->get();
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $div = "<div><span><a href=\"$row->batch_id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
                return $div;
            })->make(true);
    }

    public function eggs($type)
    {
        $data = \App\EggProduction::where('bird_category', $type)
            ->join('farms', 'farms.id', '=', 'egg_productions.farm_id')
            ->select('farms.farm_name', 'egg_productions.*')
            ->where('farms.id', auth()->user()->farm_id)->get();
        //return response()->json($data);
        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y H:i A') : '';
            })
            ->addColumn('good_eggs', function ($row) {
                return $row->quantity - $row->bad_eggs;
            })
            ->addColumn('action', function ($row) {
                $div = "<div><span><a href=\"$row->batch_id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
                return $div;
            })->make(true);
    }

    public function exportEggs($type)
    {
        return Excel::download(new EggProductionExport(auth()->user()->farm_id, $type), "eggs_$type.xlsx");
    }

    public function feed()
    {
        $data = \App\Feed::join('farms', 'farms.id', '=', 'feeds.farm_id')
            ->select('farms.farm_name', 'feeds.*')
            ->where('farm_id', auth()->user()->farm_id)->get();
        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y H:i A') : '';
            })
            ->addColumn('action', function ($row) {
                $div = "<div><span><a href=\"$row->id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
                return $div;
            })->make(true);
    }

    public function exportFeed()
    {
        return Excel::download(new FeedExport(auth()->user()->farm_id), "feed.xlsx");
    }

    public function feeding()
    {
        $data = \App\Feeding::join('farms', 'farms.id', '=', 'feedings.farm_id')
            ->join('feeds', 'feeds.id', '=', 'feedings.feed_id')
            ->select('farms.farm_name', 'feeds.name', 'feedings.*')
            ->where('feedings.farm_id', auth()->user()->farm_id)->get();

        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y H:i A') : '';
            })
            ->addColumn('action', function ($row) {
                $div = "<div><span><a href=\"$row->id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
                return $div;
            })->make(true);
    }

    public function exportFeeding()
    {
        return Excel::download(new FeedingExport(auth()->user()->farm_id), "feeding.xlsx");
    }

    public function medicine()
    {
        $data = \App\Medicine::join('farms', 'farms.id', '=', 'medicines.farm_id')
            ->select('farms.farm_name', 'medicines.*')
            ->where('medicines.farm_id', auth()->user()->farm_id)->get();

        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y H:i A') : '';
            })
            ->addColumn('action', function ($row) {
                $div = "<div><span><a href=\"$row->id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
                return $div;
            })->make(true);

    }

    public function exportMedicine()
    {
        return Excel::download(new MedicineExport(auth()->user()->farm_id), "medicine.xlsx");
    }

    public function vaccine()
    {
        $data = \App\Vaccine::join('farms', 'farms.id', '=', 'vaccines.farm_id')
            ->select('farms.farm_name', 'vaccines.*')
            ->where('vaccines.farm_id', auth()->user()->farm_id)->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $div = "<div><span><a href=\"$row->id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
                return $div;
            })->make(true);

    }
    public function exportVaccine()
    {
        return Excel::download(new VaccineExport(auth()->user()->farm_id), "vaccine.xlsx");
    }

    public function birdSale($type)
    {

        $data = \App\BirdSale::join('farms', 'farms.id', '=', 'bird_sales.farm_id')
            ->select('farms.farm_name', 'bird_sales.*')->where('bird_sales.farm_id', auth()->user()->farm_id)->where('bird_sales.bird_category', $type)->get();
        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y H:i A') : '';
            })
            ->addColumn('action', function ($row) {
                $div = "<div><span><a href=\"$row->id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
                return $div;
            })->make(true);
    }

    public function exportBirdSale($type)
    {
        return Excel::download(new BirdSaleExport(auth()->user()->farm_id, $type), "$type sales.xlsx");
    }

    public function eggSale()
    {
        $data = \App\EggSale::join('farms', 'farms.id', '=', 'egg_sales.farm_id')
            ->select('farms.farm_name', 'egg_sales.*')
            ->where('egg_sales.farm_id', auth()->user()->farm_id)->get();

        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y H:i A') : '';
            })
            ->addColumn('action', function ($row) {
                $div = "<div><span><a href=\"$row->id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
                return $div;
            })->make(true);
    }

    public function exportEggSale($type)
    {
        return Excel::download(new EggSaleExport(auth()->user()->farm_id, $type), 'egg sales.xlsx');
    }

    public function meatSale()
    {
        $data = \App\MeatSale::join('farms', 'farms.id', '=', 'meat_sales.farm_id')
            ->select('farms.farm_name', 'meat_sales.*')
            ->where('meat_sales.farm_id', auth()->user()->farm_id)->get();

        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y H:i A') : '';
            })
            ->addColumn('action', function ($row) {
                $div = "<div><span><a href=\"$row->id\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></a></span><span><a href=\"#\" class=\"btn btn-primary btn-sm ml-4\"><i class=\"fas fa-trash-alt\"></i></a></span></div>";
                return $div;
            })->make(true);
    }

    public function exportMeatSale($type)
    {
        return Excel::download(new MeatSaleExport(auth()->user()->farm_id, $type), 'egg sales.xlsx');
    }
}
