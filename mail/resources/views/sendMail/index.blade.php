@extends('layouts.master')

@section('title', '- Send Mail List')

@section('links')
@endsection

@section('content-header', 'Send Mail List')

@section('breadcrumb')
    <li><a href="{{ url('/sendMail') }}">Send Mail</a></li> 
    <li class="active">Send Mail List</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-header text-center">
              <p class="text-right">
                  <a class="btn btn-info" href="{{ url('/sendMail/form') }}">Send New Mail</a>
              </p>
            </div>
              <div class="box-body">
                  <table id="table" class="table table-bordered dt-responsive">
                      <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Sender</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Recipients</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      @php $i= 1; @endphp
                      @foreach ($sendMails as $email)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $email->smtp_mail }}</td>
                        <td>{{ $email->name }}</td>
                        <td>{{ $email->subject }}</td>
                        <td>{{ str_limit(strip_tags($email->message), 200) }}...</td>
                        <td>{{ $email->recipients }}</td>
                        <td class="text-center">
                          <a class="btn btn-info" href="{{ url('sendMail/details',['email' => $email->id]) }}" style="display:inline">Details</a>
                          <a class="btn btn-danger"  data-id="{{$email->id}}" style="display:inline">Delete</a>
                        </td>
                      </tr>
                      @endforeach
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Sl</th>
                        <th>Sender</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Recipients</th>
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

@section('scripts')
<script type="text/javascript" charset="UTF-8">
  $(document).on('click', '.btn-danger', function (e) {
      e.preventDefault();
      var id = $(this).data('id');
      swal({
              title: "Are you sure!",
              text: "You want to Delete This Mail Details?",
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
                  url: "{{url('sendMail/delete')}}",
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
