@extends('layouts.master')

@section('title', '- Mailer List')

@section('links')
@endsection

@section('content-header', 'Mailer List')

@section('breadcrumb')
    <li><a href="{{ url('/mailer') }}">Mailer</a></li> 
    <li class="active">Mailer List</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
              <div class="box-header text-center">
                  <p class="text-right">
                      <a class="btn btn-info" href="{{ url('/mailer/create') }}">Add Mailer</a>
                  </p>
              </div>
              <div class="box-body">
                  <table id="table" class="table table-bordered dt-responsive">
                      <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Email ID</th>
                        <th>Driver</th>
                        <th>Host</th>
                        <th>Port</th>
                        <th>Encryption</th>
                        @if(Auth::user()->hasRole('admin'))
                        <th>Password</th>
                        <th>Status</th>
                        <th>Action</th>
                        @endif
                      </tr>
                      </thead>
                      <tbody>
                      @php $i= 1; @endphp
                      @foreach ($mailers as $mailer)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $mailer->username }}</td>
                        <td>{{ $mailer->driver }}</td>
                        <td>{{ $mailer->host }}</td>
                        <td>{{ $mailer->port }}</td>
                        <td>{{ $mailer->encryption }}</td>
                        @if(Auth::user()->hasRole('admin'))
                        <td>{{ $mailer->password }}</td>
                        <td class="text-center">  
                          {!! Form::open(['method' => 'Put','route' => ['mailer.update.status', $mailer->id],'style'=>'display:inline']) !!}
                            <input type="hidden" name="status" value="{{ $mailer->id }}" />
                            <button type="submit" name="submit" id="submit" class="btn 
                            @if($mailer->status != 1) {{ "btn-success" }} @else {{ "btn-warning" }} @endif
                            btn-sm"> Make
                              @if($mailer->status != 1) {{ "Active" }} @else {{ "Deactive" }} @endif
                            </button>
                          {!! Form::close() !!}
                        </td>
                        <td class="text-center">  
                          <b><a class="btn btn-primary" href="{{ route('mailer.edit',$mailer->id) }}" style="display:inline">Edit</a>
                          {!! Form::open(['method' => 'DELETE','route' => ['mailer.destroy', $mailer->id],'style'=>'display:inline']) !!}
                          {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                          {!! Form::close() !!}
                        </td>
                        @endif
                      </tr>
                      @endforeach
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Sl</th>
                        <th>Email ID</th>
                        <th>Driver</th>
                        <th>Host</th>
                        <th>Port</th>
                        <th>Encryption</th>
                        @if(Auth::user()->hasRole('admin'))
                        <th>Password</th>
                        <th>Status</th>
                        <th>Action</th>
                        @endif
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

@section('scripts')
<script type="text/javascript" charset="UTF-8">
  $(document).on('click', '.btn-danger', function (e) {
      e.preventDefault();
      var id = $(this).data('id');
      swal({
              title: "Are you sure!",
              text: "You want to Delete This Mailer Setup?",
              type: "error",
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              showCancelButton: true,
          },
          function() {
              $.ajaxSetup({
                  headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
              });
              $.ajax({
                  type: "Post",
                  url: "{{url('mailer/delete')}}",
                  data: {id:id},
                  success: function () {
                    swal({
                      type: 'success',
                      title: 'Succesfully deleted!!',
                      text: "You have successfully Deleted this!",
                      timer: 5000
                    });
                    location.reload();    
                  }           
              });
      });
  });
</script>
@endsection
