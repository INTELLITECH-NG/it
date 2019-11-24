@extends('layouts.master')

@section('title', '- Send Mail')

@section('content-header', 'Send Mail')

@section('breadcrumb')
    <li><a href="{{ url('/sendMail') }}">Send Mail</a></li>
    <li class="active">New Mail</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <div class="box-header text-center">
              <p class="text-right">
                  <a class="btn btn-info" href="{{ url('/sendMail') }}">Send Mail List</a>
              </p>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'POST','route' => ['sendMail.mail'],'class' => '', 'files' => true]) !!}
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="col-md-6 borderRight">
                  <div class="form-group">
                    <label for="mailer">Sender Email</label>
                    <select name="mailer" class="form-control select2" required="">
                        <option value=""> </option>
                        @foreach($mailers as $mailer)
                            <option value="{{ $mailer->username }}">{{ $mailer->username }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="file">Emails from File (txt, xlsx, xls, csv)</label>
                    <p class="help-block">Download the Demo files and Follow the structure <a class="bn btn-sm btn-success" href="{{ asset('assets/files/sample-excel.xlsx') }}" download>Demo Excel</a> <a class="bn btn-sm btn-success" href="{{ asset('assets/files/sample-text.txt') }}" download>Demo Text</a></p>
                    <input type="file" name="file" id="file" class="form-control" />
                  </div>
                  <div class="form-group">
                    <label for="groups">Emails from Group</label>
                    <select name="groups[]" multiple="multiple" class="form-control select2">
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="emails">Emails from List</label>
                    <select name="emails[]" multiple="multiple" class="form-control select2">
                        @foreach($emails as $email)
                            <option value="{{ $email->email }}">{{ $email->email }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="rec_email">Recipient Email / Emails</label>
                    <p class="help-block">Use Comma or enter to seperate Emails. Do Not Use Space</p>
                    <select multiple data-role="tagsinput" name="rec_email[]" class="form-control" id="rec_email"></select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Sender Name / Company Name</label>
                    <input type="text" name="name" class="form-control" id="name" required="" value="{{ old('name') }}" />
                  </div>
                  <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" name="subject" class="form-control" id="subject" required="" value="{{ old('subject') }}" />
                  </div>
                  <div class="form-group">
                    <label for="message">Message</label>
                    <p class="help-block">Use Image from Online Image sources.</p>
                    <textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter Message...">{{ old('message') }}</textarea>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer text-center">
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Send Mail</button>
              </div>
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
          plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code help'
          ],
         toolbar1: ' styleselect | fontselect | fontsizeselect | searchreplace insertdatetime charmap | bold italic underline strikethrough subscript superscript | alignleft aligncenter alignright alignjustify |  bullist numlist | forecolor backcolor | blockquote link unlink table | image media  | code preview ',
         image_advtab: true,
         templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            
          relative_urls : false,
          remove_script_host : false,
          convert_urls : true,

          content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css']
        });
    </script>

@endsection