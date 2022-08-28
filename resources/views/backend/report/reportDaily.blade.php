@extends('backend.layouts.master')

@section('title', 'Daily Report')

@section('style')

@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Daily Report</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daily Report by Category - {{ $categoryName[0] }}</h3>
                        </div>

                    <!-- /.card-header -->
                        <div class="card-body">
                            <table id="reportTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>SL.</th>
                                    <th>Date</th>
                                    <th>Total Cost (Tk)</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @php
                                    $i = 0;
                                @endphp

                                @foreach($days as $day => $sum)

                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $day }}</td>
                                        <td>{{ $sum }}</td>
                                        <td>
                                            {{--<a target="_blank" href="{{ url("/report/daily-print?date=$day&category=$category") }}" class="btn btn-danger">--}}
                                                {{--<i class="fa fa-print"></i>--}}
                                            {{--</a>--}}

                                            <a href="{{ route('daily-report-download.pdf', ["date" => $day, "category" => request()->get('category') ]) }}" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i></a>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>

@endsection

@section('scripts')
    <script>
        // Data tables
        $(document).ready(function() {
            $('#reportTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "autoWidth": true
            });
        });
    </script>

@endsection

