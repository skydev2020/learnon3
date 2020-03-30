<?php

namespace App\Providers;
use App\Setting;

use Config;
use Illuminate\Support\Facades\DB;
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
        if (\Schema::hasTable('settings')) {
            $mail = DB::table('settings');
            if ($mail) //checking if table is not empty
            {
                $config = Array(
                    'driver'     => DB::table('settings')->where('key', 'config_mail_protocol')->first()->value,
                    'host'       => DB::table('settings')->where('key', 'config_smtp_host')->first()->value,
                    'port'       => DB::table('settings')->where('key', 'config_smtp_port')->first()->value,
                    'from'       => array('address' => DB::table('settings')->where('key', 'config_email')->first()->value
                    , 'name' => DB::table('settings')->where('key', 'config_name')->first()->value),
                    'encryption' => "ssl",
                    'username'   => DB::table('settings')->where('key', 'config_smtp_username')->first()->value,
                    'password'   => DB::table('settings')->where('key', 'config_smtp_password')->first()->value,
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $config);
            }
        }
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
