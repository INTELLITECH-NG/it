<!-- Main content -->
<section class="content">

    <!-- Your Page Content Here -->

    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
        <div class="box-header with-border bg-primary-dark">
            <h3 class="box-title">Select2</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Minimal</label>
                        <select class="form-control select2" style="width: 100%;">
                            <option selected="selected">Alabama</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label>Disabled</label>
                        <select class="form-control select2" disabled="disabled" style="width: 100%;">
                            <option selected="selected">Alabama</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Multiple</label>
                        <select class="form-control select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                            <option>Alabama</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label>Disabled Result</label>
                        <select class="form-control select2" style="width: 100%;">
                            <option selected="selected">Alabama</option>
                            <option>Alaska</option>
                            <option disabled="disabled">California (disabled)</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin.
        </div>
    </div>
    <!-- /.box -->





    <div class="row">
        <div class="col-md-6">

            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title">Input masks</h3>
                </div>
                <div class="box-body">
                    <!-- Date dd/mm/yyyy -->
                    <div class="form-group">
                        <label>Date masks:</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <!-- Date mm/dd/yyyy -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <!-- phone mask -->
                    <div class="form-group">
                        <label>US phone mask:</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <input type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <!-- phone mask -->
                    <div class="form-group">
                        <label>Intl US phone mask:</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <input type="text" class="form-control" data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" data-mask>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <!-- IP mask -->
                    <div class="form-group">
                        <label>IP mask:</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-laptop"></i>
                            </div>
                            <input type="text" class="form-control" data-inputmask="'alias': 'ip'" data-mask>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Color & Time Picker</h3>
                </div>
                <div class="box-body">
                    <!-- Color Picker -->
                    <div class="form-group">
                        <label>Color picker:</label>
                        <input type="text" class="form-control my-colorpicker1">
                    </div>
                    <!-- /.form group -->

                    <!-- Color Picker -->
                    <div class="form-group">
                        <label>Color picker with addon:</label>

                        <div class="input-group my-colorpicker2">
                            <input type="text" class="form-control">

                            <div class="input-group-addon">
                                <i></i>
                            </div>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <!-- time Picker -->
                    <div class="bootstrap-timepicker">
                        <div class="form-group">
                            <label>Time picker:</label>

                            <div class="input-group">
                                <input type="text" class="form-control timepicker">

                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
        <!-- /.col (left) -->
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Date picker</h3>
                </div>
                <div class="box-body">
                    <!-- Date -->
                    <div class="form-group">
                        <label>Date:</label>

                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <!-- Date range -->
                    <div class="form-group">
                        <label>Date range:</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="reservation">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <!-- Date and time range -->
                    <div class="form-group">
                        <label>Date and time range:</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="reservationtime">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <!-- Date and time range -->
                    <div class="form-group">
                        <label>Date range button:</label>

                        <div class="input-group">
                            <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> Date range picker
                    </span>
                                <i class="fa fa-caret-down"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.form group -->

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- iCheck -->
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">iCheck - Checkbox &amp; Radio Inputs</h3>
                </div>
                <div class="box-body">
                    <!-- Minimal style -->

                    <!-- checkbox -->
                    <div class="form-group">
                        <label>
                            <input type="checkbox" class="minimal" checked>
                        </label>
                        <label>
                            <input type="checkbox" class="minimal">
                        </label>
                        <label>
                            <input type="checkbox" class="minimal" disabled>
                            Minimal skin checkbox
                        </label>
                    </div>

                    <!-- radio -->
                    <div class="form-group">
                        <label>
                            <input type="radio" name="r1" class="minimal" checked>
                        </label>
                        <label>
                            <input type="radio" name="r1" class="minimal">
                        </label>
                        <label>
                            <input type="radio" name="r1" class="minimal" disabled>
                            Minimal skin radio
                        </label>
                    </div>

                    <!-- Minimal red style -->

                    <!-- checkbox -->
                    <div class="form-group">
                        <label>
                            <input type="checkbox" class="minimal-red" checked>
                        </label>
                        <label>
                            <input type="checkbox" class="minimal-red">
                        </label>
                        <label>
                            <input type="checkbox" class="minimal-red" disabled>
                            Minimal red skin checkbox
                        </label>
                    </div>

                    <!-- radio -->
                    <div class="form-group">
                        <label>
                            <input type="radio" name="r2" class="minimal-red" checked>
                        </label>
                        <label>
                            <input type="radio" name="r2" class="minimal-red">
                        </label>
                        <label>
                            <input type="radio" name="r2" class="minimal-red" disabled>
                            Minimal red skin radio
                        </label>
                    </div>

                    <!-- Minimal red style -->

                    <!-- checkbox -->
                    <div class="form-group">
                        <label>
                            <input type="checkbox" class="flat-red" checked>
                        </label>
                        <label>
                            <input type="checkbox" class="flat-red">
                        </label>
                        <label>
                            <input type="checkbox" class="flat-red" disabled>
                            Flat green skin checkbox
                        </label>
                    </div>

                    <!-- radio -->
                    <div class="form-group">
                        <label>
                            <input type="radio" name="r3" class="flat-red" checked>
                        </label>
                        <label>
                            <input type="radio" name="r3" class="flat-red">
                        </label>
                        <label>
                            <input type="radio" name="r3" class="flat-red" disabled>
                            Flat green skin radio
                        </label>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    Many more skins available. <a href="http://fronteed.com/iCheck/">Documentation</a>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col (right) -->
    </div>
    <!-- /.row -->




</section>
<!-- /.content -->




<!-- Terms Modal -->
<div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Terms &amp; Conditions</h3>
                </div>
                <div class="block-content">
                    <h4 class="push-10">1. <strong>General</strong></h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta. Integer fermentum tincidunt auctor.</p>
                    <h4 class="push-10">2. <strong>Account</strong></h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta. Integer fermentum tincidunt auctor.</p>
                    <h4 class="push-10">3. <strong>Service</strong></h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta. Integer fermentum tincidunt auctor.</p>
                    <h4 class="push-10">4. <strong>Payments</strong></h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta. Integer fermentum tincidunt auctor.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary" type="button" data-dismiss="modal"><i class="fa fa-check"></i> Ok</button>
            </div>
        </div>
    </div>
</div>
<!-- END Terms Modal -->

<div class="row">
    <div class="col-md-12">
        <form class="js-validation-bootstrap form-horizontal" action="base_forms_validation.html" method="post">
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-username">Username <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" id="val-username" name="val-username" placeholder="Choose a nice username..">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-email">Email <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" id="val-email" name="val-email" placeholder="Enter your valid email..">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-password">Password <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input class="form-control" type="password" id="val-password" name="val-password" placeholder="Choose a good one..">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-confirm-password">Confirm Password <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input class="form-control" type="password" id="val-confirm-password" name="val-confirm-password" placeholder="..and confirm it to be safe!">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-select2">Select2</label>
                <div class="col-md-7">
                    <select class="js-select2 form-control" id="val-select2" name="val-select2" style="width: 100%;" data-placeholder="Choose one..">
                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                        <option value="1">HTML</option>
                        <option value="2">CSS</option>
                        <option value="3">JavaScript</option>
                        <option value="4">PHP</option>
                        <option value="5">MySQL</option>
                        <option value="6">Ruby</option>
                        <option value="7">AngularJS</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-select2-multiple">Select2 Multiple</label>
                <div class="col-md-7">
                    <select class="js-select2 form-control" id="val-select2-multiple" name="val-select2-multiple" style="width: 100%;" data-placeholder="Choose at least two.." multiple>
                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                        <option value="1">HTML</option>
                        <option value="2">CSS</option>
                        <option value="3">JavaScript</option>
                        <option value="4">PHP</option>
                        <option value="5">MySQL</option>
                        <option value="6">Ruby</option>
                        <option value="7">AngularJS</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-suggestions">Suggestions <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <textarea class="form-control" id="val-suggestions" name="val-suggestions" rows="18" placeholder="Share your ideas with us.."></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-skill">Best Skill <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <select class="form-control" id="val-skill" name="val-skill">
                        <option value="">Please select</option>
                        <option value="html">HTML</option>
                        <option value="css">CSS</option>
                        <option value="javascript">JavaScript</option>
                        <option value="ruby">Ruby</option>
                        <option value="php">PHP</option>
                        <option value="asp">ASP.NET</option>
                        <option value="python">Python</option>
                        <option value="mysql">MySQL</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-currency">Currency <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" id="val-currency" name="val-currency" placeholder="$30.50">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-website">Website <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" id="val-website" name="val-website" placeholder="http://example.com">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-phoneus">Phone (US) <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" id="val-phoneus" name="val-phoneus" placeholder="212-999-0000">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-digits">Digits <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" id="val-digits" name="val-digits" placeholder="3">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-number">Number <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" id="val-number" name="val-number" placeholder="3.0">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-range">Range [1, 5] <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" id="val-range" name="val-range" placeholder="3">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label"><a data-toggle="modal" data-target="#modal-terms" href="#">Terms</a> <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <label class="css-input css-checkbox css-checkbox-primary" for="val-terms">
                        <input type="checkbox" id="val-terms" name="val-terms" value="1"><span></span> I agree to the terms
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>






