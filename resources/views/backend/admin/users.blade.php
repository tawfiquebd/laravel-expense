@extends('backend.admin.layouts.master')

@section('title', 'Users')

@section('style')

@endsection


@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Basic Users</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                            <h3 class="card-title">All Users</h3>
                        </div>

                    <!-- /.card-header -->
                        <div class="card-body">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>SL.</th>
                                    <th>Name</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Status</th>
                                </tr>
                                </thead>

                                <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach($basicUsers as $basicUser)

                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $basicUser->name }}</td>
                                            <td>{{ $basicUser->created_at->format('d-M-Y H:i:s') }}</td>
                                            <td>{{ $basicUser->updated_at->format('d-M-Y H:i:s') }}</td>

                                            <form action="{{ route('user.status', $basicUser->id) }}" method="POST">
                                                @csrf

                                                @if($basicUser->status == 1)
                                                <td><button type="submit" class="badge badge-success">Active</button></td>
                                                @elseif($basicUser->status == 0)
                                                <td><button type="submit" class="badge badge-danger">Disabled</button></td>
                                                @endif
                                            </form>

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
            $('#myTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "autoWidth": true
            });
        });

        // Sweet alert
        let success = "{{ session('success') ?? '' }}"
        let updateSuccess = "{{ session('update-success') ?? '' }}"
        let notFound = "{{ session('notfound') ?? '' }}"
        let deleteSuccess = "{{ session('delete-success') ?? '' }}"
        let deleteFailed = "{{ session('delete-failed') ?? '' }}"


        setTimeout(function() {
            if(success !== '') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Expense added successfully!',
                })
            }
            else if(updateSuccess !== '') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Expense updated successfully!',
                })
            }
            else if(notFound !== '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Expense not found to update!',
                })
            }
            else if(deleteSuccess !== '') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Expense deleted successfully!',
                })
            }
            else if(deleteFailed !== '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Expense not found to delete!',
                })
            }
        }, 500)


    </script>
@endsection
