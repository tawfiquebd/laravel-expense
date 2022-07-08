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
                                <h4>Create Book</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('category.store') }}" method="POST">
                                    @csrf

                                    @includeIf('.backend.partials.response-message')

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control"
                                               value="{{ $category ? $category->name : '' }}" name="name" id="name">
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
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d-m-y h:i:s') }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-warning"
                                                   href="{{ url('/category/edit', $category->id) }}"><i
                                                        class="fa fa-pencil"></i></a> |
                                                <button class="btn btn-sm btn-danger" type="submit"><i
                                                        class="fa fa-trash-o"></i></button>
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

@endsection
