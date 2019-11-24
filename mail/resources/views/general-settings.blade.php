@extends('layouts.master')

@section('title', '- General Settings')

@section('links')
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-fileinput/bootstrap-fileinput.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/iCheck/square/blue.css') }}">
  <style>
    label > input{ /* HIDE RADIO */
      visibility: hidden; /* Makes input not-clickable */
      position: absolute; /* Remove input from document flow */
    }
    label > .checked + div > .full-opacity-hover{ /* (RADIO CHECKED) IMAGE STYLES */
      opacity: 1;
    }
  </style>
@endsection

@section('content-header', 'General Settings')

@section('breadcrumb')
    <li class="active">General Settings</li>
@endsection

@section('content')
<section class="content">
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <!-- general form elements -->
          <div class="box box-primary box-bg with-border">
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['method' => 'PUT','route' => ['general.update'], 'files' => true]) !!}
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="form-group">
                  <label for="name">Site Name</label>
                  <input type="name" name="name" class="form-control" id="name" placeholder="Enter Site Name" value="{{ $settings[0]['value']}}" required="" />
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>Site Logo</label><br>
                      <div class="fileinput fileinput-new" data-provides="fileinput">
                          <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 100px;">
                            <img src="{{ asset($settings[1]['value']) }}" alt="" />
                          </div>
                          <div>
                              <span class="btn btn-primary btn-file">
                                  <span class="fileinput-new"> Select image </span>
                                  <span class="fileinput-exists"> Change </span>
                                  <input type="file" name="logo"> </span>
                              <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> Remove </a>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label>Site Favicon</label><br>
                      <div class="fileinput fileinput-new" data-provides="fileinput">
                          <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 80px; height: 80px;">
                            <img src="{{ asset($settings[2]['value']) }}" alt="" />
                          </div>
                          <div>
                              <span class="btn btn-primary btn-file">
                                  <span class="fileinput-new"> Select image </span>
                                  <span class="fileinput-exists"> Change </span>
                                  <input type="file" name="favicon"> </span>
                              <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> Remove </a>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="welcome">Welcome Text</label>
                  <textarea name="welcome" id="welcome" class="form-control" rows="1" placeholder="Enter Welcome Text (maximum character limit : 100)" required >{{ $settings[3]['value']}}</textarea>
                </div>
                <div class="form-group">
                  <label for="footer">Footer Info</label>
                  <textarea name="footer" id="footer" class="form-control" rows="1" placeholder="Enter Footer Info (maximum character limit : 100)" required >{{ $settings[4]['value']}}</textarea>
                </div>
                <div class="form-group">
                  <label for="footer">Theme</label>
                  <div class="row">
                    <div class="col-md-2">
                      <label>
                        <input type="radio" name="theme" value="skin-blue" 
                          @if($settings[5]['value'] == "skin-blue") {{ 'checked' }} @endif
                        />
                        <div style="float:left; width: 60px; padding: 5px;">
                          <a href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                              <div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                              <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                          </a>
                          <p class="text-center no-margin">Blue</p>
                        </div>
                      </label>
                    </div>
                    <div class="col-md-2">
                      <label>
                        <input type="radio" name="theme" value="skin-black"
                          @if($settings[5]['value'] == "skin-black") {{ 'checked' }} @endif
                        />
                        <div style="float:left; width: 60px; padding: 5px;">
                          <a href="javascript:void(0)" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                              <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span></div>
                              <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                          </a>
                          <p class="text-center no-margin">Black</p>
                        </div>
                      </label>
                    </div>
                    <div class="col-md-2">
                      <label>
                        <input type="radio" name="theme" value="skin-purple"
                          @if($settings[5]['value'] == "skin-purple") {{ 'checked' }} @endif
                        />
                        <div style="float:left; width: 60px; padding: 5px;">
                            <a href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                                <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                            </a>
                            <p class="text-center no-margin">Purple</p>
                        </div>
                      </label>
                    </div>
                    <div class="col-md-2">
                      <label>
                        <input type="radio" name="theme" value="skin-green"
                          @if($settings[5]['value'] == "skin-green") {{ 'checked' }} @endif
                        />
                        <div style="float:left; width: 60px; padding: 5px;">
                          <a href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                              <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                              <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                          </a>
                          <p class="text-center no-margin">Green</p>
                        </div>
                      </label>
                    </div>
                    <div class="col-md-2">
                      <label>
                        <input type="radio" name="theme" value="skin-red"
                          @if($settings[5]['value'] == "skin-red") {{ 'checked' }} @endif
                        />
                        <div style="float:left; width: 60px; padding: 5px;">
                          <a href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                              <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                              <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                          </a>
                          <p class="text-center no-margin">Red</p>
                        </div>
                      </label>
                    </div>
                    <div class="col-md-2">
                      <label>
                        <input type="radio" name="theme" value="skin-yellow"
                          @if($settings[5]['value'] == "skin-yellow") {{ 'checked' }} @endif
                        />
                        <div style="float:left; width: 60px; padding: 5px;">
                          <a href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                              <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                              <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                          </a>
                          <p class="text-center no-margin">Yellow</p>
                        </div>
                      </label>
                    </div>
                    <div class="col-md-2">
                      <label>
                        <input type="radio" name="theme" value="skin-blue-light"
                          @if($settings[5]['value'] == "skin-blue-light") {{ 'checked' }} @endif
                        />
                        <div style="float:left; width: 60px; padding: 5px;">
                          <a href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                              <div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                              <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                          </a>
                          <p class="text-center no-margin" style="font-size: 12px">Blue Light</p>
                        </div>
                      </label>
                    </div>
                    <div class="col-md-2">
                      <label>
                        <input type="radio" name="theme" value="skin-black-light"
                          @if($settings[5]['value'] == "skin-black-light") {{ 'checked' }} @endif
                        />
                        <div style="float:left; width: 60px; padding: 5px;">
                          <a href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                              <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span></div>
                              <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                          </a>
                          <p class="text-center no-margin" style="font-size: 12px">Black Light</p>
                        </div>
                      </label>
                    </div>
                    <div class="col-md-2">
                      <label>
                        <input type="radio" name="theme" value="skin-purple-light"
                          @if($settings[5]['value'] == "skin-purple-light") {{ 'checked' }} @endif
                        />
                        <div style="float:left; width: 60px; padding: 5px;">
                            <a href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                                <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                            </a>
                            <p class="text-center no-margin" style="font-size: 12px">Purple Light</p>
                        </div>
                      </label>
                    </div>
                    <div class="col-md-2">
                      <label>
                        <input type="radio" name="theme" value="skin-green-light"
                          @if($settings[5]['value'] == "skin-green-light") {{ 'checked' }} @endif
                        />
                        <div style="float:left; width: 60px; padding: 5px;">
                          <a href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                              <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                              <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                          </a>
                          <p class="text-center no-margin" style="font-size: 12px">Green Light</p>
                        </div>
                      </label>
                    </div>
                    <div class="col-md-2">
                      <label>
                        <input type="radio" name="theme" value="skin-red-light"
                          @if($settings[5]['value'] == "skin-red-light") {{ 'checked' }} @endif
                        />
                        <div style="float:left; width: 60px; padding: 5px;">
                          <a href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                              <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                              <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                          </a>
                          <p class="text-center no-margin" style="font-size: 12px">Red Light</p>
                        </div>
                      </label>
                    </div>
                    <div class="col-md-2">
                      <label>
                        <input type="radio" name="theme" value="skin-yellow-light"
                          @if($settings[5]['value'] == "skin-yellow-light") {{ 'checked' }} @endif
                        />
                        <div style="float:left; width: 60px; padding: 5px;">
                          <a href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                              <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                              <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                          </a>
                          <p class="text-center no-margin" style="font-size: 12px">Yellow Light</p>
                        </div>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="checkbox icheck">
                        <label><input type="checkbox" name="powered_by" value="1"
                          @if($settings[6]['value'] == 1) {{ 'checked' }} @endif
                          > Show Powered By</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="checkbox icheck">
                        <label><input type="checkbox" name="version" value="1"
                         @if($settings[7]['value'] == 1) {{ 'checked' }} @endif 
                         > Show Version</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="meta_title">Meta Title</label>
                  <textarea name="meta_title" id="meta_title" class="form-control" rows="1" placeholder="Enter Meta Title (maximum character limit : 60)" required >{{ $settings[8]['value']}}</textarea>
                </div>
                <div class="form-group">
                  <label for="meta_desc">Meta Description</label>
                  <textarea name="meta_desc" id="meta_desc" class="form-control" rows="3" placeholder="Enter Meta Description (maximum character limit : 255)" required >{{ $settings[9]['value']}}</textarea>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer text-center">
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
              </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->

        </div>
    </div>

</section>
@endsection

@section('scripts')
  <script src="{{ asset('assets/bower_components/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
  <!-- iCheck -->
  <script src="{{ asset('assets/bower_components/iCheck/icheck.min.js') }}"></script>
  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        increaseArea: '10%' // optional
      });
    });
  </script>
@endsection