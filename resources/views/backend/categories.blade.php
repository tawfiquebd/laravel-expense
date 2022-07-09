@extends('backend.layouts.master')

@section('title', 'Categories')

@section('style')

@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Books</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Books</li>
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
                                <h4>Create Book</h4>
                            </div>
                            <div class="card-body">
                                @if(request()->is('category/*'))
                                    <form action="{{ url('/category/update', $category->id) }}" method="POST">
                                        @else
                                            <form action="{{ route('category.store') }}" method="POST">
                                                @endif
                                                @csrf

                                                @includeIf('.backend.partials.response-message')

                                                <div class=" form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control"
                                                           value="{{ $category ? $category->name : '' }}" name="name"
                                                           id="name">
                                                </div>
                                                @if(request()->is('category/*'))
                                                    <button type="submit" class="btn btn-sm btn-info">Update</button>
                                                @else
                                                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                                @endif
                                            </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Book List</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d-m-y h:i:s a') }}</td>
                                            <td class="d-flex justify-content-around">
                                                <a class="btn btn-sm btn-warning"
                                                   href="{{ url('/category/edit', $category->id) }}"><i
                                                        class="fa fa-pencil"></i></a>

                                                <form id="form" action="{{ url('/category/delete', $category->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $category->id }}">
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
                            {{ $categories->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
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

                }).then((result) => {
                    if (result.isConfirmed) {
                    form.submit();
                    setTimeout(function () {
                        Swal.fire(
                            'Deleted!',
                            'Your book has been deleted.',
                            'success'
                        )
                    }, 500)

                }
            });
        }



    </script>

@endsection
