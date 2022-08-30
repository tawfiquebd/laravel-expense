@extends('backend.layouts.master')

@section('title', 'Categories')

@section('style')
    <style>

        table {
            width: 100%;
        }

        table th,
        table td {
            border: 1px solid #000;
            text-align: center;
            padding: 2px;
            font-size: 14px;
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
                        <h1 class="m-0 text-dark">Categories</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
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
                                <h4>Create Category</h4>
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

                                                    @if($errors->has('name'))
                                                    <span class="text-danger"> {{ $errors->first('name') }}</span>
                                                    @endif
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
                                <h4>Category List</h4>
                            </div>
                            <div class="card-body">
                                <table >
                                    <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Name</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($categories as $category)
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
                                                    <button id="button{{ $category->id }}" class="btn btn-sm btn-danger"
                                                            onclick="deleteBookFunc({{ $category->id }})"
                                                            type="button"><i
                                                            class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <p class="text-bold text-center">No Data Found</p>
                                    @endforelse
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

        function deleteBookFunc(id) {
            var button = document.getElementById('button'+id);

            Swal.fire({
                title: 'Are you sure to delete this Category?',
                text: "All expenses under this category will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'

            }).then((result) => {
                if(result.isConfirmed
        )
            {
                button.closest('form').submit();
                setTimeout(function () {
                    Swal.fire(
                        'Deleted!',
                        'Your Category has been deleted.',
                        'success'
                    )
                }, 500)

            }
        })
            ;
        }


    </script>

@endsection
