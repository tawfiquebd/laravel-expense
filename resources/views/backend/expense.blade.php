@extends('backend.layouts.master')

@section('title', 'Expense')

@section('style')

@endsection


@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Expense</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Expense</li>
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
                            <h3 class="card-title">All Expenses
                                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addModal">Add Expense</button>
                            </h3>
                        </div>

                        <!-- Showing validation error -->
                        @include('backend.partials.showError')

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Name</th>
                                        <th>Cost (Tk)</th>
                                        <th>Created_at</th>
                                        <th>Updated_at</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $expense->name }}</td>
                                    <td>{{ $expense->cost }}</td>
                                    <td>{{ $expense->created_at->format('d-M-Y H:i:s') }}</td>
                                    <td>{{ $expense->updated_at->format('d-M-Y H:i:s') }}</td>
                                    <td><button data-toggle="modal" data-target="#editModal-{{$expense->id}}" class="btn btn-warning"><i class="fa fa-pencil"></i></button></td>
                                    <td><button onclick="document.getElementById('deleteForm').submit();" class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button></td>
                                    <form id="deleteForm" method="POST" action="{{ route('expense.delete', $expense->id) }}">
                                        @csrf
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

@include('backend.partials.addExpenseModal')
@include('backend.partials.editExpenseModal')

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
