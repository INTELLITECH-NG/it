@extends('layouts.master')

@section('title', '- User Registration')

@section('content-header', 'User Registration')

@section('breadcrumb')
    <li><a href="{{ url('/user') }}">User</a></li>
    <li class="active">Add User</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-header text-center">
              <p class="text-right">
                  <a class="btn btn-info" href="{{ url('/user') }}">User List</a>
              </p>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'POST','route' => ['user.store']]) !!}
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name') }}" />
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="{{ old('email') }}" />
                </div>
                <div class="form-group">
                  <label for="role">Role</label>
                    <select name="role" class="form-control select2">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="box-footer text-center">
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Add User</button>
              </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->

        </div>
    </div>

</section>
@endsection
