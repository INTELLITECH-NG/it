@extends('layouts.master')

@section('title', '- User List')

@section('links')
@endsection

@section('content-header', 'User List')

@section('breadcrumb')
    <li><a href="#">User</a></li> 
    <li class="active">User List</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-header text-center">
              <p class="text-right">
                  <a class="btn btn-info" href="{{ url('/user/create') }}">Add User</a>
              </p>
            </div>
              <div class="box-body">
                  <table id="table" class="table table-bordered dt-responsive">
                      <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Date Created</th>
                        @if(Auth::user()->hasRole('admin'))
                        <th>Action</th>
                        @endif
                      </tr>
                      </thead>
                      <tbody>
                      @php $i= 1; @endphp
                      @foreach ($users as $user)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles[0]->display_name }}</td>
                        <td>{{ $user->created_at->format('d M, Y') }}</td>
                        @if(Auth::user()->hasRole('admin'))
                        <td class="text-center">  
                          <a class="btn btn-primary" href="{{ route('user.edit',$user->id) }}" style="display:inline">Edit</a>
                          <a class="btn btn-danger"  data-id="{{ $user->id }}" style="display:inline">Delete</a>
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
                        <th>Role</th>
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
      var auth = "<?php echo Auth::user()->id; ?>"; 
      if( id != auth){
          swal({
                  title: "Are you sure!",
                  text: "You want to Delete This User Account?",
                  type: "error",
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Yes!",
                  confirmButtonColor: "#DD6B55",
                  showCancelButton: true,
              },
              function() {
                  $.ajaxSetup({
                      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
                  });
                  $.ajax({
                      type: "Post",
                      url: "{{url('user/delete')}}",
                      data: {id:id},
                      success: function (res) {
                          console.log(res);
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
      }else{
          swal({
              title: "Sorry Dear!",
              text: "You can not Delete your own Account.",
              type: "info",
              showConfirmButton: false,
              timer: 3500
          });
      }
  });
</script>
@endsection
