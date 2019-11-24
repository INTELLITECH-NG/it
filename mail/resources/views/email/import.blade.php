@extends('layouts.master')

@section('title', '- Import Email')

@section('links')
@endsection

@section('content-header', 'Import Email')

@section('breadcrumb')
    <li><a href="#">Email</a></li>
    <li class="active">Import Email</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-header text-center">
              <p class="text-right">
                  <a class="btn btn-info" href="{{ url('/email/create') }}">Add Email</a>
                  <a class="btn btn-info" href="{{ url('/email') }}"> Email List</a>
              </p>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'import-emails','method'=>'POST','files'=>'true']) !!}
              {!! csrf_field() !!}
              <div class="box-body">
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
                  <label for="sample_file">Select File to Import (txt, xlsx, xls, csv)</label>
                  {!! Form::file('sample_file', array('class' => 'form-control')) !!}
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
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-header text-center">
              <h3>Sample Files</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <div class="form-group">
                  <label for="group_id">Excel File</label>
                  <div>
                    Download the sample file, Edit the data excluding the first row and upload it. <a href="{{ asset('assets/files/sample-excel.xlsx') }}" download><button class="btn btn-sm btn-success">Download Excel</button></a>
                  </div>
                </div>
                <div class="form-group">
                  <label for="group_id">Text File</label>
                  <div>
                    Download the sample file, Edit the emails and upload it. (Do not Use any Space) <a href="{{ asset('assets/files/sample-text.txt') }}" download><button class="btn btn-sm btn-success">Download Text</button></a>
                  </div>
                </div>
                <p class="text-center">No need to download if you already have the file.</p>
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>

</section>
@endsection