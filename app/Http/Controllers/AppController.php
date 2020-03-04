<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;


class AppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('signed')->only('verifyCredentialSent');
        $this->middleware('throttle:6,1')->only('verifyCredentialSent', 'resendCredentialLink');
    }

    /**
     * Show the application farm registeration.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showFarmRegisterForm()
    {
        return view('auth.register');
    }

     /**
     * Register farm save farm detials.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function farmRegister(Request $request)
    {
        $request->validate([
            "farm_name" => ['required', 'string','max:255',"uniqueFarmNameAndFarmEmail:{$request->farm_email}"],
            "farm_email" => ['required', 'string', 'email', 'max:255', ''],
            "farm_contact" => ['required','phone:GH,fixed_line,mobile'],
            "farm_location" => ['required', 'string', 'max:255'],
            "farm_manager" => ['required', 'string', 'max:255'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $farm = new \App\Farm();
        $farm->farm_name = $request->farm_name;
        $farm->farm_email = $request->farm_email;
        $farm->farm_contact = $request->farm_contact;
        $farm->farm_location = $request->farm_location;
        $farm->farm_manager = $request->farm_manager;
            // 'password' => $request->farm_password
        if($farm->save()){
            $farm->sendCreateLoginCredentialsNotification('farm.credential.create');
            // return redirect()->route('login');
            $msg = 'Farm has been registered,check your mail for login credentials. If you did not receive the email, <a href="'
            .route('farm.credential.resend') . '"> click here to request another </a>';
            return back()->with('success',$msg);
        }
    }

        /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verifyCredentialSent(Request $request)
    {
        if ($request->route('id') != $request->user()->getKey()) {
            throw new AuthorizationException;
        }

        if ( !$request->user()->hasCredentials()) {
            return $request->user()->sendCreateLoginCredentialsNotification('farm.credential.create');
        }

        return redirect()->route('login');
    }
    /**
     * Resend link for creating login credentials
     */
    public function resendCredentialLink( Request $request)
    {
        if ($request->user()->hasCredentials()) {
            return redirect()->route('login');
        }

        $request->user()->sendCreateLoginCredentialsNotification('farm.credential.create');

        return back()->with('resent', 'A mail with new login credentials has been sent to your mail');
        //return back();
    }

    public function createCredentials(Request $request)
    {
        $id = $request->route('id');

        return view('auth.create_credentials',compact('id'));
    }
}
