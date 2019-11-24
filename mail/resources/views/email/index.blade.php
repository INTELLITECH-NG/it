@extends('layouts.master')

@section('title', '- Email List')

@section('links')
@endsection

@section('content-header', 'Email List')

@section('breadcrumb')
    <li><a href="{{ url('/email') }}">Email</a></li> 
    <li class="active">Email List</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
              <div class="box-header text-right">
                  <span>
                      <a class="btn btn-info" href="{{ url('/email/create') }}">Add Email</a>
                      <a class="btn btn-info" href="{{ url('/email/import') }}">Import Email</a>
                  </span>
              </div>
              <div class="box-body">
                  <table id="table" class="table table-bordered dt-responsive">
                      <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>email</th>
                        <th>Group</th>
                        <th>Address</th>
                        <th>Remarks</th>
                        <th>Date Created</th>
                        @if(Auth::user()->hasRole('admin'))
                        <th>Action</th>
                        @endif
                      </tr>
                      </thead>
                      <tbody>
                      @php $i= 1; @endphp
                      @foreach ($emails as $email)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $email->name }}</td>
                        <td>{{ $email->email }}</td>
                        <td>@if($email->group_id != null){{ $email->group->name }}@else{{ "-" }} @endif</td>
                        <td>{{ $email->address }}</td>
                        <td>{{ $email->remarks }}</td>
                        <td>{{ $email->created_at->format('d M, Y') }}</td>
                        @if(Auth::user()->hasRole('admin'))
                        <td class="text-center">  
                          <a class="btn btn-primary" href="{{ route('email.edit',$email->id) }}" style="display:inline">Edit</a>
                          <a class="btn btn-danger"  data-id="{{$email->id}}" style="display:inline">Delete</a>
                        </td>
                        @endif
                      </tr>
                      @endforeach
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>email</th>
                        <th>Group</th>
                        <th>Address</th>
                        <th>Remarks</th>
                        <th>Date Created</th>
                        @if(Auth::user()->hasRole('admin'))
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
          text: "You want to Delete This Email Account?",
          type: "error",
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          confirmButtonColor: "#DD6B55",
          showCancelButton: true,
      },
      function(){  
          $.ajaxSetup({
              headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
          });
          $.ajax({
              type: "Post",
              url: "{{url('email/delete')}}",
              data: {id:id},
              success: function () {
                swal({
                  type: 'success',
                  title: 'Succesfully deleted!!',
                  text: "You have successfully Deleted this!",
                  showConfirmButton: false,
                  timer: 5000
                });
                location.reload();  
              }         
          });
      });
  });
</script>
@endsection
