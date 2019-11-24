@extends('layouts.master')

@section('title', '- Add Mailer')

@section('links')
@endsection

@section('content-header', 'Add Mailer')

@section('breadcrumb')
    <li><a href="{{ url('/mailer') }}">Mailer</a></li>
    <li class="active">Add Mailer</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-header text-center">
              <p class="text-right">
                  <a class="btn btn-info" href="{{ url('/mailer') }}">Mailer List</a>
              </p>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'POST','route' => ['mailer.store'],'class' => '']) !!}
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="form-group">
                  <label for="driver">Mail Driver</label>
                  <input type="text" name="driver" class="form-control" id="driver" placeholder="Enter Mail Driver" value="{{ old('driver') }}" />
                </div>
                <div class="form-group">
                  <label for="host">Mail Host</label>
                  <input type="text" name="host" class="form-control" id="host" placeholder="Enter Mail Host" value="{{ old('host') }}" />
                </div>
                <div class="form-group">
                  <label for="port">Mail Port</label>
                  <input type="text" name="port" class="form-control" id="port" placeholder="Enter Mail Port" value="{{ old('port') }}" />
                </div>
                <div class="form-group">
                  <label for="username">Email ID</label>
                  <input type="text" name="username" class="form-control" id="username" placeholder="Enter Email ID" value="{{ old('username') }}" />
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" value="{{ old('password') }}" />
                </div>
                <div class="form-group">
                  <label for="encryption">Encryption</label>
                  <input type="text" name="encryption" class="form-control" id="encryption" placeholder="Enter Encryption" value="{{ old('encryption') }}" />
                </div>
              </div>
              <input type="hidden" name="status" value="
              @if(Auth::user()->hasRole('admin')) {{ '1' }} @else {{ '0' }} @endif
              " />
              <!-- /.box-body -->

              <div class="box-footer text-center">
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Add SMTP</button>
              </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->

        </div>
    </div>

</section>
@endsection