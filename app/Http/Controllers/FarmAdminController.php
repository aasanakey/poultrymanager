<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FarmAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth:managers');
        $this->middleware('verified');
        $this->middleware('role:SUPER_ADMIN');
    }

    public function dashboard()
    {
        $is_setup = \App\Farm::where('is_setup', false)->find(auth()->user()->farm_id);
        if ($is_setup) {
            return view('admin.sup_admin.setup');
        }

        return view('admin.sup_admin.index');
    }

    public function profile()
    {

        return view('admin.sup_admin.profile');
    }

    public function index($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.index');
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.index');
                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.index');
                break;
            default:
                return response()->view('errors.404');
        }
    }

    public function birdType($type)
    {
        switch ($type) {
            case 'chicken':
                return redirect()->route('admin.home', $type);
                break;

            case 'turkey':
                return redirect()->route('admin.home', $type);
                break;
            case 'guinea_fowl':
                return redirect()->route('admin.home', $type);
                break;
             default:
                return response()->view('errors.404');
        }
    }

    /**
     * Get bird population
     */
    public function population($type)
    {
        $pen = \App\PenHouse::select('pen_id')->where('farm_id', auth()->user()->farm_id)
            ->where('bird_type', $type)->get();
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.population', compact('pen'));
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.population', compact('pen'));
                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.population', compact('pen'));
                break;
             default:
                return response()->view('errors.404');
        }
    }

    /**
     * add bird to database
     */
    public function addBird(Request $request, $type = null)
    {
        if ($request->has('bird')) {
            $request->validate([
                "bird" => ['required', 'string'],
                "species" => ['required'],
                "type" => ['sometimes', 'nullable', 'string'],
                "pen" => ['required', 'string'],
                "number" => ['required', 'numeric', 'min:0'],
                "price" => ['required', 'numeric', 'min:0'],
                "date" => ['required', 'date'],
            ]);
            $type = $request->bird;
        } else {
            $request->validate([
                "species" => ['required'],
                "type" => ['sometimes', 'nullable', 'string'],
                "pen" => ['required', 'string'],
                "number" => ['required', 'numeric', 'min:0'],
                "price" => ['required', 'numeric', 'min:0'],
                "date" => ['required', 'date'],
            ]);

        }

        $farm = \App\Farm::find(auth()->user()->farm_id);

        \App\Birds::create([
            "batch_id" => generate_batch_id($farm->farm_name),
            "farm_id" => auth()->user()->farm_id,
            "bird_category" => $type,
            'pen_id' => $request->pen,
            'number' => $request->number,
            "species" => $request->species,
            "type" => $request->type,
            "unit_price" => $request->price,
            "date" => date($request->date),
        ]);
        return redirect()->back()->with('success', 'Bird added successfully!');
    }

    public function mortality($type)
    {
        $pen = \App\PenHouse::select('pen_id')->where('farm_id', auth()->user()->farm_id)->
            where('bird_type', $type)->get();
        $batch_id = \App\Birds::select('batch_id')->where('bird_category', $type)
            ->where('farm_id', auth()->user()->farm_id)->get();
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.mortality', compact('pen', 'batch_id'));
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.mortality', compact('pen', 'batch_id'));

                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.mortality', compact('pen', 'batch_id'));
                break;
             default:
                return response()->view('errors.404');
        }
    }

    public function addMortality($type, Request $request)
    {
        // dd($request->all());
        $request->validate([
            "batch_id" => ['required', 'string'],
            "pen" => ['required', 'string'],
            "number" => ['required', 'numeric', 'min:0'],
            "date" => ['required', 'date'],
            "unit_price" => ['required', 'numeric', 'min:0'],
            "cause" => ['required', 'string'],
            "observation" => ['sometimes', 'string', 'nullable'],
        ]);

        \App\BirdMortality::create([
            "batch_id" => $request->batch_id,
            "farm_id" => auth()->user()->farm_id,
            "pen_id" => $request->pen,
            "number" => $request->number,
            "dod" => new \DateTime($request->date),
            "unit_price" => $request->unit_price,
            "cause" => $request->cause,
            "observation" => $request->observation,
        ]);
        return redirect()->back()->with('success', 'Mortality added successfully');
    }

    public function pen($type)
    {

        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.addpen');
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.addpen');

                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.addpen');
                break;
            default:
                return response()->view('errors.404');
        }
    }

    public function addPen(Request $request, $type = null)
    {
        // dd($request->all());

        if ($request->has('bird_type')) {
            $request->validate([
                "id" => ['required', 'string', 'unique:pen_houses,pen_id'],
                "location" => ['required', 'string'],
                "size" => ['required', 'numeric', 'min:0'],
                "capacity" => ['required', 'numeric', 'min:0'],
                "bird_type" => ['required', 'string'],
            ]);
            $type = $request->bird_type;
        } else {
            $request->validate([
                "id" => ['required', 'string', 'unique:pen_houses,pen_id'],
                "location" => ['required', 'string'],
                "size" => ['required', 'numeric', 'min:0'],
                "capacity" => ['required', 'numeric', 'min:0'],
            ]);

        }
        // dd(\generate_pen_id("the farm"));
        \App\PenHouse::create([
            'pen_id' => $request->id,
            "farm_id" => \auth()->user()->farm_id,
            "location" => $request->location,
            "size" => $request->size,
            "capacity" => $request->capacity,
            "bird_type" => $type,
        ]);

        return back()->with('success', 'Pen House added successfully');

    }

    public function setupBird()
    {
        // $is_setup = \App\Farm::where('is_setup',false)->find(auth()->user()->farm_id);
        // if( $is_setup)
        // $pen = \App\PenHouse::select('pen_id')->where('farm_id', auth()->user()->farm_id)->get();
        return view('admin.sup_admin.setup_bird');
    }

    public function setupFinish()
    {
        $has_bird = \App\Birds::where('farm_id', auth()->user()->id)->get();

        if (isset($has_bird) && count($has_bird) > 0) {
            $farm = \App\Farm::where('id', auth()->user()->farm_id)->find(auth()->user()->farm_id);
            $farm->is_setup = true;
            $farm->save();
            return redirect('/dashboard');
        }
        return back()->with('error', 'Please Add Birds to proceed');
    }

    public function eggProduction($type)
    {
        $pen = \App\PenHouse::select('pen_id')->where('farm_id', auth()->user()->farm_id)
            ->where('bird_type', $type)->get();
        $batch_id = \App\Birds::select('batch_id')
            ->where('bird_category', $type)->where('farm_id', auth()->user()->farm_id)->get();
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.egg_production', compact('pen', 'batch_id'));
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.egg_production', compact('pen', 'batch_id'));
                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.egg_production', compact('pen', 'batch_id'));
                break;
             default:
                return response()->view('errors.404');
        }
    }

    public function addEggProduction($type, Request $request)
    {
        //dd($request->all());
        $request->validate([
            "batch_id" => ['required', 'string'],
            "pen" => ['required', 'string'],
            "number" => ['required', 'numeric', 'min:0'],
            "date" => ['required', 'date'],
            "bad_eggs" => ['required', 'numeric', 'min:0'],
        ]);

        \App\EggProduction::create([
            "layer_batch_id" => $request->batch_id,
            "farm_id" => auth()->user()->farm_id,
            "pen_id" => $request->pen,
            "quantity" => $request->number,
            "date_collected" => new \DateTime($request->date),
            "bad_eggs" => $request->bad_eggs,
            "bird_category" => $type,

        ]);
        return redirect()->back()->with('success', 'Eggs record added successfully');
    }

    public function feed($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.feed');
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.feed');
                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.feed');
                break;
             default:
                return response()->view('errors.404');
        }
    }

    public function addFeed(Request $request)
    {
        $request->validate([
            "name" => ['required', 'string'],
            "price" => ['required', 'numeric', 'min:0'],
            "quantity" => ['required', 'numeric', 'min:0'],
            "date" => ['required', 'date'],
            "supplier" => ['required', 'string'],
            "description" => ['required', 'string'],
        ]);
        \App\Feed::create([
            "farm_id" => auth()->user()->farm_id,
            "name" => $request->name,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "description" => $request->description,
            "supplier" => $request->supplier,
        ]);
        return redirect()->back()->with('success', 'Feed record added successfully');
    }

    public function feeding($type)
    {
        $pen = \App\PenHouse::select('pen_id')->where('farm_id', auth()->user()->farm_id)
            ->where('bird_type', $type)->get();
        $feed = \App\Feed::select('name', 'id')->where('farm_id', auth()->user()->farm_id)->get();
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.feeding', compact('pen', 'feed'));
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.feeding', compact('pen', 'feed'));

                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.feeding', compact('pen', 'feed'));
                break;
             default:
                return response()->view('errors.404');
        }
    }

    public function addFeeding(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "feed_id" => ['required', 'not_in:-- select feed --'],
            "pen" => ['required', 'string', 'not_in:-- select pen --'],
            "feed_quantity" => ['required', 'numeric', 'min:0'],
            "date" => ['required', 'date'],
            "water_quantity" => ['required', 'numeric', 'min:0'],
        ]);

        \App\Feeding::create([
            "farm_id" => auth()->user()->farm_id,
            "pen_id" => $request->pen,
            "date" => new \DateTime($request->date),
            "feed_id" => $request->feed_id,
            "feed_quantity" => $request->feed_quantity,
            "water_quantity" => $request->water_quantity,
        ]);
        return redirect()->back()->with('success', 'Feed record added successfully');
    }

    public function medicine($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.medicine');
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.medicine');
                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.medicine');
                break;
             default:
                return response()->view('errors.404');
        }
    }

    public function addMedicine(Request $request)
    {
        $request->validate([
            "name" => ['required', 'string'],
            "price" => ['required', 'numeric', 'min:0'],
            "quantity" => ['required', 'string'],
            "date" => ['required', 'date'],
            "supplier" => ['sometimes', 'string', 'nullable'],
            "description" => ['required', 'string'],
        ]);
        \App\Medicine::create([
            "farm_id" => auth()->user()->farm_id,
            "name" => $request->name,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "date" => new \DateTime($request->date),
            "supplier" => $request->supplier,
            "description" => $request->description,
        ]);
        return redirect()->back()->with('success', 'Medicine added successfully');

    }

    public function vaccine($type)
    {
        $pen = \App\PenHouse::select('pen_id')->where('farm_id', auth()->user()->farm_id)->get();

        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.vaccine');
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.vaccine');
                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.vaccine');
                break;
             default:
                return response()->view('errors.404');
        }
    }

    public function addVaccine(Request $request)
    {

        $request->validate([
            "age" => ['required', 'string'],
            "disease" => ['required', 'string'],
            "mode" => ['required', 'string'],
            "type" => ['required', 'string'],
        ]);
        \App\Vaccine::create([
            "farm_id" => auth()->user()->farm_id,
            "age" => $request->age,
            "disease" => $request->disease,
            "mode" => $request->mode,
            "type" => $request->type,
        ]);
        return redirect()->back()->with('success', 'Vaccine record added successfully');

    }

    public function birdSale($type)
    {
        $batch_id = \App\Birds::select('batch_id')->where('bird_category', $type)
            ->where('farm_id', auth()->user()->farm_id)->get();

        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.birdsale', compact('batch_id'));
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.birdsale', compact('batch_id'));
                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.birdsale', compact('batch_id'));
                break;
             default:
                return response()->view('errors.404');
        }
    }

    public function addBirdSale($type, Request $request)
    {
        // dd($request->all());
        $request->validate([
            "batch_id" => ['required', 'string', 'not_in:--select batch id--', 'exists:birds,batch_id'],
            "weight" => ['required', 'numeric', 'min:0'],
            "price" => ['required', 'numeric', 'min:0'],
            "date" => ['required', 'date'],
            "number" => ['required', 'numeric', 'min:0'],
        ]);

        \App\BirdSale::create([
            "farm_id" => auth()->user()->farm_id,
            "bird_batch_id" => $request->batch_id,
            "weight" => $request->weight,
            "price" => $request->price,
            "date" => new \DateTime($request->date),
            "bird_category" => $type,
            "number" => $request->number,
        ]);

        return redirect()->back()->with('success', 'Bird sale added successfully');

    }

    public function eggSale($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.eggsale');
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.eggsale');
                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.eggsale');
                break;
            default:
                return response()->view('errors.404');
        }
    }

    public function addEggSale($type, Request $request)
    {

        $request->validate([
            "weight" => ['required', 'numeric', 'min:0'],
            "price" => ['required', 'numeric', 'min:0'],
            "quantity" => ['required', 'numeric', 'min:0'],
            "date" => ['required', 'date'],
        ]);

        \App\EggSale::create([
            "farm_id" => auth()->user()->farm_id,
            "weight_per_dozen" => $request->weight,
            "price_per_dozen" => $request->price,
            "quantity" => $request->quantity,
            "date" => new \DateTime($request->date),
            "egg_type" => $type,
        ]);

        return redirect()->back()->with('success', 'Egg sale added successfully');
    }

    public function meatSale($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.meatsale');
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.meatsale');
                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.meatsale');
                break;
             default:
                return response()->view('errors.404');
        }
    }

    public function addMeatSale($type, Request $request)
    {
        // dd($request->all());
        $request->validate([
            "part" => ['required', 'string', 'not_in:--select--'],
            "price" => ['required', 'numeric', 'min:0'],
            "quantity" => ['required', 'numeric', 'min:0'],
            "date" => ['required', 'date'],
        ]);
        \App\MeatSale::create([
            "farm_id" => auth()->user()->id,
            "type" => $type,
            "part" => $request->part,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "date" => new \DateTime($request->date),
        ]);
        return redirect()->back()->with('success', 'Meat sale added successfully');
    }

    public function equipment()
    {
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.equipment');
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.equipment');
                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.equipment');
                break;
             default:
                return response()->view('errors.404');
        }
    }

    public function employee($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.employee');
                break;

            case 'turkey':
                return view('admin.sup_admin.turkey.employee');
                break;
            case 'guinea_fowl':
                return view('admin.sup_admin.guineafowl.employee');
                break;
            default:
                return response()->view('errors.404');
        }

    }
    public function addemployee(Request $request, $type = null)
    {
        // dd($request->all());
        $request->validate([
            'id' => ['required','string','unique:employees'],
            "full_name" => ['required','string'],
            "dob" => ['required','date'],
            "email" => ['required','email','unique:employees'],
            "hire_date" => ['required','date'],
            "contact" => ['required','phone:GH,fixed_line,mobile'],
            "photo" => ['sometimes','image','mimes:jpeg,bmp,png','nullable'],
            "jd" => ['sometimes','string','max:255', 'nullable'],
            "category" => ['string']
        ]);

        \App\Employee::create([
            #Todo: change id to employee_id
            // 'employee_id' => $request->id,
            'id' => $request->id,
            "farm_id" => auth()->user()->farm_id,
            "full_name" => $request->full_name,
            "dob" => new \DateTime($request->dob),
            "email" => $request->email,
            "hire_date" => new \DateTime($request->hire_date),
            "contact" => $request->contact,
            "photo" => $request->photo ?? null,
            "jd" => $request->jd,
            "farm_category" => $request->category,
        ]);
        return redirect()->back()->with('success', 'Employee added successfully');

    }
}
