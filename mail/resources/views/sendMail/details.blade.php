@extends('layouts.master')

@section('title', '- Send Mail Details')

@section('content-header', 'Send Mail Details')

@section('breadcrumb')
    <li><a href="{{ url('/sendMail') }}">Send Mail</a></li>
    <li class="active">Mail Details</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-header text-center">
              <p class="text-right">
                  <a class="btn btn-info" href="{{ url('/sendMail/form') }}">Send New Mail</a>
                  <a class="btn btn-info" href="{{ url('/sendMail') }}">Send Mail List</a>
              </p>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'POST','route' => ['sendMail.mail'],'class' => '', 'files' => true]) !!}
              {!! csrf_field() !!}
              <div class="box-body">
                  <div class="form-group">
                    <label for="mailer">Sender Email</label>
                    <input type="text" name="name" class="form-control" id="name" required="" placeholder="Enter Name" readonly="" value="{{ $sendMails->smtp_mail }}" />
                  </div>
                  <div class="form-group">
                    <label for="rec_email">Recipient Email / Emails</label>
                    <select multiple data-role="tagsinput" name="rec_email[]" class="form-control" id="rec_email">
                      @foreach($sendMail_emails as $email)
                        <option selected="" value="{{ $email->recipient_mail }}"> {{ $email->recipient_mail }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="name">Sender Name / Company Name</label>
                    <input type="text" name="name" class="form-control" id="name" required="" placeholder="Enter Name" readonly="" value="{{ $sendMails->name }}" />
                  </div>
                  <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" name="subject" class="form-control" id="subject" required="" placeholder="Enter Subject" readonly="" value="{{ $sendMails->subject }}" />
                  </div>
                  <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" class="form-control" rows="4" readonly="" placeholder="Enter Message...">{{ $sendMails->message }}</textarea>
                  </div>
                </div>
              <!-- /.box-body -->
            {!! Form::close() !!}
          </div>
          <!-- /.box -->
        </div>
    </div>

</section>
@endsection

@section('scripts')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=5py5oufiwnzc1dm5kgux2wz6ixg9im2b6gyfvlclt43vhbf9"></script>
    <script>
        tinymce.init({
          selector: 'textarea',
          height: 100,
          menubar: false,
          plugins: [],
         toolbar1: false,
         image_advtab: true,
         templates: [],

          content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css']
        });
    </script>

@endsection