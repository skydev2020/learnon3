<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use App\Country;
use App\Language;
use App\Currency;
use App\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::allFiles('C:\xampp\htdocs\learnon3\app\Http\Controllers');

        $filepaths = Array();
        foreach ($files as $file)
        {
            $filename = pathinfo($file)['filename'];
            $string = pathinfo($file)['dirname'];
            $directoryname = str_replace("C:\xampp\htdocs\learnon3\app\Http\Controllers", '', $string);
            $filepaths[] = $directoryname . $filename;
        }

        $data = [
            'config_name'         => Setting::where('key', 'config_name')->first()['value'],
            'config_url'         => Setting::where('key', 'config_url')->first()['value'],
            'config_owner'         => Setting::where('key', 'config_owner')->first()['value'],
            'config_address'         => Setting::where('key', 'config_address')->first()['value'],
            'config_email'         => Setting::where('key', 'config_email')->first()['value'],
            'config_email2'         => Setting::where('key', 'config_email2')->first()['value'],
            'config_email3'         => Setting::where('key', 'config_email3')->first()['value'],
            'config_masterpassword'         => Setting::where('key', 'config_masterpassword')->first()['value'],
            'config_telephone'         => Setting::where('key', 'config_telephone')->first()['value'],
            'config_fax'         => Setting::where('key', 'config_fax')->first()['value'],
            'config_minimum_bill'         => Setting::where('key', 'config_minimum_bill')->first()['value'],
            'config_title'         => Setting::where('key', 'config_title')->first()['value'],
            'config_meta_description'         => Setting::where('key', 'config_meta_description')->first()['value'],
            'config_description_1'         => Setting::where('key', 'config_description_1')->first()['value'],
            'wage_usa'         => Setting::where('key', 'wage_usa')->first()['value'],
            'wage_canada'         => Setting::where('key', 'wage_canada')->first()['value'],
            'wage_alberta'         => Setting::where('key', 'wage_alberta')->first()['value'],
            'invoice_usa'         => Setting::where('key', 'invoice_usa')->first()['value'],
            'invoice_canada'         => Setting::where('key', 'invoice_canada')->first()['value'],
            'invoice_alberta'         => Setting::where('key', 'invoice_alberta')->first()['value'],
            'config_country_id'         => Setting::where('key', 'config_country_id')->first()['value'],
            'config_admin_language'         => Setting::where('key', 'config_admin_language')->first()['value'],
            'config_currency'         => Setting::where('key', 'config_currency')->first()['value'],
            'config_currency_auto'         => Setting::where('key', 'config_currency_auto')->first()['value'],
            'config_admin_limit'         => Setting::where('key', 'config_admin_limit')->first()['value'],
            'config_invoice_prefix'         => Setting::where('key', 'config_invoice_prefix')->first()['value'],
            'config_invoice_no'         => Setting::where('key', 'config_invoice_no')->first()['value'],
            'config_order_status_id'         => Setting::where('key', 'config_order_status_id')->first()['value'],
            'config_customer_approval'         => Setting::where('key', 'config_customer_approval')->first()['value'],
            'config_mail_protocol'         => Setting::where('key', 'config_mail_protocol')->first()['value'],
            'config_mail_parameter'         => Setting::where('key', 'config_mail_parameter')->first()['value'],
            'config_smtp_host'         => Setting::where('key', 'config_smtp_host')->first()['value'],
            'config_smtp_username'         => Setting::where('key', 'config_smtp_username')->first()['value'],
            'config_smtp_password'         => Setting::where('key', 'config_smtp_password')->first()['value'],
            'config_smtp_port'         => Setting::where('key', 'config_smtp_port')->first()['value'],
            'config_smtp_timeout'         => Setting::where('key', 'config_smtp_timeout')->first()['value'],
            'config_alert_mail'         => Setting::where('key', 'config_alert_mail')->first()['value'],
            'config_account_mail'         => Setting::where('key', 'config_account_mail')->first()['value'],
            'config_alert_emails'         => Setting::where('key', 'config_alert_emails')->first()['value'],
            
            'config_ssl'                => Setting::where('key', 'config_ssl')->first()['value'],
            'config_maintenance'         => Setting::where('key', 'config_maintenance')->first()['value'],
            'config_encryption'         => Setting::where('key', 'config_encryption')->first()['value'],
            'config_seo_url'         => Setting::where('key', 'config_seo_url')->first()['value'],
            'config_compression'         => Setting::where('key', 'config_compression')->first()['value'],
            'config_error_display'                => Setting::where('key', 'config_error_display')->first()['value'],
            'config_error_log'         => Setting::where('key', 'config_error_log')->first()['value'],
            'config_error_filename'         => Setting::where('key', 'config_error_filename')->first()['value'],
            
            'countries'                 => Country::all(),
            'languages'                 => Language::all(),
            'currencies'                => Currency::all(),
            'statuses'                  => OrderStatus::all(),
            'filepaths'                 => $filepaths
        ];

        return view('admin.settings.index') -> with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
