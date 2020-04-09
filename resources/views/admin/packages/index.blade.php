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
                        <div class="form-group row mb-0">
                            <div class="col-2 offset-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('ADD NEW PACKAGE') }}
                                </button>
                            </div>
                            <div class="col-1 offset-5">
                                <button class = "btn btn-primary" onclick="exportToExcel('packages')">Export to Excel</button>
                            </div>
                        </div>
                    </form>
                    <br>

                    
                </div>
            </div>

            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id = "packages">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Package Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Hours</th>
                            <th scope="col">Price USA</th>
                            <th scope="col">Price Canada</th>
                            <th scope="col">Price Others</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($packages as $package)
                            <tr>
                                <th scope="row">{{$package->id}}</th>
                                <td scope="col">{{$package->name}}</td>
                                <td scope="col"><?php echo html_entity_decode($package->description); ?></td>
                                <td scope="col">{{$package->hours}}</td>
                                <td scope="col">{{$package->price_usa}}</td>
                                <td scope="col">{{$package->price_can}}</td>
                                <td scope="col">{{$package->price_alb}}</td>
                                <td scope="col">
                                    @can('manage-students')
                                        [<a href="{{route('admin.packages.edit', $package)}}">Edit</a>]
                                    @endcan
                                    @can('manage-students')
                                    <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="float-left">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        [<a href="javascript:;" onclick="parentNode.submit();">Delete</a>]
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
@endsection
