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
        $admin = \App\FarmAdmin::where('farm_id',$this->id)->where('role','SUPER_ADMIN')->first();
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

}
