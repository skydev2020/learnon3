@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px"> Packages</i>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.packages.create') }}">
                        <div class="form-group row">
                            <div class="offset-5 col-7 text-right">
                                <a href = "{{route('admin.packages.create')}}">
                                    <button type = "button" class="btn btn-primary" >Add</button>
                                </a>
                                <a href="javascript:;">                                
                                    <button class="btn btn-primary" id="del_btn">Delete</button>    
                                </a>                                
                            </div>
                        </div>
                        <div class = "form-group row mb-0">                        
                            <div class = "col-12 d-flex align-items-center justify-content-end">
                                <button class="btn btn-primary left_margin" onclick="exportToExcel('packages');  return false;">Export</button>                                
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('admin.packages.multiDelete') }}" class="d-none" method="post" id="multi_del_form">
                        @csrf
                        <input type="hidden" name="sids" id="sids">                       
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header"></div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id = "packages">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center pt-0 pl-1 pr-1" style="width: 20px;">
                                    <input type="checkbox" class="text-center"
                                    onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                                </th>
                                <th scope="col" style="width: 50px;" class="text-center">ID</th>
                                <th scope="col" style="width: 350px;" class="text-center">
                                    @if ($data['order']['field'] == 'name' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.packages.index') }}?field=name&dir=desc&{{$data['url']}}" class="asc order">Package Name</a>
                                    @elseif ($data['order']['field'] == 'name' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.packages.index') }}?field=name&dir=asc&{{$data['url']}}" class="desc order">Package Name</a>
                                    @else
                                        <a href="{{route('admin.packages.index') }}?field=name&dir=asc&{{$data['url']}}" class="order">Package Name</a>
                                    @endif
                                </th>
                                <th scope="col" class="text-center">
                                    @if ($data['order']['field'] == 'description' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.packages.index') }}?field=name&dir=desc&{{$data['url']}}" class="asc order">Description</a>
                                    @elseif ($data['order']['field'] == 'description' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.packages.index') }}?field=description&dir=asc&{{$data['url']}}" class="desc order">Description</a>
                                    @else
                                        <a href="{{route('admin.packages.index') }}?field=description&dir=asc&{{$data['url']}}" class="order">Description</a>
                                    @endif
                                </th>
                                <th scope="col" class="text-center">
                                    @if ($data['order']['field'] == 'hours' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.packages.index') }}?field=hours&dir=desc&{{$data['url']}}" class="asc order">Hours</a>
                                    @elseif ($data['order']['field'] == 'hours' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.packages.index') }}?field=hours&dir=asc&{{$data['url']}}" class="desc order">Hours</a>
                                    @else
                                        <a href="{{route('admin.packages.index') }}?field=hours&dir=asc&{{$data['url']}}" class="order">Hours</a>
                                    @endif
                                </th>
                                <th scope="col" class="text-center">
                                    @if ($data['order']['field'] == 'price_usa' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.packages.index') }}?field=price_usa&dir=desc&{{$data['url']}}" class="asc order">Price USA</a>
                                    @elseif ($data['order']['field'] == 'price_usa' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.packages.index') }}?field=price_usa&dir=asc&{{$data['url']}}" class="desc order">Price USA</a>
                                    @else
                                        <a href="{{route('admin.packages.index') }}?field=price_usa&dir=asc&{{$data['url']}}" class="order">Price USA</a>
                                    @endif
                                </th>
                                <th scope="col" class="text-center">
                                    @if ($data['order']['field'] == 'price_can' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.packages.index') }}?field=price_can&dir=desc&{{$data['url']}}" class="asc order">Price Canada</a>
                                    @elseif ($data['order']['field'] == 'price_can' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.packages.index') }}?field=price_can&dir=asc&{{$data['url']}}" class="desc order">Price Canada</a>
                                    @else
                                        <a href="{{route('admin.packages.index') }}?field=price_can&dir=asc&{{$data['url']}}" class="order">Price Canada</a>
                                    @endif
                                </th>
                                <th scope="col" class="text-center">
                                    @if ($data['order']['field'] == 'price_alb' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.packages.index') }}?field=price_alb&dir=desc&{{$data['url']}}" class="asc order">Price Others</a>
                                    @elseif ($data['order']['field'] == 'price_alb' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.packages.index') }}?field=price_alb&dir=asc&{{$data['url']}}" class="desc order">Price Others</a>
                                    @else
                                        <a href="{{route('admin.packages.index') }}?field=price_alb&dir=asc&{{$data['url']}}" class="order">Price Others</a>
                                    @endif
                                </th>
                                <th scope="col" class="text-right" style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['packages'] as $package)
                            <tr>
                                <th scope="row" class="text-center pr-0 pl-0">
                                    <input type="checkbox" name="selected[]" value="{{$package['id']}}"
                                    class="text-center"/>
                                </th>
                                <th scope="row" class="font-weight-normal pl-1 pr-1 text-center">{{$package['id']}}</th>
                                <td scope="col" class="text-center pl-1 pr-1">{{$package['name']}}</td>
                                <td scope="col" class="text-center pl-1 pr-1"><?php echo html_entity_decode($package['description']); ?></td>
                                <td scope="col" class="text-center pl-1 pr-1">{{$package['hours']}}</td>
                                <td scope="col" class="text-center pl-1 pr-1">{{$package['price_usa']}}</td>
                                <td scope="col" class="text-center pl-1 pr-1">{{$package['price_can']}}</td>
                                <td scope="col" class="text-center pl-1 pr-1">{{$package['price_alb']}}</td>
                                <td scope="col" class="text-right">
                                    @can('manage-students')
                                        [<a href="{{route('admin.packages.edit', $package['id'])}}">Edit</a>]
                                    @endcan
                                    @can('manage-students')
                                    <form action="{{ route('admin.packages.destroy', $package['id']) }}" method="POST" class="float-left">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        [<a href="javascript:;" onclick="del(this)">Delete</a>]
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
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
<script src="{{ asset('js/export/export.js')}}"></script>
@stop