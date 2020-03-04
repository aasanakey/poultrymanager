<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('uniqueFarmNameAndFarmEmail', function ($attribute, $value, $parameters, $validator) {
            $count = DB::table('farms')->where('farm_name', $value)
                                        ->where('farm_email', $parameters[0])
                                        ->count();

            return $count === 0;
        },"The :attribute is associated with the email :email");

        Validator::replacer('uniqueFarmNameAndFarmEmail', function($message, $attribute, $rule, $parameters){
            return   str_replace(':email', $parameters[0], $message);
        });
    }


}
