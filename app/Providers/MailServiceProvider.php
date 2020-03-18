<?php

namespace App\Providers;
use App\Setting;

use Config;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $config = array(
            'driver'     => Setting::where('key', 'config_mail_protocol')->first()['value'],
            'host'       => Setting::where('key', 'config_smtp_host')->first()['value'],
            'port'       => Setting::where('key', 'config_smtp_port')->first()['value'],
            'from'       => array('address' => Setting::where('key', 'config_email')->first()['value']
                                , 'name' => Setting::where('key', 'config_name')->first()['value']),
            'encryption' => "ssl",
            'username'   => Setting::where('key', 'config_smtp_username')->first()['value'],
            'password'   => Setting::where('key', 'config_smtp_password')->first()['value'],
            'sendmail'   => '/usr/sbin/sendmail -bs',
            'pretend'    => false,
        );
        dd($config);
        Config::set('mail', $config);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
