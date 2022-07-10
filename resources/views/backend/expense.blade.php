@extends('backend.layouts.master')

@section('title', 'Expenses')

@section('style')

    <style>
        .btn {
            padding: 2px 7px;
        }

        table {
            width: 100%;
        }

        table th,
        table td {
            border: 1px solid #000;
            text-align: center;
            padding: 2px;
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
                                @if (request()->has('id'))
                                    <form action="{{ url("/expense/deposit-withdraw/update", $expense->id) }}"
                                          method="POST">
                                        @else
                                            <form action="{{ url("/expense/deposit-withdraw") }}" method="POST">
                                                @endif
                                                @csrf

                                                @includeIf('.backend.partials.response-message')

                                                <input type="hidden" name="category" value="{{ $book }}">

                                                <div class=" form-group">
                                                    <label for="name">Name</label>
                                                    <input required type="text" value="{{ $expense->name ?? '' }}"
                                                           class="form-control"
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
                                                    <input required type="text" value="{{ $expense->cost ?? '' }}"
                                                           class="form-control"
                                                           name="cost"
                                                           id="cost">

                                                    @if($errors->has('cost'))
                                                        <span class="text-danger font-weight-bold">
                                                {{ $errors->first('cost') }}
                                            </span>
                                                    @endif
                                                </div>

                                                <div class=" form-group">
                                                    <label for="created_at">Date</label>
                                                    <input required type="date"
                                                           value="{{ $expense ? \Carbon\Carbon::parse($expense->created_at)->format('Y-m-d') : ''  }}"
                                                           class="form-control"
                                                           name="created_at"
                                                           id="created_at">

                                                    @if($errors->has('created_at'))
                                                        <span class="text-danger font-weight-bold">
                                                {{ $errors->first('created_at') }}
                                            </span>
                                                    @endif
                                                </div>

                                                <div class=" form-group">
                                                    <label for="expense_type">Expense Type</label>
                                                    <select required name="expense_type" id="expense_type"
                                                            class="form-control">
                                                        <option value="">--- Select ---</option>
                                                        @if($expense && $expense->expense_type == 'deposit')
                                                            <option selected value="deposit">Deposit</option>
                                                            <option value="withdraw"> Withdraw</option>
                                                        @elseif($expense && $expense->expense_type == 'withdraw')
                                                            <option selected value="withdraw"> Withdraw</option>
                                                            <option value="deposit">Deposit</option>
                                                        @else
                                                            <option value="deposit">Deposit</option>
                                                            <option value="withdraw"> Withdraw</option>
                                                        @endif
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Balance Summary <i class="fa fa-usd"></i></h4>
                                    </div>
                                    <div class="card-body">
                                        <h5>Total Deposit: <span
                                                class="badge badge-success">{{ number_format($balanceSummary['deposit'], 2) }}</span>
                                            BDT /=</h5>
                                        <h5>Total Withdraw: <span
                                                class="badge badge-warning">{{ number_format($balanceSummary['withdraw'], 2) }}</span>
                                            BDT /=</h5>
                                        <h5>Available Balance: <span
                                                class="badge badge-danger">{{ number_format($balanceSummary['available_balance'], 2) }}</span>
                                            BDT /=</h5>

                                        <h6 class="text-danger">{{ $balanceSummary['lowerBalance'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Expense List</h4>
                                    </div>
                                    <div class="card-body">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>SL.</th>
                                                <th>Name</th>
                                                <th>Cost</th>
                                                <th>Expense Type</th>
                                                <th>Book</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($expenses as $expense)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ ucfirst($expense->name) }}</td>
                                                    <td>{{ number_format($expense->cost, 2) }} BDT /=</td>
                                                    @if($expense->expense_type == "withdraw")
                                                        <td>
                                                            <span
                                                                class="badge badge-pill badge-danger">{{ ucfirst($expense->expense_type) }}</span>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <span
                                                                class="badge badge-pill badge-success">{{ ucfirst($expense->expense_type) }}</span>
                                                        </td>
                                                    @endif
                                                    <td>{{ $expense->category->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($expense->created_at)->format('d-m-y h:i:s a') }}</td>
                                                    <td class="d-flex justify-content-between">
                                                        <a class="btn btn-sm btn-warning"
                                                           href="{{ url("/expense/edit/?id=$expense->id&category={$expense->category->id}") }}"><i
                                                                class="fa fa-pencil"></i></a>

                                                        <form id="form" action="{{ url("/expense/delete?id=$expense->id&category=$expense->category->id") }}"
                                                              method="POST">
                                                            @csrf

                                                            <input type="hidden" name="expense_id" value="{{ $expense->id }}">

                                                            <button data-id="{{ $expense->id }}" class="btn btn-sm btn-danger"
                                                                    onclick="deleteExpense()"
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
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{--{{ $expenses->links('pagination::bootstrap-4') }}--}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        function deleteExpense() {
            var form = document.getElementById('form');
            Swal.fire({
                title: 'Are you sure to delete this Expense?',
                text: "Deleted item can't be recovered",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'

            }).then((result) => {
                if(result.isConfirmed){
                form.submit();
                setTimeout(function () {
                    Swal.fire(
                        'Deleted!',
                        'Your expense has been deleted.',
                        'success'
                    )
                }, 500)

            }
        })
            ;
        }
    </script>
@endsection
