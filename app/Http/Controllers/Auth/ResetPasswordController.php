<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.

        $response = $this->resetsetPwd($request);
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
        ? $this->sendResetResponse($request, $response)
        : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('managers');
    }

    /**
     * Chect to if token has expired
     * @param string $token
     * @return bool
     */
    public function tokenExpired($token)
    {
        $tokenTime = DB::table('password_resets')
            ->where('token', $token)->pluck('created_at')->first();
        $now = Carbon::now();
        $diff = $now->diffInMinutes(Carbon::parse($tokenTime));
        if ($diff > 1) {
            return true;
        }
        return false;
    }

    /**
     * Attempt to Reset password and return appropriate response
     * @param Illuminate\Http\Request $request
     * @return string
     */
    public function resetsetPwd($request)
    {
        //if token has expired delete it and send invalid token response
        if ($this->tokenExpired($request->token)) {
            $this->deleteExpiredToken($request->token);
            return Password::INVALID_TOKEN;
        }
        //Get user and reset password
        $user = \App\FarmAdmin::where('email', $request->email)->first();
        $this->resetPassword($user, $request->password);

        // Delete token and return password reset response
        $this->deleteExpiredToken($request->token);
        return Password::PASSWORD_RESET;
    }

    /**
     * Delete given token
     * @param string $token
     * @return void
     */
    public function deleteExpiredToken($token)
    {
        $token = DB::table('password_resets')->where('token', $token)->delete();
    }

    /**
     * Reset the password for given request credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function resetPassword($request)
    {
        $user = \App\FarmAdmin::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
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
