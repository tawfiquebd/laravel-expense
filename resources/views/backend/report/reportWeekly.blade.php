@extends('backend.layouts.master')

@section('title', 'Weekly Report')

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
                            <li class="breadcrumb-item active">Weekly Report</li>
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
                            <h3 class="card-title">Weekly Report </h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="reportTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>SL.</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Total Cost (Tk)</th>
                                </tr>
                                </thead>

                                <tbody>
                                @php
                                    $i = 0;
                                @endphp

                                @foreach($expense as $exp)

                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $previousDate }}</td>
                                        <td>{{ $todayDate }}</td>
                                        <td>{{ $exp->total }}</td>
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

