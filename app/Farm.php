<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Farm extends Model
{
    use Notifiable;
/**
 * Send the email to create login credentials notification.
 *@param string $url
 * @return void
 */
    public function sendCreateLoginCredentialsNotification($url)
    {
        return $this->notify(new \App\Notifications\NewFarmNotification($url));
    }

    /**
     * Check whether farm has admin credentials created
     * @return bool true|false
     */
    public function hasCredentials()
    {
        $admin = \App\FarmAdmin::where('farm_id', $this->id)->where('role', 'SUPER_ADMIN')->first();
        return $admin && count($admin) > 0;
    }

    /**
     *  Get the email address to use for sending email
     * @return string $this->farm_email
     */
    public function routeNotificationForMail()
    {
        return $this->farm_email;
    }

    /**
     * Get the admin for the farm.
     */
    public function admin()
    {
        return $this->hasMany('App\FarmAdmin', 'farm_id');
    }

    /**
     * Get the pen for the farm.
     */
    public function pen()
    {
        return $this->hasMany('App\PenHouse', 'farm_id');
    }
    /**
     * Get the birds for the farm.
     */
    public function birds()
    {
        return $this->hasMany('App\Birds', 'farm_id');
    }
    /**
     * Get the mortality for the farm.
     */
    public function mortality()
    {
        return $this->hasMany('App\BirdMortality', 'farm_id');
    }

    /**
     * Get the birdsale for the farm.
     */
    public function bird_sale()
    {
        return $this->hasMany('App\BirdSale', 'farm_id');
    }

    /**
     * Get the egg sale for the farm.
     */
    public function egg_sale()
    {
        return $this->hasMany('App\EggSale', 'farm_id');
    }

    /**
     * Get the meat sale for the farm.
     */
    public function meat_sale()
    {
        return $this->hasMany('App\MeatSale', 'farm_id');
    }

    /**
     * Get the feed for the farm.
     */
    public function feed()
    {
        return $this->hasMany('App\Feed', 'farm_id');
    }

    /**
     * Get the mortality for the farm.
     */
    public function feeding()
    {
        return $this->hasMany('App\Feeding', 'farm_id');
    }

    /**
     * Get the medicine for the farm.
     */
    public function medicine()
    {
        return $this->hasMany('App\Medicine', 'farm_id');
    }

    /**
     * Get the vaccine for the farm.
     */
    public function vaccine()
    {
        return $this->hasMany('App\Vaccine', 'farm_id');
    }

    /**
     * Get the transactions for the farm.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'farm_id');
    }

    /**
     * Get the employees for the farm.
     */
    public function employee()
    {
        return $this->hasMany('App\Employee', 'farm_id');
    }

    /**
     * Get the equipment for the farm.
     */
    public function equipment()
    {
        return $this->hasMany('App\Equipment', 'farm_id');
    }

    /**
     * Get the eggs collected for the farm.
     */
    public function eggs()
    {
        return $this->hasMany('App\EggProduction', 'farm_id');
    }
}