@extends('backend.layouts.master')

@section('title', 'Dashboard')

@section('style')

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
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
                    <div class="col-lg-4 col-4">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3> {{ $expenseByToday[0] ?? 0 }} <sup style="font-size: 20px">Tk</sup></h3>

                                <p>Expense Today</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-calendar-o"></i>
                            </div>
{{--                            <a href="{{ route('report.daily') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-4">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                @foreach($expenseByWeek as $week)
                                    <h3>{{ $week->total ?? '0' }} <sup style="font-size: 20px">Tk</sup></h3>
                                @endforeach
                                <p>Expense This Week</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-calendar-check-o"></i>
                            </div>
{{--                            <a href="{{ route('report.weekly') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-4">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                @foreach($expenseByMonth as $month)
                                    <h3> {{ $month->total ?? '0' }} <sup style="font-size: 20px">Tk</sup></h3>
                                @endforeach
                                <p>Expense This month</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-calendar"></i>
                            </div>
{{--                            <a href="{{ route('report.monthly') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                        </div>
                    </div>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection
