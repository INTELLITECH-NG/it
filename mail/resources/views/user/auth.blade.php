@extends('layouts.master')

@section('title', '- Edit User')

@section('content-header', 'Edit User')

@section('breadcrumb')
    <li><a href="{{ url('/user') }}">User</a></li>
    <li class="active">Edit User</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-haeder text-center">
              <h3>Basic Info</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'PUT','route' => ['user.update', $user->id]]) !!}
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{ $user->name }}" />
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="{{ $user->email }}" />
                </div>
              <div class="box-footer text-center">
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
              </div>
            </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-4">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-haeder text-center">
              <h3>Change Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'PUT','route' => ['user.updatePassword', 'id' => $user->id]]) !!}
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="form-group">
                  <label for="name">New Password</label>
                  <input type="password" name="new_password" class="form-control" placeholder="Enter New Password" />
                </div>
                <div class="form-group">
                  <label for="name">Re-Type Password</label>
                  <input type="password" name="con_password" class="form-control" placeholder="Re-Type Password" />
                </div>
              <div class="box-footer text-center">
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
              </div>
            </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->
        </div>
    </div>

</section>
@endsection
