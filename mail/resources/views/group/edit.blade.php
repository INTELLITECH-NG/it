@extends('layouts.master')

@section('title', 'Edit Group')

@section('breadcrumb')
    <li><a href="{{ url('/group') }}">Group</a></li> 
    <li class="active">Edit Group</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'PUT','route' => ['group.update', $group->id]]) !!}
              <div class="box-body">
                
                {!! csrf_field() !!}

                <!-- ID -->
                <input type="hidden" name="id" value="{{ $group->id }}" />

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Group Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Group Name" value="{{ $group->name }}" />
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer text-center">
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
              </div>
            {!! Form::close() !!}
          </div>
        </div>
    </div>
</div>
@endsection
