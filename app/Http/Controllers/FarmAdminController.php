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
        // $this->middleware('role:SUPER_ADMIN');
    }

    public function dashboard()
    {
        $is_setup = \App\Farm::where('is_setup', false)->find(auth()->user()->farm_id);
        if ($is_setup) {
            return view('admin.setup');
        }

        return view('admin.index');
    }

    public function setupBird()
    {
        $has_pen = auth()->user()->farm->pen;
// dd($has_pen);

        if (isset($has_pen) && count($has_pen) == 0) {
            return redirect()->back()->with('error', 'Please add pen');
        }

        return view('admin.setup_bird');
    }

    public function setupFinish()
    {
        $has_bird =  auth()->user()->farm->birds;//\App\Birds::where('farm_id', auth()->user()->farm_id)->get();
// dd($has_bird);

        if (isset($has_bird) && count($has_bird) > 0) {
            $farm = \App\Farm::where('id', auth()->user()->farm_id)->find(auth()->user()->farm_id);
            $farm->is_setup = true;
            $farm->save();
            return redirect('/dashboard');
        }
        return back()->with('error', 'Please Add Birds to proceed');
    }

    public function profile($view)
    {
        switch ($view) {
            case 'chicken':
                return view('admin.chicken.profile', ["user" => auth()->user()]);
                break;

            case 'turkey':
                return view('admin.turkey.profile', ["user" => auth()->user()]);
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.profile', ["user" => auth()->user()]);
                break;
            default:
                return response()->view('errors.404');
        }
    }

    public function index($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.index');
                break;

            case 'turkey':
                return view('admin.turkey.index');
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.index');
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
                return view('admin.chicken.population', compact('pen'));
                break;

            case 'turkey':
                return view('admin.turkey.population', compact('pen'));
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.population', compact('pen'));
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
        // dd($request->all());
        if ($request->has('bird')) {
            $request->validate([
                "bird" => ['required', 'string', 'max:191', 'unique:birds,batch_id'],
                "species" => ['required'],
                "type" => ['sometimes', 'nullable', 'string'],
                "pen" => ['required', 'string', 'max:191', 'exists:pen_houses,pen_id'],
                "number" => ['required', 'numeric', 'min:0'],
                "price" => ['required', 'numeric', 'min:0'],
                "date" => ['required', 'date'],
            ]);
            $type = $request->bird;
        } else {
            $request->validate([
                "species" => ['required'],
                "type" => ['sometimes', 'nullable', 'string'],
                "pen" => ['required', 'string', 'max:191', 'exists:pen_houses,pen_id'],
                "number" => ['required', 'numeric', 'min:0'],
                "price" => ['required', 'numeric', 'min:0'],
                "date" => ['required', 'date'],
            ]);

        }

        $farm = auth()->user()->farm;

        \App\Birds::create([
            "batch_id" => generate_batch_id($farm->farm_name, $type),
            "farm_id" => auth()->user()->farm_id,
            "bird_category" => $type,
            'pen_id' => $request->pen,
            'number' => $request->number,
            "species" => $request->species,
            "type" => $request->type,
            "unit_price" => $request->price,
            "date" => new \DateTime($request->date),
        ]);
        return redirect()->back()->with('success', 'Bird added successfully!');
    }

    /**
     * Update the pen resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */

    public function editBird(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            // "bird" => ['required', 'string','max:191','unique:birds,batch_id'],
            "bird_species" => ['required'],
            "bird_type" => ['sometimes', 'nullable', 'string'],
            "bird_pen" => ['required', 'string', 'max:191'],
            "bird_number" => ['required', 'numeric', 'min:0'],
            "bird_price" => ['required', 'numeric', 'min:0'],
            "bird_date" => ['required', 'date'],
        ]);
        $bird = \App\Birds::where('batch_id', $id)->first();
        $bird->species = $request->bird_species;
        $bird->type = $request->bird_type;
        if ($bird->pen_id !== $request->bird_pen) {
            $request->validate(["bird_pen" => ['exists:pen_houses,pen_id']]);
            $bird->pen_id = $request->bird_pen;
        }
        $bird->number = $request->bird_number;
        $bird->unit_price = $request->bird_price;
        $bird->date = new \DateTime($request->bird_date);
        $bird->save();
        return redirect()->back()->with('success', 'Bird record updated');
    }

    /**
     * Remove the birds resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteBird($id)
    {
        $bird = \App\Birds::where('batch_id', $id);
        $bird->delete();
        return redirect()->back()->with('success', "Bird batch $id deleted successfully");
    }
    public function mortality($type)
    {
        // $pen = \App\PenHouse::select('pen_id')->where('farm_id', auth()->user()->farm_id)->
        //     where('bird_type', $type)->get();
        $birds = \App\Birds::select('batch_id')->where('bird_category', $type)
            ->where('farm_id', auth()->user()->farm_id)->get();
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.mortality', compact('birds'));
                break;

            case 'turkey':
                return view('admin.turkey.mortality', compact('birds'));

                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.mortality', compact('birds'));
                break;
            default:
                return response()->view('errors.404');
        }
    }

    /**
     * Update the mortality resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editMortality(Request $request, $id)
    {
        $request->validate([
            "_batch_id" => ['required', 'string', 'max:191', 'exists:birds,batch_id'],
            "_number" => ['required', 'numeric', 'min:0'],
            "_pen" => ['required', 'string', 'max:191', 'exists:pen_houses,pen_id'],
            "_unit_price" => ['required', 'numeric', 'min:0'],
            "_cause" => ['required', 'string', 'max:191'],
            "_date" => ['required', 'date'],
            "_observation" => ['required', 'string', 'max:191'],
        ]);
        $mortality = \App\BirdMortality::find($id);
        $mortality->batch_id = $request->_batch_id;
        $mortality->number = $request->_number;
        $mortality->pen_id = $request->_pen;
        $mortality->cause = $request->_cause;
        $mortality->unit_price = $request->_unit_price;
        $mortality->dod = new \DateTime($request->_date);
        $mortality->observation = $request->_observation;
        $mortality->save();
        return redirect()->back()->with('success', 'Bird record updated');
    }

    /**
     * Remove the bird mortality resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMortality($id)
    {
        $mortality = \App\BirdMortality::find($id);
        $mortality->delete();
        return redirect()->back()->with('success', "Bird mortaliy deleted successfully");
    }

    public function addMortality($type, Request $request)
    {
        // dd($request->all());
        $request->validate([
            "batch_id" => ['required', 'string', 'max:191'],
            "pen" => ['required', 'string', 'max:191'],
            "number" => ['required', 'numeric', 'min:0'],
            "date" => ['required', 'date'],
            "unit_price" => ['required', 'numeric', 'min:0'],
            "cause" => ['required', 'string', 'max:191'],
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
                return view('admin.chicken.addpen');
                break;

            case 'turkey':
                return view('admin.turkey.addpen');

                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.addpen');
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
                "id" => ['required', 'string', 'max:191', 'unique:pen_houses,pen_id'],
                "location" => ['required', 'string', 'max:191'],
                "size" => ['required', 'numeric', 'min:0'],
                "capacity" => ['required', 'numeric', 'min:0'],
                "bird_type" => ['required', 'string', 'max:191'],
            ]);
            $type = $request->bird_type;
        } else {
            $request->validate([
                "id" => ['required', 'string', 'max:191', 'unique:pen_houses,pen_id'],
                "location" => ['required', 'string', 'max:191'],
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

        return redirect()->back()->with('success', 'Pen House added successfully');

    }

    /**
     * Update the pen resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */

    public function editPen(Request $request, $id)
    {

        $request->validate([
            "pen_id" => ['required', 'string', 'max:191'],
            "pen_location" => ['required', 'string', 'max:191'],
            "pen_size" => ['required', 'numeric', 'min:0'],
            "pen_capacity" => ['required', 'numeric', 'min:0'],
        ]);
        $pen = \App\PenHouse::where('pen_id', $id)->first();
        // change pen id if its a new id
        if ($pen->pen_id !== $request->pen_id) {
            $request->validate(["pen_id" => ['unique:pen_houses,pen_id']]);
            $pen->pen_id = $request->pen_id;
        }
        $pen->location = $request->pen_location;
        $pen->size = $request->pen_size;
        $pen->capacity = $request->pen_capacity;
        $pen->save();
        return redirect()->back()->with('success', 'Pen updated');
    }

    /**
     * Remove the pen resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletePen($id)
    {
        $pen = \App\PenHouse::where('pen_id', $id);
        $pen->delete();
        return redirect()->back()->with('success', "Pen $id deleted successfully");
    }

    public function eggProduction($type)
    {
        $birds = \App\Birds::select('batch_id', 'pen_id')
            ->where('bird_category', $type)->where('farm_id', auth()->user()->farm_id)->get();
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.egg_production', compact('birds'));
                break;

            case 'turkey':
                return view('admin.turkey.egg_production', compact('birds'));
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.egg_production', compact('birds'));
                break;
            default:
                return response()->view('errors.404');
        }
    }

    public function addEggProduction($type, Request $request)
    {
        //dd($request->all());
        $request->validate([
            "batch_id" => ['required', 'string', 'max:191'],
            "pen" => ['required', 'string', 'max:191'],
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

    /**
     * Update the mortality resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editEgg(Request $request, $id)
    {
        $request->validate([
            "_batch_id" => ['required', 'string', 'max:191'],
            "_pen" => ['required', 'string', 'max:191'],
            "_number" => ['required', 'numeric', 'min:0'],
            "_date" => ['required', 'date'],
            "_bad_eggs" => ['required', 'numeric', 'min:0'],
        ]);

        $egg = \App\EggProduction::find($id);
        if ($request->_pen != $egg->pen_id) {
            $request->validate(["_pen" => ['exists:pen_houses,pen_id']]);
            $egg->pen_id = $request->_pen;
        }
        if ($request->_batch_id != $egg->layer_batch_id) {
            $request->validate(["_batch_id" => ['exists:birds,batch_id']]);
            $egg->layer_batch_id = $request->_batch_id;
        }

        $egg->quantity = $request->_number;
        $egg->bad_eggs = $request->_bad_eggs;
        $egg->date_collected = new \DateTime($request->_date);
        $egg->save();
        return redirect()->back()->with('success', 'Record updated successfully');
    }

    /**
     * Remove the bird mortality resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEgg($id)
    {
        $mortality = \App\EggProduction::find($id);
        $mortality->delete();
        return redirect()->back()->with('success', "Record deleted successfully");
    }

    public function feed($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.feed');
                break;

            case 'turkey':
                return view('admin.turkey.feed');
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.feed');
                break;
            default:
                return response()->view('errors.404');
        }
    }

    public function addFeed(Request $request)
    {

        $request->validate([
            "name" => ['required', 'string', 'max:191'],
            "price" => ['required', 'numeric', 'min:0'],
            "quantity" => ['required', 'numeric', 'min:0'],
            "date" => ['required', 'date'],
            "supplier" => ['required', 'string', 'max:191'],
            "description" => ['required', 'string', 'max:191'],
            "feed_type" => ['required', 'string', 'max:191'],
        ]);
        \App\Feed::create([
            "farm_id" => auth()->user()->farm_id,
            "name" => $request->name,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "date" => new \DateTime($request->date),
            "description" => $request->description,
            "supplier" => $request->supplier,
            "feed_type" => $request->feed_type,
        ]);
        return redirect()->back()->with('success', 'Feed record added successfully');
    }

    /**
     * Update the mortality resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editFeed(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            "_name" => ['required', 'string', 'max:191'],
            "_price" => ['required', 'numeric', 'min:0'],
            "_quantity" => ['required', 'numeric', 'min:0'],
            "_date" => ['required', 'date'],
            "_supplier" => ['required', 'string', 'max:191'],
            "_description" => ['required', 'string', 'max:191'],
        ]);

        $feed = \App\Feed::find($id);
        $feed->name = $request->_name;
        $feed->price = $request->_price;
        $feed->quantity = $request->_quantity;
        $feed->supplier = $request->_supplier;
        $feed->name = $request->_name;
        $feed->date = new \DateTime($request->_date);
        $feed->save();
        return redirect()->back()->with('success', 'Record updated successfully');
    }

    /**
     * Remove the feed resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteFeed($id)
    {
        $feed = \App\Feed::find($id);
        $feed->delete();
        return redirect()->back()->with('success', "Record deleted successfully");
    }

    public function feeding($type)
    {
        $pen = \App\PenHouse::select('pen_id')->where('farm_id', auth()->user()->farm_id)
            ->where('bird_type', $type)->get();
        $feed = \App\Feed::select('name', 'id')->where('feed_type', $type)
            ->where('farm_id', auth()->user()->farm_id)->get();
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.feeding', compact('pen', 'feed'));
                break;

            case 'turkey':
                return view('admin.turkey.feeding', compact('pen', 'feed'));

                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.feeding', compact('pen', 'feed'));
                break;
            default:
                return response()->view('errors.404');
        }
    }

    public function addFeeding(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "feed_id" => ['required', 'string', 'max:191', 'not_in:-- select feed --'],
            "pen" => ['required', 'string', 'max:191', 'exists:pen_houses,pen_id', 'not_in:-- select pen --'],
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

    /**
     * Update the mortality resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editFeeding(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            // "_feed" => ['required','string','max:191'],
            // "f_id" => ['required','exists:feeds,id'],
            "_pen" => ['required', 'string', 'max:191', 'exists:pen_houses,pen_id'],
            "_feed_quantity" => ['required', 'numeric', 'min:0'],
            "_date" => ['required', 'date'],
            "_water_quantity" => ['required', 'numeric', 'min:0'],
        ]);

        // $feed = \App\Feed::find($request->f_id);
        $feeding = \App\Feeding::find($id);
        $feeding->pen_id = $request->_pen; //'exists:feeds,name',
        $feeding->water_quantity = $request->_water_quantity;
        $feeding->feed_quantity = $request->_feed_quantity;
        $feeding->date = new \DateTime($request->_date);
        $feeding->save();
        return redirect()->back()->with('success', 'Record updated successfully');
    }

    /**
     * Remove the feed resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteFeeding($id)
    {
        $feeding = \App\Feeding::find($id);
        $feeding->delete();
        return redirect()->back()->with('success', "Record deleted successfully");
    }

    public function medicine($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.medicine');
                break;

            case 'turkey':
                return view('admin.turkey.medicine');
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.medicine');
                break;
            default:
                return response()->view('errors.404');
        }
    }

    public function addMedicine(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name" => ['required', 'string', 'max:191'],
            "price" => ['required', 'numeric', 'min:0'],
            "quantity" => ['required', 'string', 'max:191'],
            "date" => ['required', 'date'],
            "supplier" => ['sometimes', 'string', 'nullable'],
            "description" => ['required', 'string', 'max:191'],
            "animal" => ["required", 'string'],
        ]);
        \App\Medicine::create([
            "farm_id" => auth()->user()->farm_id,
            "name" => $request->name,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "date" => new \DateTime($request->date),
            "supplier" => $request->supplier,
            "description" => $request->description,
            "animal" => $request->animal,
        ]);
        return redirect()->back()->with('success', 'Medicine added successfully');

    }

    /**
     * Update the medicine resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editMedicine(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            "_name" => ['required', 'string', 'max:191'],
            "_price" => ['required', 'numeric', 'min:0'],
            "_quantity" => ['required', 'numeric', 'min:0'],
            "_date" => ['required', 'date'],
            "_supplier" => ['required', 'string', 'max:191'],
            "_description" => ['required', 'string', 'max:191'],

        ]);

        $medicine = \App\Medicine::find($id);
        $medicine->name = $request->_name;
        $medicine->price = $request->_price;
        $medicine->quantity = $request->_quantity;
        $medicine->date = new \DateTime($request->_date);
        $medicine->supplier = $request->_supplier;
        $medicine->description = $request->_description;
        $medicine->save();
        return redirect()->back()->with('success', 'Record updated successfully');
    }

    /**
     * Remove the medicine resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMedicine($id)
    {
        $medicine = \App\Medicine::find($id);
        $medicine->delete();
        return redirect()->back()->with('success', "Record deleted successfully");
    }

    public function vaccine($type)
    {
        $pen = \App\PenHouse::select('pen_id')->where('farm_id', auth()->user()->farm_id)->get();

        switch ($type) {
            case 'chicken':
                return view('admin.chicken.vaccine');
                break;

            case 'turkey':
                return view('admin.turkey.vaccine');
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.vaccine');
                break;
            default:
                return response()->view('errors.404');
        }
    }

    public function addVaccine(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "age" => ['required', 'string', 'max:191'],
            "disease" => ['required', 'string', 'max:191'],
            "mode" => ['required', 'string', 'max:191'],
            "type" => ['required', 'string', 'max:191'],
            "animal" => ['required', 'string', 'max:191'],
        ]);
        \App\Vaccine::create([
            "farm_id" => auth()->user()->farm_id,
            "age" => $request->age,
            "disease" => $request->disease,
            "mode" => $request->mode,
            "type" => $request->type,
            "animal" => $request->animal,
        ]);
        return redirect()->back()->with('success', 'Vaccine record added successfully');

    }

    /**
     * Update the vaccine resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editVaccine(Request $request, $id)
    {
        $request->validate([
            "_age" => ['required', 'string', 'max:191'],
            "_disease" => ['required', 'string', 'max:191'],
            "_mode" => ['required', 'string', 'max:191'],
            "_type" => ['required', 'string', 'max:191'],
        ]);

        $vaccine = \App\Vaccine::find($id);
        $vaccine->age = $request->_age;
        $vaccine->disease = $request->_disease;
        $vaccine->mode = $request->_mode;
        $vaccine->type = $request->_type;
        $vaccine->save();
        return redirect()->back()->with('success', 'Record updated successfully');
    }

    /**
     * Remove the vaccine resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteVaccine($id)
    {
        $vaccine = \App\Vaccine::find($id);
        $vaccine->delete();
        return redirect()->back()->with('success', "Record deleted successfully");
    }

    public function birdSale($type)
    {
        $batch_id = \App\Birds::select('batch_id')->where('bird_category', $type)
            ->where('farm_id', auth()->user()->farm_id)->get();

        switch ($type) {
            case 'chicken':
                return view('admin.chicken.birdsale', compact('batch_id'));
                break;

            case 'turkey':
                return view('admin.turkey.birdsale', compact('batch_id'));
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.birdsale', compact('batch_id'));
                break;
            default:
                return response()->view('errors.404');
        }
    }

    public function addBirdSale($type, Request $request)
    {
        // dd($request->all());
        $request->validate([
            "batch_id" => ['required', 'string', 'max:191', 'not_in:--select batch id--', 'exists:birds,batch_id'],
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

    /**
     * Update the bird sale resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editBirdSale(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            "_batch_id" => ['required', 'string', 'max:191', 'exists:birds,batch_id'],
            "_weight" => ['required', 'numeric', 'min:0'],
            "_price" => ['required', 'numeric', 'min:0'],
            "_date" => ['required', 'date'],
            "_number" => ['required', 'numeric', 'min:0'],
        ]);

        $sale = \App\BirdSale::find($id);
        $sale->bird_batch_id = $request->_batch_id;
        $sale->price = $request->_price;
        $sale->weight = $request->_weight;
        $sale->date = new \DateTime($request->_date);
        $sale->number = $request->_number;
        $sale->save();
        return redirect()->back()->with('success', 'Record updated successfully');
    }

    /**
     * Remove the bird sale resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteBirdSale($id)
    {
        $sale = \App\BirdSale::find($id);
        $sale->delete();
        return redirect()->back()->with('success', "Record deleted successfully");
    }

    public function eggSale($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.eggsale');
                break;

            case 'turkey':
                return view('admin.turkey.eggsale');
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.eggsale');
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

    /**
     * Update the eggsale resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editEggSale(Request $request, $id)
    {
        
        $request->validate([
            "_weight" => ['required', 'numeric', 'min:0'],
            "_price" => ['required', 'numeric', 'min:0'],
            "_quantity" => ['required', 'numeric', 'min:0'],
            "_date" => ['required', 'date'],
        ]);

        $sale = \App\EggSale::find($id);
        $sale->weight_per_dozen = $request->_weight;
        $sale->price_per_dozen = $request->_price;
        $sale->quantity = $request->_quantity;
        $sale->date = new \DateTime($request->_date);
        $sale->save();
        return redirect()->back()->with('success', 'Record updated successfully');
    }

    /**
     * Remove the egg sale resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEggSale($id)
    {
        $sale = \App\EggSale::find($id);
        $sale->delete();
        return redirect()->back()->with('success', "Record deleted successfully");
    }

    public function meatSale($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.meatsale');
                break;

            case 'turkey':
                return view('admin.turkey.meatsale');
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.meatsale');
                break;
            default:
                return response()->view('errors.404');
        }
    }

    public function addMeatSale($type, Request $request)
    {
        // dd($request->all());
        $request->validate([
            "part" => ['required', 'string', 'max:191', 'not_in:--select--'],
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

    /**
     * Update the meat sale resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editMeatSale(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            "_part" => ['required', 'string', 'max:191',  'in:Back,Whole,Breast,Drumstick,Wings,Neck and back,Legs,Thigh,Gizzard'],
            "_price" => ['required', 'numeric', 'min:0'],
            "_quantity" => ['required', 'numeric', 'min:0'],
            "_date" => ['required', 'date'],
        ]);

        $sale = \App\MeatSale::find($id);
        $sale->part = $request->_part;
        $sale->price = $request->_price;
        $sale->quantity = $request->_quantity;
        $sale->date = new \DateTime($request->_date);
        $sale->save();
        return redirect()->back()->with('success', 'Record updated successfully');
    }

    /**
     * Remove the meat sale resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMeatSale($id)
    {
        $sale = \App\MeatSale::find($id);
        $sale->delete();
        return redirect()->back()->with('success', "Record deleted successfully");
    }

    public function equipment($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.equipment');
                break;

            case 'turkey':
                return view('admin.turkey.equipment');
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.equipment');
                break;
            default:
                return response()->view('errors.404');
        }
    }

    public function addEquipment(Request $request, string $type)
    {
        // dd($request->all());
        $request->validate([
            "name" => 'required|string',
            "date_acquired" => 'required|date',
            "price" => 'required|numeric|min:0',
            "supplier" => 'required|string',
            "type" => 'required|string',
            "status" => 'required|string',
            "description" => 'required|string',
        ]);

        \App\Equipment::create([
            "farm_id" => auth()->user()->farm_id,
            "equipment" => $request->name,
            "date_acquired" => new \DateTime($request->date_aquired),
            "price" => $request->price,
            "supplier" => $request->supplier,
            "type" => $request->type,
            "status" => $request->status,
            "description" => $request->description,
            "farm_category" => $type,
        ]);
        return redirect()->back()->with('success', 'Equipment added successfully');
    }

    /**
     * Update the equipment resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editEquipment(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            "_name" => 'required|string',
            "_date_acquired" => 'required|date',
            "_price" => 'required|numeric|min:0',
            "_supplier" => 'required|string',
            "_type" => 'required|string',
            "_status" => ['required','string',
            function ($attribute, $value, $fail) {
                if ( !in_array($value, ['Functioning', 'Maintenance', 'Non Functioning'])) {
                    $fail('state field muste be one of [Functioning, Maintenance, Non Functioning]');
                }
            }],
            "_description" => 'required|string',

        ]);

        $equipment = \App\Equipment::find($id);
        $equipment->equipment = $request->_name;
        $equipment->price = $request->_price;
        $equipment->status = $request->_status;
        $equipment->date_acquired = new \DateTime($request->_date_acquired);
        $equipment->supplier = $request->_supplier;
        $equipment->description = $request->_description;
        $equipment->type = $request->_type;
        $equipment->save();
        return redirect()->back()->with('success', 'Record updated successfully');
    }

    /**
     * Remove the equipment resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEquipment($id)
    {
        $equipment = \App\Equipment::find($id);
        $equipment->delete();
        return redirect()->back()->with('success', "Record deleted successfully");
    }

    public function employee($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.employee');
                break;

            case 'turkey':
                return view('admin.turkey.employee');
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.employee');
                break;
            default:
                return response()->view('errors.404');
        }

    }
    public function addemployee(Request $request, $type = null)
    {
        // dd($request->all());
        $request->validate([
            'id' => ['required', 'string', 'max:191', 'unique:employees,employee_id'],
            "full_name" => ['required', 'string', 'max:191'],
            "dob" => ['required', 'date'],
            "email" => ['required', 'email', 'unique:employees'],
            "hire_date" => ['required', 'date'],
            "contact" => ['required', 'phone:GH,fixed_line,mobile'],
            "photo" => ['sometimes', 'image', 'mimes:jpeg,bmp,png', 'nullable'],
            "jd" => ['sometimes', 'string', 'max:191', 'nullable'],
            "category" => ['string'],
        ]);

        \App\Employee::create([
            'employee_id' => $request->id,
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

    /**
     * Update the vaccine resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editEmployee(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            '_id' => ['required', 'string', 'max:191'],
            "_full_name" => ['required', 'string', 'max:191'],
            "_dob" => ['required', 'date'],
            "_email" => ['required', 'email',],
            "_hire_date" => ['required', 'date'],
            "_contact" => ['required', 'phone:GH,fixed_line,mobile'],
            // "_photo" => ['sometimes', 'image', 'mimes:jpeg,bmp,png', 'nullable'],
            "_jd" => ['sometimes', 'string', 'max:191', 'nullable'],
        ]);

        $employee = \App\Employee::find($id);
        // check if employee id is new
        if($employee->employee_id != $request->_id){
            $request->validate(['id' => ['unique:employees,employee_id']]);
            $employee->employee_id = $request->_id;
        }
        // check if email is new
        if($employee->email != $request->_email){
            $request->validate(["email" => ['unique:employees,email']]);
            $employee->email = $request->_email;
        }
        $employee->full_name = $request->_full_name;
        $employee->dob = new \DateTime($request->_dob);
        $employee->hire_date = new \DateTime($request->_hire_date);
        $employee->jd = $request->_jd;
        $employee->contact = $request->_contact;
        $employee->save();
        return redirect()->back()->with('success', 'Record updated successfully');
    }

    /**
     * Remove the vaccine resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEmployee($id)
    {
        $employee = \App\Employee::find($id);
        $employee->delete();
        return redirect()->back()->with('success', "Record deleted successfully");
    }

/**
 * Edit admin detials
 * @var Request $request
 * @return response
 */
    public function editProfile(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "full_name" => ['required', 'string', 'max:191', 'max:255'],
            'email' => ['required', 'string', 'max:191', 'email', 'max:255'],
            "contact" => ['required', 'phone:GH,fixed_line,mobile'],
            // "role" =>['required', 'string','max:191', 'max:255'],
            // 'password' => ['required', 'string','max:191', 'min:8', 'confirmed'],
        ], ['contact.phone' => 'The contact number is invalid']);
        $user = auth()->user();
        $user->full_name = $request->full_name;
        //check to see email is a new email
        if ($user->email != $request->email) {
            $request->validate(["email" => ['unique:farm_admins']]);
            $user->email = $request->email;
        }
        $user->contact = $request->contact;
        $user->save();
        return redirect()->back()->with('success', 'Account edited successfully');
    }

    /**
     * Display view to add users
     * @var string $view
     * @return view
     */
    public function users($view)
    {
        switch ($view) {
            case 'chicken':
                return view('admin.chicken.users');
                break;

            case 'turkey':
                return view('admin.turkey.users');
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.users');
                break;
            default:
                return response()->view('errors.404');
        }

    }

    /**
     * Add a new admin user
     * @param Request $request
     * @return response
     */
    public function addUser(Request $request)
    {
        $request->validate([
            "full_name" => ['required', 'string', 'max:191', 'max:255'],
            'email' => ['required', 'string', 'max:191', 'email', 'max:255', 'unique:farm_admins'],
            "contact" => ['required', 'phone:GH,fixed_line,mobile'],
            "role" => ['required', 'string', 'max:191', 'max:15'],
        ]);
        $farm = \App\Farm::find(auth()->user()->farm_id);
        $user = \App\FarmAdmin::create([
            "farm_id" => $farm->id, //auth()->user()->farm_id,
            "full_name" => $request->full_name,
            "email" => $request->email,
            "contact" => $request->contact,
            "role" => $request->role,
        ]);
        $user->notify(new \App\Notifications\NewUserNotification(route('farm.manager.password.request'), $farm->farm_name));
        return redirect()->back()->with('success', 'User added successfully. Email sent to user to create password');

    }

   

    /**
     * Remove the vaccine resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($id)
    {
        if($id == auth()->user()->id){
            return redirect()->back()->with('error', "You cannot delete your adminstrative account!");
        }
        $admin = \App\FarmAdmin::find($id);
        $admin->delete();
        return redirect()->back()->with('success', "Record deleted successfully");
    }

    /**
     * Display report view
     * @param string $type
     * @return view
     */

    public function allSales($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.sales');
                break;
            case 'turkey':
                return view('admin.turkey.sales');
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.sales');
                break;
            default:
                return response()->view('errors.404');
                break;
        }

    }

    public function transaction($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.transaction');
                break;
            case 'turkey':
                return view('admin.turkey.transaction');
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.transaction');
                break;
            default:
                return response()->view('errors.404');
                break;
        }
    }

    public function addTransaction(Request $request, $type = null)
    {
        $request->validate([
            "type" => 'required|string',
            "date" => 'required|date',
            "amount" => 'required|numeric|min:0',
            "category" => 'required|string',
            "account" => 'required|string',
            "description" => 'required|string',
            "farm_category" => 'required|string',
        ]);

        \App\Transaction::create([
            "farm_id" => auth()->user()->farm_id,
            "type" => $request->type,
            "date" => new \DateTime($request->date),
            "amount" => $request->amount,
            "category" => $request->category,
            "account" => $request->account,
            "description" => $request->description,
            "farm_category" => $request->farm_category,
        ]);
        return redirect()->back()->with('success', 'Transaction added succesfully');
    }

    /**
     * Update the vaccine resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editTransaction(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
             "_type" => 'required|string',
            "_date" => 'required|date',
            "_amount" => 'required|numeric|min:0',
            "_category" => 'required|string',
            "_account" => 'required|string',
            "_description" => 'required|string',
        ]);

        $transaction = \App\Transaction::find($id);
        $transaction->type = $request->_type;
        $transaction->amount = $request->_amount;
        $transaction->category = $request->_category;
        $transaction->date = new \DateTime($request->_date);
        $transaction->account = $request->_account;
        $transaction->description = $request->_description;
        $transaction->save();
        return redirect()->back()->with('success', 'Record updated successfully');
    }

    /**
     * Remove the transaction resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteTransaction($id)
    {
        $transaction = \App\Transaction::find($id);
        $transaction->delete();
        return redirect()->back()->with('success', "Record deleted successfully");
    }

    public function statement($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.chicken.statement');
                break;
            case 'turkey':
                return view('admin.turkey.statement');
                break;
            case 'guinea_fowl':
                return view('admin.guineafowl.statement');
                break;
            default:
                return response()->view('errors.404');
                break;
        }
    }
}
