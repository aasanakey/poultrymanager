<?php

namespace App\Http\Controllers;

use App\Exports\BirdMortalityExport;
use App\Exports\BirdSaleExport;
use App\Exports\BirdsExport;
use App\Exports\EggProductionExport;
use App\Exports\EggSaleExport;
use App\Exports\EmployeeExport;
use App\Exports\EquipmentExport;
use App\Exports\FeedExport;
use App\Exports\FeedingExport;
use App\Exports\MeatSaleExport;
use App\Exports\MedicineExport;
use App\Exports\TransactionsExport;
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

            $data = \App\Birds::where('farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        } else {

            $data = \App\Birds::where('bird_category', $type)
                ->where('farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        }
        //return $data;

        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y') : '';
            })
            ->addColumn('action', function ($row) {
                $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.bird', $row->batch_id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';

                return $div;
            })->make(true);
    }

    /**
     * Create excel sheet for bird population
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel;

     */
    public function exportPopulation($type)
    {
        return Excel::download(new BirdsExport(auth()->user()->farm_id, $type), "birds_$type.xlsx");
    }
    /**
     * Fetch bird mortality
     *@param string $type
     *@return Yajra\DataTables\Facades\DataTables
     */
    public function mortality($type = null)
    {
        $data = null;
        if (\is_null($type) || $type == 'all') {
            $data = \App\BirdMortality::join('birds', 'birds.batch_id', '=', 'bird_mortality.batch_id')
            ->select('bird_mortality.*')
            ->where('bird_mortality.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        } else {
            $data = \App\BirdMortality::join('birds', 'birds.batch_id', '=', 'bird_mortality.batch_id')
                ->where('birds.bird_category', $type)->where('bird_mortality.farm_id', auth()->user()->farm_id)
                ->select('bird_mortality.*')
                ->where('birds.farm_id', auth()->user()->farm_id)->orderBy('bird_mortality.created_at','desc')->get();

        }
        return DataTables::of($data)
            ->editColumn('observation', function ($user) {
                return $user->observation == null ? "N/A" : $user->observation;
            })
            ->editColumn('dod', function ($user) {
                return $user->dod ? with(new Carbon($user->dod))->format('l, d M Y') : '';
            })
            ->addColumn('action', function ($row) {
                $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.mortality', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';

                return $div;
            })->make(true);
    }

    /**
     * Create excel sheet for bird mortality
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function exportMortality($type)
    {
        return Excel::download(new BirdMortalityExport(auth()->user()->farm_id, $type), "$type mortality.xlsx");
    }

    /**
     * Fetch bird pen house
     *@param string $type
     *@return Yajra\DataTables\Facades\DataTables
     */

    public function pen($type)
    {
        $data = null;
        if ($type == "all") {
            $data = \App\PenHouse::where('farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        } else {
            $data = \App\PenHouse::where('farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();

        }
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.pen', $row->pen_id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                return $div;
            })->make(true);
    }

    /**
     * Fetch eggs collected
     *@param string $type
     *@return Yajra\DataTables\Facades\DataTables
     */

    public function eggs($type)
    {
        $data = null;
        if ($type == 'all' || \is_null($type)) {
            $data = \App\EggProduction::where('farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();

        } else {
            $data = \App\EggProduction::where('bird_category', $type)
                ->where('farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        }
        //return response()->json($data);
        return DataTables::of($data)
            ->editColumn('date_collected', function ($user) {
                return $user->date_collected ? with(new Carbon($user->date_collected))->format('l, d M Y') : '';
            })
            ->addColumn('good_eggs', function ($row) {
                return $row->quantity - $row->bad_eggs;
            })
            ->addColumn('action', function ($row) {
                $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.eggs', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                return $div;

            })->make(true);
    }

    /**
     * Create excel sheet for eggs collected
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel
     */

    public function exportEggs($type)
    {
        return Excel::download(new EggProductionExport(auth()->user()->farm_id, $type), "eggs_$type.xlsx");
    }

    /**
     * Fetch feed stock
     *@param string $type
     *@return Yajra\DataTables\Facades\DataTables
     */

    public function feed($type = null)
    {
        $data = null;
        if ($type == 'all' || is_null($type)) {
            $data = \App\Feed::where('farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();

        } else {
            $data = \App\Feed::where('feed_type', $type)
                ->where('farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        }

        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y') : '';
            })
            ->addColumn('action', function ($row) {
                $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.feed', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                return $div;
            })->make(true);
    }

    /**
     * Create excel sheet for feed stock
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel
     */

    public function exportFeed($type)
    {
        return Excel::download(new FeedExport(auth()->user()->farm_id, $type), "$type feed.xlsx");
    }

    /**
     * Fetch bird feeding
     *@param string $type
     *@return Yajra\DataTables\Facades\DataTables
     */

    public function feeding($type = null)
    {
        $data = null;
        if (is_null($type) || $type == 'all') {
            $data = \App\Feeding::join('feeds', 'feeds.id', '=', 'feedings.feed_id')
                ->select('feeds.name', 'feedings.*')
                ->where('feedings.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();

        } else {
            $data = \App\Feeding::join('feeds', 'feeds.id', '=', 'feedings.feed_id')
                ->join('pen_houses', 'pen_houses.pen_id', '=', 'feedings.pen_id')
                ->select( 'feeds.name', 'feedings.*')
                ->where('pen_houses.bird_type', $type)
                ->where('feedings.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();

        }

        return DataTables::of($data)
            ->editColumn('date', function ($row) {
                return $row->date ? with(new Carbon($row->date))->format('l, d M Y H:i A') : '';
            })
            ->addColumn('action', function ($row) {
               $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.feeding', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                return $div;
            })->make(true);
    }

    /**
     * Create excel sheet for bird feeding
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel
     */

    public function exportFeeding($type = null)
    {
        return Excel::download(new FeedingExport(auth()->user()->farm_id, $type), "$type feeding.xlsx");
    }

    /**
     * Fetch medicines for birds
     *@param string $type
     *@return Yajra\DataTables\Facades\DataTables
     */

    public function medicine($type = null)
    {
        $data = null;
        if ($type == 'all' || is_null($type)) {
            $data = \App\Medicine::where('medicines.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        } else {
            $data = \App\Medicine::where('medicines.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        }

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
               $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.medicine', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                return $div;
            })->make(true);

    }

    /**
     * Create excel sheet for medicine
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel
     */

    public function exportMedicine($type = null)
    {
        return Excel::download(new MedicineExport(auth()->user()->farm_id, $type), "$type medicine.xlsx");
    }

/**
 * Fetch vaccines for birds
 *@param string $type
 *@return Yajra\DataTables\Facades\DataTables
 */

    public function vaccine($type = null)
    {
        $data = null;
        if ($type == "all" || is_null($type)) {
            $data = \App\Vaccine::where('vaccines.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        } else {
            $data = \App\Vaccine::where('vaccines.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();

        }

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
               $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.vaccine', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                return $div;
            })->make(true);

    }
    /**
     * Create excel sheet for vaccine
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel
     */

    public function exportVaccine($type = null)
    {
        return Excel::download(new VaccineExport(auth()->user()->farm_id, $type), "$type vaccine.xlsx");
    }

/**
 * Fetch bird sales
 *@param string $type
 *@return Yajra\DataTables\Facades\DataTables
 */

    public function birdSale($type = null)
    {

        $data = \App\BirdSale::where('bird_sales.farm_id', auth()->user()->farm_id)->where('bird_sales.bird_category', $type)->get();
        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y') : '';
            })
            ->addColumn('action', function ($row) {
                $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.sale.bird', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                return $div;
            })->make(true);
    }

    /**
     * Create excel sheet for bird sales
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel
     */

    public function exportBirdSale($type)
    {
        return Excel::download(new BirdSaleExport(auth()->user()->farm_id, $type), "$type sales.xlsx");
    }

/**
 * Fetch eggs sole
 *@param string $type
 *@return Yajra\DataTables\Facades\DataTables
 */

    public function eggSale($type = null)
    {
        $data = \App\EggSale::where('egg_sales.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();

        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y') : '';
            })
            ->addColumn('action', function ($row) {
                $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.sale.egg', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                return $div;
            })->make(true);
    }

    /**
     * Create excel sheet for egg sales
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel
     */

    public function exportEggSale($type)
    {
        return Excel::download(new EggSaleExport(auth()->user()->farm_id, $type), 'egg sales.xlsx');
    }

/**
 * Fetch meat sale
 *@param string $type
 *@return Yajra\DataTables\Facades\DataTables
 */

    public function meatSale($type = null)
    {
        $data = \App\MeatSale::where('meat_sales.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();

        return DataTables::of($data)
            ->editColumn('date', function ($user) {
                return $user->date ? with(new Carbon($user->date))->format('l, d M Y') : '';
            })
            ->addColumn('action', function ($row) {
               $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.sale.meat', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                    return $div;
            })->make(true);
    }

    /**
     * Create excel sheet for meat sales
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel
     */

    public function exportMeatSale($type)
    {
        return Excel::download(new MeatSaleExport(auth()->user()->farm_id, $type), 'egg sales.xlsx');
    }
/**
 * Fetch employee data
 *@param string $type
 *@return Yajra\DataTables\Facades\DataTables
 */

    public function employee($type = null)
    {
        $data = null;
        if ($type == 'all' || $type == null) {
            $data = \App\Employee::where('farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        } else {
            $data = \App\Employee::where('farm_category', $type)
                ->where('farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();

        }
        // $data->employee_id = $data->id;
        return DataTables::of($data)
           
            ->editColumn('hire_date', function ($employee) {
                return $employee->hire_date ? with(new Carbon($employee->hire_date))->format('l, d M Y') : '';
            })
            ->editColumn('photo', function ($employee) {
                return $employee->photo ?? 'N/A';
            })
            ->addColumn('age', function ($employee) {
                return date_diff(date_create($employee->dob), date_create('today'))->y;;
            })
            ->addColumn('action', function ($row) {
                $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.employee', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                        return $div;
            })->make(true);

    }
    /**
     * export employees data as excel
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel
     */

    public function exportEmployee($type = null)
    {
        return Excel::download(new EmployeeExport(auth()->user()->farm_id, $type), 'employees.xlsx');

    }

/**
 * Fetch admins
 *@param string $type
 *@return Yajra\DataTables\Facades\DataTables
 */

    public function admins()
    {
        $data = \App\FarmAdmin::where('farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        return DataTables::of($data)
            ->editColumn('role', function ($row) {
                return $row->role == "SUPER_ADMIN" ? "Admin" : 'Farmhand';
            })
            ->addColumn('action', function ($row) {
               $div = '<div>
                            <span>
                                <form action="' . route('admin.delete.admin', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                return $div;
            })->make(true);
    }

    /**
     * Fetch equipment
     *@param string $type
     *@return Yajra\DataTables\Facades\DataTables
     */
    public function equipment($type = null)
    {
        $data = null;
        if ($type == 'all' || is_null($type)) {
            $data = \App\Equipment::where('equipment.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        } else {
            $data = \App\Equipment::where('farm_category', $type)->where('equipment.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();

        }
        return DataTables::of($data)
            ->editColumn('date_acquired', function ($row) {
                return $row->date_acquired ? with(new Carbon($row->date_acquired))->format('l, d M Y') : '';
            })
            ->addColumn('action', function ($row) {
                $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.equipment', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                return $div;
            })->make(true);

    }

    /**
     * Create excel sheet for equipment
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function exportEquipment($type)
    {
        return Excel::download(new EquipmentExport(auth()->user()->farm_id, $type), "$type equipment.xlsx");
    }

    /**
     * Fetch equipment transactions
     *@param string $type
     *@return Yajra\DataTables\Facades\DataTables
     */

    public function transactions($type)
    {
        $data = null;
        if ($type == 'all' || is_null($type)) {
            $data = \App\Transation::where('transactions.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();
        } else {
            $data = \App\Transaction::where('transactions.farm_category', $type)->where('transactions.farm_id', auth()->user()->farm_id)->orderBy('created_at','desc')->get();

        }
        return DataTables::of($data)
            ->editColumn('date', function ($row) {
                return $row->date ? with(new Carbon($row->date))->format('l, d M Y') : '';
            })
            ->editColumn('type', function ($row) {
                return $row->type ? ucfirst($row->type) : $row->type;
            })
            ->addColumn('action', function ($row) {
                $div = '<div>
                            <span>
                                <a href="#" class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></a>
                            </span>
                            <span>
                                <form action="' . route('admin.delete.transaction', $row->id) . '" class="delete-row-form" method="post">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="button" class="btn btn-primary btn-sm ml-4 delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </span>
                        </div>';
                return $div;
            })->make(true);
    }

    /**
     * Create excel sheet for transactions
     * @param string $type
     * @return Maatwebsite\Excel\Facades\Excel
     */

    public function exportTransactions($type = null)
    {
        return Excel::download(new TransactionsExport(auth()->user()->farm_id, $type), "transactions_$type.xlsx");
    }

}
