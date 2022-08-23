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
                        <h1 class="m-0 text-dark">Report Category Wise</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Report Category Wise</li>
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
                    @forelse($categories as $category)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ $category->name }} <i class="fa fa-book"></i></h5>
                                </div>
                                <div class="card-body">
                                    <div class="heading">
                                        Category Created : <span class="badge badge-success"> {{ \Carbon\Carbon::parse($category->created_at)->format('d-m-Y') }}</span> <br>
                                        Total Expense : <span class="badge badge-warning">{{ $category->expenses_count }}</span>
                                    </div>


                                </div>
                                <div class="card-footer">
                                    <div class="mt-3 d-flex justify-content-around">
                                        <a class="btn btn-primary" href="{{ url("/report/daily-wise?category=$category->id") }}">View Daily Wise Report</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-4"></div>
                        <div class="col-md-4 mt-5">
                            <div class="card">
                                <div class="card-heading mt-3">
                                    <h4 class="text-center text-danger">No Books Found to Generate Report</h4>
                                </div>
                                <div class="card-body">
                                    <h6 class="text-center"><a href="{{ route('category.index') }}">Create a Book</a></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')

    <script>


    </script>

@endsection
