@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Monthly Expenses</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.expenses.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <label for="e_name" class="col-3 col-form-label text-md-right">{{ __('Expense Name') }}</label>
                            <div class="col-6">
                                <input id="e_name" type="text" class="form-control" name="e_name" value="{{ $data['old']['e_name'] }}"
                                autocomplete="e_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-3 col-form-label text-md-right">{{ __('Amount:') }}</label>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "amount" id = "amount" class = "form-control"
                                value="{{ $data['old']['amount'] }}" autocomplete="amount" autofocus></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="expense_date" class="col-3 col-form-label text-md-right">{{ __('Expense Date:') }}</label>
                            <div class="col-6 d-flex">
                                <input id="expense_date" type="date" class="form-control" name="expense_date"
                                value="{{ $data['old']['expense_date'] }}" autocomplete="expense_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-6 offset-md-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">

                    <table class="table table-bordered table-striped" id = "mytable">
                        <thead>
                        <tr>
                            <th scope="col">Student Name</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Expense Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['expenses'] as $expense)
                            <tr>
                                <td scope="col">{{$expense->name}}</td>
                                <td scope="col">{{$expense->amount}}</td>
                                <td scope="col">{{date('d/m/Y', strtotime($expense->date))}}</td>
                                <td scope="col">
                                    @can('manage-payments')
                                        [<a href="{{route('admin.expenses.edit', $expense)}}">Edit</a>]
                                    @endcan
                                    @can('manage-payments')
                                    <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST" class="float-left">
                                    @csrf
                                        {{method_field('DELETE')}}
                                        [<a href="javascript:;" onclick="parentNode.submit();">Delete</a>]
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
