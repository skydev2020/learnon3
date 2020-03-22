@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Billing Process</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.process.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        {{-- {{dd($data)}} --}}
                        <div class="form-group row mb-0">
                            <div class="col-1 offset-10">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ $data['button_save'] }}
                                </button>
                            </div>
                            <div class="col-1">
                                
                                    <button type = "button" class="btn btn-primary" >Cancel</button>
                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="payment_date" class="col-form-label font-weight-bold">{{ __('Billing Month:') }}</label>
                            </div>
                            <div class="col-6">
                                <select name = "payment_date" id = "payment_date" class = "form-control">
                                    <option value = "0">--Please Select--</option>
                                    @foreach ($data['all_dates'] as $each_date)
                                        <option value = "{{$each_date['value']}}" 
                                        <?= $each_date['value'] == $data['payment_date'] ? "selected" : "" ?>>
                                        {{$each_date['text']}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <?php if (!empty($data['payment_date'])) { ?>
                        
                        <div id = "process_steps">
                            <div class="form-group row">
                                <input type = "checkbox" name = "process[]" id = "process[]" value="collect_hours"
                                <?=(in_array('collect_hours', $data['billing_process'])) ? 'checked':'';?> <?=($data['processing']) ? 'disabled':''; ?>>
                                Collect Hours </input>
                                <div>
                                <?=!empty($data['collect_hours']) ? "Done" : "" ?>
                                </div>
                                <div>
                                    <?=!empty($data['collect_hours']) ? "Official Submitted Hours (" . $data['total_approved_hours']. ")" : ""?> 
                                </div>
                            </div>

                            <div class="form-group row">
                                <input type = "checkbox" name = "process[]" id = "process[]" value="generate_invoices"
                                <?=(in_array('generate_invoices', $data['billing_process'])) ? 'checked':'';?> <?=($data['processing']) ? 'disabled':'' ?>>
                                Generate Invoices </input>
                                <div>
                                    
                                <?=!empty($data['generate_invoices']) ? "Done" : "" ?>
                                </div>
                                <div>
                                    <?=!empty($data['generate_invoices']) ? "Invoice Generated ( " . $data['total_approved_hours'] . ")" : ""?> 
                                    <br>
                                    <?=!empty($data['generate_invoices']) ? "Invoice Updated ( " . $data['total_invoice_updated'] . ")" : ""?> 
                                </div>
                            </div>

                            <div class="form-group row">
                                <input type = "checkbox" name = "process[]" id = "process[]" value="send_invoices"
                                <?=(in_array('send_invoices', $data['billing_process'])) ? 'checked':'';?> <?=($data['processing']) ? 'disabled':'' ?>>
                                Lock Invoices </input>
                                <div>
                                <?=!empty($data['send_invoices']) ? "Done" : "" ?>
                                </div>
                                <div>
                                    <?=!empty($data['send_invoices']) ? "Total Invoice Locked ( " . $data['total_invoice_lock'] . ")" : ""?> 
                                    <br>
                                    <?=!empty($data['send_invoices']) ? "Total Invoice Sent ( " . $data['total_invoice_sent'] . ")" : ""?> 
                                </div>
                            </div>

                            <div class="form-group row">
                                <input type = "checkbox" name = "process[]" id = "process[]" value="generate_paycheques"
                                <?=(in_array('generate_paycheques', $data['billing_process'])) ? 'checked':'';?>
                                 <?=($data['processing']) ? 'disabled':'' ?>>Generate Paycheques</input>
                                <div>
                                <?=!empty($data['generate_paycheques']) ? "Done" : "" ?>
                                </div>
                                <div>
                                    <?=!empty($data['generate_paycheques']) ? "Paycheques Generated ( " . $data['total_paycheques_generated'] . ")" : ""?> 
                                    <br>
                                    <?=!empty($data['generate_paycheques']) ? "Paycheques Updated ( " . $data['total_paycheques_updated'] . ")" : ""?> 
                                </div>
                            </div>

                            <div class="form-group row">
                                <input type = "checkbox" name = "process[]" id = "process[]" value="send_paycheques"
                                <?=(in_array('send_paycheques', $data['billing_process'])) ? 'checked':'';?>
                                 <?=($data['processing']) ? 'disabled':'' ?>>Lock Paycheques</input>
                                <div>
                                <?=!empty($data['generate_paycheques']) ? "Done" : "" ?>
                                </div>
                                <div>
                                    <?=!empty($data['send_paycheques']) ? "Total Invoice Locked ( " . $data['total_paycheques_lock'] . ")" : ""?> 
                                    <br>
                                    <?=!empty($data['send_paycheques']) ? "Total Invoice Sent ( " . $data['total_paycheques_sent'] . ")" : ""?> 
                                </div>
                            </div>

                            <?php if (!empty($finished)) { ?>
                            <?php } ?>
                        </div>
                        <?php } ?>                            
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Scripts -->
@section("jssection")
<script type = "text/javascript">
    function exportToExcel(tableID){
        var tab_text="<table border='2px'><tr bgcolor='#87AFC6' style='height: 75px; text-align: center; width: 250px'>";
        var textRange; var j=0;
        tab = document.getElementById(tableID); // id of table

        for(j = 0 ; j < tab.rows.length ; j++)
        {

            tab_text=tab_text;

            tab_text=tab_text+tab.rows[j].innerHTML.toUpperCase()+"</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text= tab_text+"</table>";
        tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
        tab_text= tab_text.replace(/<img[^>]*>/gi,""); //remove if u want images in your table
        tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); //remove input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer

        {
            txtArea1.document.open("txt/html","replace");
            txtArea1.document.write( 'sep=,\r\n' + tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa=txtArea1.document.execCommand("SaveAs",true,"sudhir123.txt");
        }

        else {
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
        }
        
        return (sa);
    }
</script>
@stop