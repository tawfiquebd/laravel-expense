@extends('backend.layouts.master')

@section('title', 'Expenses')

@section('style')

    <style>
        .btn {
            padding: 2px 7px;
        }
    </style>

@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Expenses</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Expenses</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Create Expense</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ url("/expense/deposit") }}" method="POST">
                                    @csrf

                                    @includeIf('.backend.partials.response-message')

                                    <input type="hidden" name="category" value="{{ $book }}">

                                    <div class=" form-group">
                                        <label for="name">Name</label>
                                        <input required type="text" class="form-control"
                                               name="name"
                                               id="name">

                                        @if($errors->has('name'))
                                            <span class="text-danger font-weight-bold">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                    </div>


                                    <div class=" form-group">
                                        <label for="cost">Cost</label>
                                        <input required type="text" class="form-control"
                                               name="cost"
                                               id="cost">

                                        @if($errors->has('cost'))
                                            <span class="text-danger font-weight-bold">
                                                {{ $errors->first('cost') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class=" form-group">
                                        <label for="expense_type">Expense Type</label>
                                        <select required name="expense_type" id="expense_type" class="form-control">
                                            <option value="">--- Select ---</option>
                                            <option value="deposit">Deposit</option>
                                            <option value="withdraw">Withdraw</option>
                                        </select>

                                        @if($errors->has('expense_type'))
                                            <span class="text-danger font-weight-bold">
                                                {{ $errors->first('expense_type') }}
                                            </span>
                                        @endif
                                    </div>


                                    <button type="submit" class="btn btn-sm btn-info">Proceed</button>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Expense List</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Name</th>
                                        <th>Cost</th>
                                        <th>Expense Type</th>
                                        <th>Book</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($expenses as $expense)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $expense->name }}</td>
                                            <td>{{ $expense->cost }}</td>
                                            @if($expense->expense_type == "withdraw")
                                            <td>
                                                <span class="badge badge-pill badge-danger">{{ ucfirst($expense->expense_type) }}</span>
                                            </td>
                                            @else
                                            <td>
                                                <span class="badge badge-pill badge-success">{{ ucfirst($expense->expense_type) }}</span>
                                            </td>
                                            @endif
                                            <td>{{ $expense->category->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($expense->created_at)->format('d-m-y h:i:s a') }}</td>
                                            <td class="d-flex justify-content-between">
                                                <a class="btn btn-sm btn-warning"
                                                   href="{{ url('/category/edit') }}"><i
                                                        class="fa fa-pencil"></i></a>

                                                <form id="form" action="{{ url('/category/delete') }}"
                                                      method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="">
                                                    <button class="btn btn-sm btn-danger"
                                                            onclick="deleteBookFunc()"
                                                            type="button"><i
                                                            class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $expenses->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')

@endsection
