@extends('layouts.master')

@section('title', '- Add Group')

@section('links')
@endsection

@section('content-header', 'Add Group')

@section('breadcrumb')
    <li><a href="{{ url('/group') }}">Group</a></li>
    <li class="active">Add Group</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-header text-center">
              <p class="text-right">
                  <a class="btn btn-info" href="{{ url('/group') }}">Group List</a>
              </p>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'POST','route' => ['group.store'],'class' => '']) !!}
              {!! csrf_field() !!}
              <div class="box-body">
                <!-- Name -->
                <div class="form-group">
                    <label for="name">Group Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Group Name" value="{{ old('name') }}" />
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer text-center">
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Add Group</button>
              </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->

        </div>
    </div>

</section>
@endsection