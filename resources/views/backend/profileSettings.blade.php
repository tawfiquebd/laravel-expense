@extends('backend.layouts.master')

@section('title', 'Profile Settings')

@section('style')

@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Profile Settings</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Profile Settings</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Change User Info </h3>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Profile info updated successfully
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    @foreach($user as $userinfo)
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" id="name" value="{{ $userinfo->name }}" placeholder="Enter Name">

                                        @if($errors->has('name'))
                                            <small class="text-danger ml-1" >{{ $errors->first('name') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" name="email" class="form-control" id="email" value="{{ $userinfo->email }}" placeholder="Enter email">

                                        @if($errors->has('email'))
                                            <small class="text-danger ml-1" >{{ $errors->first('email') }}</small>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Change Password </h3>
                        </div>

                        <!-- Showing success message -->
                        @if(session('successPassword'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Password updated successfully
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <!-- Showing error message -->
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Old password doesn't matched!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="card-body">
                            <form action="{{ route('profile.password') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="old_password">Current Password</label>
                                        <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Old Password">
                                        @if($errors->has('old_password'))
                                            <small class="text-danger ml-1" >{{ $errors->first('old_password') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="New Password">
                                        @if($errors->has('password'))
                                            <small class="text-danger ml-1" >{{ $errors->first('password') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password">
                                        @if($errors->has('password_confirmation'))
                                            <small class="text-danger ml-1" >{{ $errors->first('password_confirmation') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-danger">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')

@endsection
