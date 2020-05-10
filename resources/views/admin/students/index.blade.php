@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-address-book" style="font-size:24px"> Students</i>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.students.index') }}" id="student_form">
                        @csrf
                        {{method_field('GET')}}
                        <div class="form-group row">
                            <label for="s_name" class="col-4 col-form-label text-md-right">{{ __('Student Name') }}</label>
                            <div class="col-6">
                                <input id="s_name" type="text" class="form-control" name="s_name" value="{{ $data['old']['s_name'] }}"
                                autocomplete="s_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_city" class="col-4 col-form-label text-md-right">{{ __('City') }}</label>
                            <div class="col-6">
                                <input id="s_city" type="text" class="form-control" name="s_city" value="{{ $data['old']['s_city'] }}"
                                autocomplete="s_city" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_sub" class="col-4 col-form-label text-md-right">{{ __('Subjects') }}</label>
                            <div class="col-6">
                                <input id="s_sub" type="text" class="form-control" name="s_sub" value="{{ $data['old']['s_sub'] }}"
                                autocomplete="s_sub" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_status" class="col-4 col-form-label text-md-right">{{ __('Status') }}</label>
                            <div class="col-6">
                                <select style="display: inline-block;" id="s_status_id" name="s_status_id" class = "form-control">
                                    <option></option>
                                    @foreach ($data['student_statuses'] as $key => $value)
                                    <option value="{{ $value->id }}" {{ ( $value->id == $data['old']['s_status_id']) ? 'selected' : '' }}>
                                        {{ $value->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_date" class="col-4 col-form-label text-md-right">{{ __('Date Registered') }}</label>
                            <div class="col-6">
                                <input id="s_date" type="date" class="form-control" name="s_date" value="{{ $data['old']['s_date'] }}"
                                autocomplete="s_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-1 offset-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}
                                </button>
                            </div>
                            <div class="col-7 text-right">
                                <a href = "{{route('admin.students.create')}}">
                                    <button type = "button" class="btn btn-primary" >Add</button>
                                </a>
                                <a href="javascript:;">                                
                                    <button class="btn btn-primary" id="del_btn">Delete</button>    
                                </a>                                
                            </div>
                        </div>

                        <div class = "form-group row mb-0">                        
                            <div class = "col-12 d-flex align-items-center justify-content-end">
                                <input type="checkbox" name = "names" id = "names" value = "yes">&nbsp;&nbsp;
                                <label class="form-check-label" for="names"> Student list </label>&nbsp;&nbsp;
                            
                                <input type="checkbox" name = "emails" id = "emails" value = "yes">&nbsp;&nbsp;
                                <label class="form-check-label" for="emails"> Student emails </label>&nbsp;&nbsp;
                            
                                <input type="checkbox" name = "referrers" id = "referrers" value = "yes">&nbsp;&nbsp;
                                <label class="form-check-label" for="referrers">Where they heard about us?</label>&nbsp;&nbsp;
                                
                                <input type="checkbox" name = "contract" id = "contract" value = "yes">&nbsp;&nbsp;
                                <label class="form-check-label" for="contract"> Contract/Agreement </label>
                                <button class="btn btn-primary left_margin" onclick="exportToExcel('students');  return false;">Export</button>                                
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('admin.students.multiDelete') }}" class="d-none" method="post" id="multi_del_form">
                        @csrf
                        <input type="hidden" name="sids" id="sids">                       
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped"  id = "students">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center pt-0 pl-1 pr-1" style="width: 20px;">
                                    <input type="checkbox" class="text-center"
                                    onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                                </th>
                                <th scope="col" style="width: 50px;" class="text-center">ID</th>
                                <th scope="col" style="width: 150px;" class="text-center">
                                    @if ($data['order']['field'] == 'fname' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.students.index') }}?field=fname&dir=desc&{{$data['url']}}" class="asc order">Student Name</a>
                                    @elseif ($data['order']['field'] == 'fname' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.students.index') }}?field=fname&dir=asc&{{$data['url']}}" class="desc order">Student Name</a>
                                    @else
                                        <a href="{{route('admin.students.index') }}?field=fname&dir=asc&{{$data['url']}}" class="order">Student Name</a>
                                    @endif
                                </th>
                                <th scope="col" style="width: 100px;" class="text-center">                                    
                                    @if ($data['order']['field'] == 'email' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.students.index') }}?field=email&dir=desc&{{$data['url']}}" class="asc order">Email</a>
                                    @elseif ($data['order']['field'] == 'email' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.students.index') }}?field=email&dir=asc&{{$data['url']}}" class="desc order">Email</a>
                                    @else
                                        <a href="{{route('admin.students.index') }}?field=email&dir=asc&{{$data['url']}}" class="order">Email</a>
                                    @endif
                                </th>
                                <th scope="col" style="width: 50px;" class="text-center">
                                    @if ($data['order']['field'] == 'city' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.students.index') }}?field=city&dir=desc&{{$data['url']}}" class="asc order">City</a>
                                    @elseif ($data['order']['field'] == 'city' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.students.index') }}?field=city&dir=asc&{{$data['url']}}" class="desc order">City</a>
                                    @else
                                        <a href="{{route('admin.students.index') }}?field=city&dir=asc&{{$data['url']}}" class="order">City</a>
                                    @endif
                                </th>
                                <th scope="col" class="text-center">Subjects</th>
                                <th scope="col" style="width: 140px;" class="text-center">Status</th>
                                <th scope="col" style="width: 165px;" class="text-center">                                    
                                    @if ($data['order']['field'] == 'service_method' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.students.index') }}?field=service_method&dir=desc&{{$data['url']}}" class="asc order">Tutoring Service</a>
                                    @elseif ($data['order']['field'] == 'service_method' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.students.index') }}?field=service_method&dir=asc&{{$data['url']}}" class="desc order">Tutoring Service</a>
                                    @else
                                        <a href="{{route('admin.students.index') }}?field=service_method&dir=asc&{{$data['url']}}" class="order">Tutoring Service</a>
                                    @endif
                                </th>
                                <th scope="col" style="width: 160px;" class="text-center">
                                    
                                    @if ($data['order']['field'] == 'created_at' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.students.index') }}?field=created_at&dir=desc&{{$data['url']}}" class="asc order">Date Registered</a>
                                    @elseif ($data['order']['field'] == 'created_at' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.students.index') }}?field=created_at&dir=asc&{{$data['url']}}" class="desc order">Date Registered</a>
                                    @else
                                        <a href="{{route('admin.students.index') }}?field=created_at&dir=asc&{{$data['url']}}" class="order">Date Registered</a>
                                    @endif
                                </th>
                                <th scope="col" class="text-right" style="width: 295px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['students'] as $student)
                            <tr>
                                <th scope="row" class="text-center pr-0 pl-0">
                                    <input type="checkbox" name="selected[]" value="{{$student->id}}"
                                    class="text-center"/>
                                </th>
                                <th scope="col" class="font-weight-normal pl-1 pr-1 text-center">{{$student->id}}</th>
                                <td scope="col" class="text-center pl-1 pr-1 ">{{$student->fname . ' ' . $student->lname}}</td>
                                <td scope="col" class="text-center pl-1 pr-1 ">{{$student->email}}</td>
                                <td scope="col" class="text-center pl-1 pr-1 ">{{$student->city}}</td>
                                <td scope="col" class="text-center pl-1 pr-1 "><?php
                                    $subjects = "";
                                    foreach ($student->subjects()->get() as $subject)
                                    {
                                        $subjects .= $subject->name . ', ';
                                    }
                                    $subjects = rtrim($subjects, ', ');
                                    echo $subjects;?></td>
                                <td scope="col" class="text-center pl-1 pr-1 ">{{$student->studentStatus()->first()['title']}}</td>
                                <td scope="col" class="text-center pl-1 pr-1 ">{{$student->service_method}}</td>
                                <td scope="col" class="text-center pl-1 pr-1 ">{{date('d/m/Y', strtotime($student->created_at))}}</td>
                                <td scope="col" class="text-right">
                                    @can('manage-students')
                                        [<a href="{{route('admin.students.show', $student->id)}}">View</a>]
                                    @endcan
                                    @can('manage-students')
                                        [<a href="{{route('admin.students.edit', $student->id)}}">Edit</a>]
                                    @endcan
                                    @can('manage-students')
                                        [<a href="{{route('admin.students.invoices', $student)}}">Invoices</a>]
                                    @endcan
                                    @can('manage-students')
                                        [<a href="{{route('admin.students.contract', $student)}}" target="_blank">Contract</a>]
                                    @endcan
                                    @can('manage-students')
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="float-left">
                                        @csrf
                                        {{method_field('DELETE')}}
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
<!-- Scripts -->
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
<script src="{{ asset('js/export.js')}}"></script>
@stop