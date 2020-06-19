<?php

namespace App\Http\Controllers\Auth;

use App\FarmAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FarmManagerRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:managers');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            "farm_name" => ['required', 'string', 'max:191', "uniqueFarmNameAndFarmEmail:{$data['farm_email']}"],
            "farm_email" => ['required', 'string', 'email', 'max:191'],
            "farm_contact" => ['required', 'phone:GH,fixed_line,mobile'],
            "farm_location" => ['required', 'string', 'max:191'],
            "farm_manager" => ['required', 'string', 'max:191'],
            'farm_manager_email' => ['required', 'string', 'email', 'max:191', 'unique:farm_admins'],
            "farm_manager_contact" => ['sometimes', 'phone:GH,fixed_line,mobile', 'nullable'],
            "farm_admin_role" => ['required', 'string', 'max:191'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], ["farm_contact.phone" => "The phone number is invalid", "farm_manager_contact.phone" => "The phone number is invalid"]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\FarmAdmin
     */
    protected function create(array $data)
    {
        $farm = new \App\Farm();
        $farm->farm_name = $data['farm_name'];
        $farm->farm_email = $data['farm_email'];
        $farm->farm_contact = $data['farm_contact'];
        $farm->farm_location = $data['farm_location'];
        $farm->farm_manager = $data['farm_manager'];
        $farm->save();
        $contact = $data['farm_manager_contact'] ?? $farm->farm_contact;
        return FarmAdmin::create([
            "farm_id" => $farm->id,
            "full_name" => $data['farm_manager'],
            'email' => $data['farm_manager_email'],
            "contact" => $contact,
            "role" => $data['farm_admin_role'],
            'password' => Hash::make($data['password']),
            "email_verified_at" => \now(),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('managers');
    }
}