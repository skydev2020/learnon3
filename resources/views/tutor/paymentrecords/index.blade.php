@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px;"> Payment Records</i>
                </div>

                <div class="card-body">
                    @foreach ($data as $key => $value)
                    {{-- {{dd($value->id)}} --}}
                    <div class="col-8 offset-1">
                        <a href = "{{ route('tutor.paymentrecords.show', $value->id) }}"> <font size = '+2'>
                            {{ date("M Y", strtotime($key)) }}</a>
                    </div>    
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection