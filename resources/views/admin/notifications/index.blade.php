@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px"> Notifications</i>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-2 offset-10 text-right">
                                <form action="{{ route('admin.notifications.multiDelete') }}" method="post" id="multi_del_form">
                                    @csrf
                                   <input type="hidden" name="sids" id="sids">
                                    <a href="#">                                
                                        <button class="btn btn-primary">Delete</button>
                                    </a>
                                </form>
                            </div>
                        </div>
                        <div class="form-group row panel">                            
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" width="1" class="text-center pt-0">
                                            <input type="checkbox" class="text-center"
                                            onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                                        </th>
                                        <th scope="col">Notification From</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col" class="text-center">Date Received</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notifications as $notification)
                                    <tr>
                                        <th scope="row" width="1" class="text-center">
                                            <input type="checkbox" name="selected[]" value="{{$notification->id}}"
                                            class="text-center"/>
                                        </th>
                                        <td scope="col"><?= $notification->from_user() == NULL ? '' :
                                        $notification->from_user()['fname'] . ' ' .
                                        $notification->from_user()['lname'] . ' [' .
                                        $notification->from_user()->roles()->first()['name'] . ']'?></td>
                                        <td scope="col">{{$notification->subject}}</td>
                                        <td scope="col" class="text-center">{{date('d/m/Y', strtotime($notification->created_at))}}</td>
                                        <td scope="col" class="text-center">
                                            @can('manage-cms')
                                                [<a href="{{route('admin.notifications.show', $notification)}}"
                                                >View</a>]
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Scripts -->
@section("jssection")
<script>
    window.addEventListener('load', function() {
        jQuery( "#multi_del_form" ).submit(function( event ) {
            
            var sel_objs = jQuery('input[name*=\'selected\']:checked');

            // clear all selected id 
            var sel_obj_ids = [];
            
            for (var i=0; i < sel_objs.length ; ++i) {
                sel_obj_ids.push(sel_objs[i].value);
            }
            jQuery("#sids").val(sel_obj_ids.toString());

            if (sel_objs.length==0) {
                alert('Please select the row.')
                return false;
            }
            else {
                return confirm("Do you want to delete selected rows.");
            }
        });
    });
</script>
@stop