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
                        <h1 class="m-0 text-dark">Books of Expense</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Books of Expense</li>
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
                    @foreach($books as $book)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ $book->name }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="heading">
                                        Created : <span class="badge badge-success"> {{ \Carbon\Carbon::parse($book->created_at)->format('d-m-Y') }}</span> <br>
                                        Total Expense : <span class="badge badge-warning">{{ $book->expenses_count }}</span>
                                    </div>


                                </div>
                                <div class="card-footer">
                                    <div class="mt-3 d-flex justify-content-around">
                                        {{--<a title="Deposit" href="{{ url("/expense/view?category=$book->id") }}" class="btn btn-info"> <i--}}
                                                {{--class="fa fa-plus-square"></i> </a>--}}
                                        {{--<a title="Withdraw" href="{{ url("/expense/view?category=$book->id") }}" class="btn btn-danger"> <i--}}
                                                {{--class="fa fa-minus-circle"></i> </a>--}}
                                        {{--<a title="View Expense" href="{{ url("/expense/view?category=$book->id") }}" class="btn btn-dark"> <i--}}
                                                {{--class="fa fa-eye"></i></a>--}}
                                        <a class="btn btn-primary" href="{{ url("/expense/index?category=$book->id") }}">Make an Expense</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')

    <script>

        // Sweet alert

        function deleteBookFunc(e) {
            var form = document.getElementById('form');
            Swal.fire({
                title: 'Are you sure to delete this Book?',
                text: "All expenses under this book will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'

            }).then((result) = > {
                if(result.isConfirmed
        )
            {
                form.submit();
                setTimeout(function () {
                    Swal.fire(
                        'Deleted!',
                        'Your book has been deleted.',
                        'success'
                    )
                }, 500)

            }
        })
            ;
        }


    </script>

@endsection