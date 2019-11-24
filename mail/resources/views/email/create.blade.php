@extends('layouts.master')

@section('title', '- Add Email')

@section('links')
@endsection

@section('content-header', 'Add Email')

@section('breadcrumb')
    <li><a href="#">Email</a></li>
    <li class="active">Add Email</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-header text-center">
              <p class="text-right">
                  <a class="btn btn-info" href="{{ url('/email/import') }}">Import Email</a>
                  <a class="btn btn-info" href="{{ url('/email') }}"> Email List</a>
              </p>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'POST','route' => ['email.store'],'class' => '']) !!}
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
                  <label for="group_id">Group</label>
                    <select name="group_id" class="form-control select2">
                        <option value="">Select Group</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <textarea name="address" id="address" class="form-control" rows="2" placeholder="Enter Address (maximum character limit : 255)">{{ old('address') }}</textarea>
                </div>
                <div class="form-group">
                  <label for="remarks">Remarks</label>
                  <textarea name="remarks" id="remarks" class="form-control" rows="2" placeholder="Enter Remarks (maximum character limit : 255)">{{ old('remarks') }}</textarea>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer text-center">
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Add Email</button>
              </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->

        </div>
    </div>

</section>
@endsection