@extends('layouts.master')

@section('title')
- Email List in {{ $group }}
@endsection

@section('links')
@endsection

@section('content-header')
Email List in {{ $group }}
@endsection

@section('breadcrumb')
    <li><a href="{{ url('/group') }}">Group</a></li>
    <li class="active">Email List</li>
</ol>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
              <div class="box-header text-center">
                  <p class="text-right">
                      <a class="btn btn-info" href="{{ url('/group/create') }}">Add Group</a>
                      <a class="btn btn-info" href="{{ url('/group') }}">Group List</a>
                  </p>
              </div>
              <div class="box-body">
                  <table id="table" class="table table-bordered dt-responsive">
                      <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>email</th>
                        <th>Address</th>
                        <th>Remarks</th>
                        <th>Date Created</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      @php $i= 1; @endphp
                      @foreach ($emails as $email)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $email->name }}</td>
                        <td>{{ $email->email }}</td>
                        <td>{{ $email->address }}</td>
                        <td>{{ $email->remarks }}</td>
                        <td>{{ $email->created_at->format('d M, Y') }}</td>
                        <td class="text-center">  
                          <b><a class="btn btn-primary" href="{{ route('email.edit',$email->id) }}" style="display:inline">Edit</a>
                          {!! Form::open(['method' => 'DELETE','route' => ['email.destroy', $email->id],'style'=>'display:inline']) !!}
                          {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                          {!! Form::close() !!}
                        </td>
                      </tr>
                      @endforeach
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>email</th>
                        <th>Address</th>
                        <th>Remarks</th>
                        <th>Date Created</th>
                        <th>Action</th>
                      </tr>
                      </tfoot>
                  </table>
              </div>
          </div>
          <!-- /.box -->

        </div>
    </div>

</section>
@endsection