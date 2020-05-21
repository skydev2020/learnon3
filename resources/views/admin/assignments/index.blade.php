@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px"> Student Assignments</i>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.assignments.index') }}">
                        @csrf
                        {{method_field('GET')}}
                        <div class="form-group row">
                            <label for="s_name" class="col-4 col-form-label text-right">{{ __('Student Name') }}</label>
                            <div class="col-6">
                                <input id="s_name" type="text" class="form-control" name="s_name" value="{{ $data['old']['s_name'] }}"
                                autocomplete="s_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="t_name" class="col-4 col-form-label text-right">{{ __('Tutor Name') }}</label>
                            <div class="col-6">
                                <input id="t_name" type="text" class="form-control" name="t_name" value="{{ $data['old']['t_name'] }}"
                                autocomplete="t_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="a_date" class="col-4 col-form-label text-right">{{ __('Date Registered') }}</label>
                            <div class="col-6">
                                <input id="a_date" type="date" class="form-control" name="a_date" value="{{ $data['old']['a_date'] }}"
                                autocomplete="a_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-1 offset-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}
                                </button>
                            </div>
                            <div class="col-7 text-right">
                                <a href = "{{ route('admin.assignments.create') }}"> 
                                    <button class="btn btn-primary" type = "button">{{ __('Add') }}</button>
                                </a>
                                <a href="javascript:;">                                
                                    <button class="btn btn-primary" id="del_btn">Delete</button>    
                                </a> 
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('admin.assignments.multiDelete') }}" class="d-none" method="post" id="multi_del_form">
                        @csrf
                        <input type="hidden" name="sids" id="sids">                       
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center pt-0 pl-1 pr-1" style="width: 20px;">
                                <input type="checkbox" class="text-center"
                                onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                            </th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Tutor Name</th>
                            <th scope="col">Subjects</th>
                            <th scope="col">Date Assigned</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['assignments'] as $assignment)
                            <tr>
                                <th scope="row" class="text-center pr-0 pl-0">
                                    <input type="checkbox" name="selected[]" value="{{$assignment->id}}"
                                    class="text-center"/>
                                </th>
                                <td scope="col">{{$assignment->student() != null ? $assignment->student()['fname'] 
                                . ' ' . $assignment->student()['lname'] . ' ( ' . $assignment->student()['id'] . ' )' : "" }}</td>
                                <td scope="col">{{$assignment->tutor() != null ? $assignment->tutor()['fname'] 
                                . ' ' . $assignment->tutor()['lname'] . ' ( ' . $assignment->tutor()['id'] . ' )' : ""}}</td>
                                <td scope="col"><?php
                                    $subjects = "";
                                    foreach ($assignment->subjects()->get() as $subject)
                                    {
                                        $subjects .= $subject->name . ', ';
                                    }
                                    $subjects = rtrim($subjects, ', ');
                                    echo $subjects;?></td>
                                <td scope="col">{{date('d/m/Y', strtotime($assignment->created_at))}}</td>
                                <td scope="col">
                                    @can('manage-students')
                                    [<a href="{{route('admin.assignments.edit', $assignment)}}">Edit</a>]
                                    @endcan
                                    @can('manage-students')
                                    <form action="{{ route('admin.assignments.destroy', $assignment) }}" method="POST" class="float-left">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        <!-- [<a href="javascript:;" onclick="parentNode.submit();">Delete</a>] -->
                                        [<a href="javascript:;" onclick="del(this)">Delete</a>]
                                    </form>
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
@endsection
@section("jssection")
<script>    
    function del(ele) {
        var r= confirm("Do you want to delete selected row?");
        if (r != true) {
            return false;
        }
        ele.parentNode.submit();
    }

    window.addEventListener('load', function() {
        jQuery( "#del_btn" ).click(function( event ) {
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
                var r= confirm("Do you want to delete selected rows?");
                if (r != true) {
                    return false;
                }
                event.preventDefault();
                document.getElementById('multi_del_form').submit();
                // jQuery("#multi_del_form").submit();
            }   
        });
    });

</script>
@stop