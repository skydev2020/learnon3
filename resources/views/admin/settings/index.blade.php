@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-cogs" aria-hidden="true" style = "font-size:24px"> Settings</i>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.store') }}">
                        @csrf
                        {{method_field('POST')}}
                        <div class="form-group row mb-0">
                            <div class="col-1 offset-10">
                                <button type = "submit" class="btn btn-primary" >Save</button>
                            </div>

                            <div class="col-1">
                                <a href = "{{ route('admin.settings.index') }}">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>

                        <ul class = "nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab_general">General</a></li>
                            <li><a data-toggle="tab" href="#tab_website">Website</a></li>
                            <li><a data-toggle="tab" href="#tab_default_wage">Default Wages</a></li>
                            <li><a data-toggle="tab" href="#tab_local">Local</a></li>
                            <li><a data-toggle="tab" href="#tab_option">Option</a></li>
                            <li><a data-toggle="tab" href="#tab_mail">Mail</a></li>
                            <li><a data-toggle="tab" href="#tab_server">Server</a></li>
                        </ul>

                        <div class = "tab-content">
                            <div id = "tab_general" class = "tab-pane fade">
                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_name">Site Name:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_name" id = "config_name"
                                        class = "form-control" value = "{{$data['config_name']}}">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-3 ">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_url">Site URL:</label>
                                        <span class="d-flex justify-content-end">Include the full URL to your store. Make sure to add '/' at the end. Example: http://www.yourdomain.com/path/</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_url" id = "config_url"
                                        class = "form-control" value = "{{$data['config_url']}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_owner">Site Owner:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_owner" id = "config_owner"
                                        class = "form-control" value = "{{$data['config_owner']}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_address">Address:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_address" id = "config_address"
                                        class = "form-control" value = "{{$data['config_address']}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_email">E-Mail:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_email" id = "config_email"
                                        class = "form-control" value = "{{$data['config_email']}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_email2">From E-Mail for Tutors:</label>
                                        <span class="d-flex justify-content-end">This email address will be used as from email when automatic email is sent to tutor registration.</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_email2" id = "config_email2"
                                        class = "form-control" value = "{{$data['config_email2']}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_email3">From E-Mail for Billing:</label>
                                        <span class="d-flex justify-content-end">This email address will be used as from email when email is sent to student for invoice.</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_email3" id = "config_email3"
                                        class = "form-control" value = "{{$data['config_email3']}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_telephone">Telephone:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_telephone" id = "config_telephone"
                                        class = "form-control" value = "{{$data['config_telephone']}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_fax">Fax:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_fax" id = "config_fax"
                                        class = "form-control" value = "{{$data['config_fax']}}">
                                    </div>
                                </div>
                            </div>

                            <div id = "tab_website" class = "tab-pane fade in active">
                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_title" >Title:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_title" id = "config_title"
                                        class = "form-control" value = "{{$data['config_title']}}"
                                        autocomplete="config_title" autofocus>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_meta_description" >Meta Tag Description:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_meta_description" id = "config_meta_description"
                                        class = "form-control" value = "{{$data['config_meta_description']}}"
                                        autocomplete="config_meta_description" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="config_description_1" class="col-form-label font-weight-bold">{{ __('Template:') }}</label>
                                    </div>
                                    <div class="col-8 d-flex align-items-center">
                                        <textarea id="config_description_1" class="form-control inputstl"
                                        name="config_description_1" required autocomplete="config_description_1" autofocus>
                                        <?php echo html_entity_decode($data['config_description_1']);?>
                                    </textarea>
                                    </div>
                                </div>
                            </div>

                            
                            <div id = "tab_default_wage" class = "tab-pane fade in active">
                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_minimum_bill" >Process Minimum Bill</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <label class="radio-inline d-flex align-items-center">
                                            <input type="radio" name="config_minimum_bill" value="1" id="config_minimum_bill"
                                            <?=$data['config_minimum_bill']=="1"?"checked":""?> >&nbsp;Yes
                                        </label>&nbsp;&nbsp;
                                        <label class="radio-inline d-flex align-items-center">
                                            <input type="radio" name="config_minimum_bill" value="0" id="config_minimum_bill"
                                            <?=$data['config_minimum_bill']=="0"?"checked":""?> >&nbsp;No
                                        </label>&nbsp;&nbsp;
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <h4>&nbsp; Tutor Pay Rate </h4>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "wage_usa" >Pay rate for United States</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "wage_usa" id = "wage_usa"
                                        class = "form-control" value = "{{$data['wage_usa']}}"
                                        autocomplete="wage_usa" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "wage_canada" >Pay rate for Canada</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "wage_canada" id = "wage_canada"
                                        class = "form-control" value = "{{$data['wage_canada']}}"
                                        autocomplete="wage_canada" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "wage_alberta" >Pay rate for Alberta</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "wage_alberta" id = "wage_alberta"
                                        class = "form-control" value = "{{$data['wage_alberta']}}"
                                        autocomplete="wage_alberta" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <h4>&nbsp; Student Invoice Rate </h4>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "invoice_usa" >Invoice rate for United States</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "invoice_usa" id = "invoice_usa"
                                        class = "form-control" value = "{{$data['invoice_usa']}}"
                                        autocomplete="invoice_usa" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "invoice_canada" >Invoice rate for Canada</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "invoice_canada" id = "invoice_canada"
                                        class = "form-control" value = "{{$data['invoice_canada']}}"
                                        autocomplete="invoice_canada" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "invoice_alberta" >Invoice rate for Alberta</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "invoice_alberta" id = "invoice_alberta"
                                        class = "form-control" value = "{{$data['invoice_alberta']}}"
                                        autocomplete="invoice_alberta" autofocus>
                                    </div>
                                </div>
                            </div>

                            <div id = "tab_local" class = "tab-pane fade in active">
                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_country_id" >Country:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <select name = "config_country_id" id = "config_country_id">
                                            @foreach ($data['countries'] as $country)
                                                <option value = "{{$country->id}}"
                                                    <?= $country->id == $data['config_country_id']?"selected":"" ?>>
                                                {{ $country->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3 d-flex">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_admin_language" >Administration Language</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <select name = "config_admin_language" id = "config_admin_language">
                                            @foreach ($data['languages'] as $language)
                                                <option value = "{{$language->code}}"
                                                    <?= $language->code == $data['config_admin_language']?"selected":"" ?>>
                                                {{ $language->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_currency" >Currency:</label>
                                        <span class="d-flex justify-content-end">Change the default currency. Clear your browser cache to see the change and reset your existing cookie.</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <select name = "config_currency" id = "config_currency">
                                            @foreach ($data['currencies'] as $currency)
                                                <option value = "{{$currency->code}}"
                                                    <?= $currency->code == $data['config_currency']?"selected":"" ?>>
                                                {{ $currency->title }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_currency_auto" >Auto Update Currency:</label>
                                        <span class="d-flex justify-content-end">Set your store to automatically update currencies daily.</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <label class = "radio-inline">
                                            <input type = "radio" name = "config_currency_auto" id = "config_currency_auto"
                                                value = "1" <?=$data['config_currency_auto']=="1"?"checked":""?>
                                        >&nbsp; Yes &nbsp;
                                        </label>&nbsp;&nbsp;
                                        <label class = "radio-inline">
                                            <input type = "radio" name = "config_currency_auto" id = "config_currency_auto"
                                                value = "0" <?=$data['config_currency_auto']!="1"?"checked":""?>
                                        >&nbsp; No &nbsp;
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id = "tab_option" class = "tab-pane fade in active">
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_masterpassword" >Master Password</label>
                                        <span class="d-flex justify-content-end">This password will be used as master key when login to any account.</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_masterpassword" id = "config_masterpassword"
                                        class = "form-control" value = "{{$data['config_masterpassword']}}"
                                        autocomplete="config_masterpassword" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_admin_limit" >Default Items Per Page(Admin)</label>
                                        <span class="d-flex justify-content-end">Determines how many admin items are shown per page (orders, customers, etc)</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_admin_limit" id = "config_admin_limit"
                                        class = "form-control" value = "{{$data['config_admin_limit']}}"
                                        autocomplete="config_admin_limit" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_invoice_prefix" >Invoice Prefix</label>
                                        <span class="d-flex justify-content-end">Set the invoice prefix (e.g. INV-2011-00). Invoice ID's will start at 1 for each unique prefix.</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_invoice_prefix" id = "config_invoice_prefix"
                                        class = "form-control" value = "{{$data['config_invoice_prefix']}}"
                                        autocomplete="config_invoice_prefix" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_invoice_no" >Invoice Number</label>
                                        <span class="d-flex justify-content-end">Set the invoice number. Invoice ID's will start from this number.</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_invoice_no" id = "config_invoice_no"
                                        class = "form-control" value = "{{$data['config_invoice_no']}}"
                                        autocomplete="config_invoice_no" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "invoice_canada" >Order Status</label>
                                        <span class="d-flex justify-content-end">Set the default order status when an order is processed.</span>
                                    </div>

                                    <div class="col-2 d-flex align-items-center">
                                        <select id = "config_order_status_id" name = "config_order_status_id"
                                        class = "form-control">
                                            @foreach ($data['statuses'] as $status)
                                                <option <?= $status->id==$data['config_order_status_id']?"selected":"" ?>
                                                value = "{{ $status->id }}"> {{ $status->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_minimum_bill" >Approve New Customers:</label>
                                        <span class="d-flex justify-content-end">Don't allow new customer to login until their account has been approved.</span>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <label class = "radio-inline">
                                            <input type = "radio" name = "config_customer_approval" id = "config_customer_approval"
                                                value = "1" <?=$data['config_customer_approval'] == "1" ? "checked":"" ?>
                                                >&nbsp; Yes &nbsp;
                                        </label>&nbsp; &nbsp;
                                        <label class = "radio-inline">
                                            <input type = "radio" name = "config_customer_approval" id = "config_customer_approval"
                                                value = "0" <?= $data['config_customer_approval'] != "1" ? "checked" : "" ?>
                                                >&nbsp; No &nbsp;
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id = "tab_mail" class = "tab-pane fade in active">
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_mail_protocol" >Mail Protocol</label>
                                        <span class="d-flex justify-content-end">Only choose 'Mail' unless your host has disabled the php mail function.</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <select name = "config_mail_protocol" id = "config_mail_protocol"
                                        class = "form-control" value = "{{$data['config_mail_protocol']}}">
                                            <option <?=$data['config_mail_protocol']=="Mail"?"checked":""?>>Mail</option>
                                            <option <?=$data['config_mail_protocol']=="SMTP"?"checked":""?>>SMTP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_mail_parameter" >Mail Parameters:</label>
                                        <span class="d-flex justify-content-end">When using 'Mail', additional mail parameters can be added here (e.g. "-femail@storeaddress.com".</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_mail_parameter" id = "config_mail_parameter"
                                        class = "form-control" value = "{{$data['config_mail_parameter']}}"
                                        autocomplete="config_mail_parameter" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_smtp_host" >SMTP Host:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_smtp_host" id = "config_smtp_host"
                                        class = "form-control" value = "{{$data['config_smtp_host']}}"
                                        autocomplete="config_smtp_host" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_smtp_username" >SMTP Username:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_smtp_username" id = "config_smtp_username"
                                        class = "form-control" value = "{{$data['config_smtp_username']}}"
                                        autocomplete="config_smtp_username" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_smtp_password" >SMTP Password:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_smtp_password" id = "config_smtp_password"
                                        class = "form-control" value = "{{$data['config_smtp_password']}}"
                                        autocomplete="config_smtp_password" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_smtp_port" >SMTP Port:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_smtp_port" id = "config_smtp_port"
                                        class = "form-control" value = "{{$data['config_smtp_port']}}"
                                        autocomplete="config_smtp_port" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_smtp_timeout" >SMTP Timeout:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_smtp_timeout" id = "config_smtp_timeout"
                                        class = "form-control" value = "{{$data['config_smtp_timeout']}}"
                                        autocomplete="config_smtp_timeout" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_alert_mail" >New Order Alert Mail:</label>
                                        <span class="d-flex justify-content-end">Send a email to the store owner when a new order is created.</span>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <label class = "radio-inline">
                                            <input type = "radio" name = "config_alert_mail" id = "config_alert_mail"
                                             value = "1" <?=$data['config_alert_mail']=="1"?"checked":""?>>&nbsp; Yes &nbsp;
                                        </label>&nbsp; &nbsp;
                                        <label class = "radio-inline">
                                            <input type = "radio" name = "config_alert_mail" id = "config_alert_mail"
                                            value = "0" <?=$data['config_alert_mail']=="0"?"checked":""?>>&nbsp; No &nbsp;
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_account_mail" >New Account Alert Mail:</label>
                                        <span class="d-flex justify-content-end">Send a email to the store owner when a new account is registered.</span>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <label class="radio-inline">
                                            <input type = "radio" name = "config_account_mail" id = "config_account_mail"
                                             value = "1" <?=$data['config_account_mail']=="1"?"checked":""?>>&nbsp; Yes &nbsp;
                                        </label>&nbsp; &nbsp;
                                        <label class="radio-inline">
                                            <input type = "radio" name = "config_account_mail" id = "config_account_mail"
                                             value = "0" <?=$data['config_account_mail']=="0"?"checked":""?>>&nbsp; No &nbsp;
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_alert_emails" >Additional Alert E-Mails:</label>
                                        <span class="d-flex justify-content-end">Any additional emails you want to receive the alert email, in addition to the main store email. (comma separated)</span>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <textarea name = "config_alert_emails" id = "config_alert_emails"
                                        class = "form-control input-stl"> {{$data['config_alert_emails']}} </textarea>
                                    </div>
                                </div>
                            </div>

                            <div id = "tab_server" class = "tab-pane fade in active">
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_ssl" >Use SSL</label>
                                        <span class="d-flex justify-content-end">To use SSL check with your host if a SSL certificate is installed and added the SSL URL to the admin config file.</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <label class="radio-inline">
                                            <input type = "radio" name = "config_ssl" id = "config_ssl"
                                             value = "1" <?=$data['config_ssl']=="1"?"checked":""?>>&nbsp; Yes &nbsp;
                                        </label>&nbsp; &nbsp;
                                        <label class="radio-inline">
                                            <input type = "radio" name = "config_ssl" id = "config_ssl"
                                             value = "0" <?=$data['config_ssl']=="0"?"checked":""?>>&nbsp; No &nbsp;
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_maintenance" >Maintenance Mode:</label>
                                        <span class="d-flex justify-content-end">Prevents customers from browsing your store. They will instead see a maintenance message. If logged in as admin, you will see the store as normal.</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <label class="radio-inline">
                                            <input type = "radio" name = "config_maintenance" id = "config_maintenance"
                                             value = "1" <?=$data['config_maintenance']=="1"?"checked":""?>>&nbsp; Yes &nbsp;
                                        </label>&nbsp; &nbsp;
                                        <label class="radio-inline">
                                            <input type = "radio" name = "config_maintenance" id = "config_maintenance"
                                             value = "0" <?=$data['config_maintenance']=="0"?"checked":""?>>&nbsp; No &nbsp;
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_encryption" >Encryption Key:</label>
                                        <span class="d-flex justify-content-end">Please provide a secret key that will be used to encrypt private information when processing orders.</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_encryption" id = "config_encryption"
                                        class = "form-control" value = "{{$data['config_encryption']}}"
                                        autocomplete="config_encryption" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_seo_url" >Use SEO URL's:</label>
                                        <span class="d-flex justify-content-end">To use SEO URL's apache module mod-rewrite must be installed and you need to rename the htaccess.txt to .htaccess.</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <label class="radio-inline">
                                            <input type = "radio" name = "config_seo_url" id = "config_seo_url"
                                            value = "1" <?=$data['config_seo_url']=="1"?"checked":""?>>&nbsp; Yes &nbsp;
                                        </label>&nbsp; &nbsp;
                                        <label class="radio-inline">
                                            <input type = "radio" name = "config_seo_url" id = "config_seo_url"
                                             value = "0" <?=$data['config_seo_url']=="0"?"checked":""?>>&nbsp; No &nbsp;
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_compression" >Output Compression Level:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_compression" id = "config_compression"
                                        class = "form-control" value = "{{$data['config_compression']}}"
                                        autocomplete="config_compression" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_error_display" >Display Errors:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <label class="radio-inline">
                                            <input type = "radio" name = "config_error_display" id = "config_error_display"
                                             value = "1" <?=$data['config_error_display']=="1"?"checked":""?>>&nbsp; Yes &nbsp;
                                        </label>&nbsp; &nbsp;
                                        <label class="radio-inline">
                                            <input type = "radio" name = "config_error_display" id = "config_error_display"
                                            value = "0" <?=$data['config_error_display']=="0"?"checked":""?>>&nbsp; No  &nbsp;
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_error_log" >Log Errors:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <label class="radio-inline">
                                            <input type = "radio" name = "config_error_log" id = "config_error_log"
                                             value = "1" <?=$data['config_error_log']=="1"?"checked":""?>>&nbsp; Yes &nbsp;
                                        </label>&nbsp; &nbsp;
                                        <label class="radio-inline">
                                            <input type = "radio" name = "config_error_log" id = "config_error_log"
                                             value = "0" <?=$data['config_error_log']=="0"?"checked":""?>>&nbsp; No &nbsp;
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_error_filename" >Error Log Filename:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_error_filename" id = "config_error_filename"
                                        class = "form-control" value = "{{$data['config_error_filename']}}"
                                        autocomplete="config_error_filename" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "config_error_filename" >Error Log Filename:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input type = "text" name = "config_error_filename" id = "config_error_filename"
                                        class = "form-control" value = "{{$data['config_error_filename']}}"
                                        autocomplete="config_error_filename" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <label class="col-form-label font-weight-bold" 
                                        for = "file_paths" >Ignore Tokens on these pages:</label>
                                        <span class="d-flex justify-content-end">This version of OpenCart has a token system for admin security. Modules that have not been updated for token support yet can be checked to ignore the token check and allow them to work as normal.</span>
                                    </div>
                                    <div class="col-6 d-flex flex-column">
                                        <div class="scrollbox pl-1 pt-1 overflow-auto" id="subjects_box"
                                        style = "height: 400px;" name = "subjects_box">
                                            @foreach ($data['filepaths'] as $filepath)
                                                <div class = "even">
                                                    <input type = "checkbox" name = "filepaths[]">{{$filepath}}
                                                    </input> 
                                                </div>
                                            @endforeach
                                        </div>
                                        <div>
                                            <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', 'checked');"><u>Select All</u></a> /
                                            <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', false);"><u>Unselect All</u></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
<!-- Scripts -->
@section("jssection")
<script type="text/javascript">
    window.addEventListener('load', function() {
        CKEDITOR.replace('config_description_1', {
            uiColor:    '#CCEAEE',
            width:      '100%'
        });
    });
</script>

@stop