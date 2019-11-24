@extends('layouts.master')

@section('title', '- Edit Mailer')

@section('links')
@endsection

@section('content-header', 'Edit Mailer')

@section('breadcrumb')
    <li><a href="{{ url('/mailer') }}">Mailer</a></li>
    <li class="active">Edit Mailer</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-header text-center">
              <p class="text-right">
                  <a class="btn btn-info" href="{{ url('/mailer/create') }}">Add Mailer</a>
                  <a class="btn btn-info" href="{{ url('/mailer') }}">Mailer List</a>
              </p>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'PUT','route' => ['mailer.update', $mailer->id]]) !!}
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="form-group">
                  <label for="driver">Mail Driver</label>
                  <input type="text" name="driver" class="form-control" id="driver" placeholder="Enter Mail Driver" value="{{ $mailer->driver }}" />
                </div>
                <div class="form-group">
                  <label for="host">Mail Host</label>
                  <input type="text" name="host" class="form-control" id="host" placeholder="Enter Mail Host" value="{{ $mailer->host }}" />
                </div>
                <div class="form-group">
                  <label for="port">Mail Port</label>
                  <input type="text" name="port" class="form-control" id="port" placeholder="Enter Mail Port" value="{{ $mailer->port }}" />
                </div>
                <div class="form-group">
                  <label for="username">Email ID</label>
                  <input type="text" name="username" class="form-control" id="username" placeholder="Enter Email ID" value="{{ $mailer->username }}" />
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" value="{{ $mailer->password }}" />
                </div>
                <div class="form-group">
                  <label for="encryption">Encryption</label>
                  <input type="text" name="encryption" class="form-control" id="encryption" placeholder="Enter Encryption" value="{{ $mailer->encryption }}" />
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer text-center">
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
              </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->

        </div>
    </div>

</section>
@endsection