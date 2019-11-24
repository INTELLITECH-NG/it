@extends('layouts.master')

@section('title', '- Group List')

@section('links')
@endsection

@section('content-header', 'Group List')

@section('breadcrumb')
    <li><a href="{{ url('/group') }}">Group</a></li> 
    <li class="active">Group List</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
              <div class="box-header text-center">
                  <p class="text-right">
                      <a class="btn btn-info" href="{{ url('/group/create') }}">Add Group</a>
                  </p>
              </div>
              <div class="box-body">
                  <table id="table" class="table table-bordered dt-responsive">
                      <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Date Created</th>
                        @if(Auth::user()->hasRole('admin'))
                        <th>Action</th>
                        @endif
                      </tr>
                      </thead>
                      <tbody>
                      @php $i= 1; @endphp
                      @foreach ($groups as $group)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $group->name }}</td>
                        <td>{{ $group->created_at->format('d M, Y') }}</td>
                        @if(Auth::user()->hasRole('admin'))
                        <td class="text-center">
                            <a class="btn btn-info" href="{{ url('emails/group',['group' => $group->name]) }}" style="display:inline">View</a>
                            <a class="btn btn-primary" href="{{ route('group.edit',$group->id) }}" style="display:inline">Edit</a>
                            <a class="btn btn-danger"  data-id="{{$group->id}}" style="display:inline">Delete</a>
                        </td>
                        @endif
                      </tr>
                      @endforeach
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Sl</th>
                        <th>Name</th>
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
              text: "You want to Delete This Group?",
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
                  url: "{{url('group/delete')}}",
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
