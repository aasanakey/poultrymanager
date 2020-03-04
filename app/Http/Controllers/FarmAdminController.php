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
    }

    public function dashboard()
    {
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
                return view();
                break;
            case 'guinea_fowl':
                return view();
                break;
        }
    }

    public function birdType($type)
    {
        switch ($type) {
            case 'chicken':
                return redirect()->route('admin.home',$type);
                break;

            case 'turkey':
                return redirect()->route('admin.home',$type);
                break;
            case 'guinea_fowl':
                return redirect()->route('admin.home',$type);
                break;
        }
    }

    /**
     * Get bird population
     */
    public function population($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.population');
                break;

            case 'turkey':
                return view();
                break;
            case 'guinea_fowl':
                return view();
                break;
        }
    }
}
