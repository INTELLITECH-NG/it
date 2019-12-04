
<?php echo form_open('admin/settings/set_translations', $attribute = array('class' => 'form-horizontal')) ?>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title">Translate Language</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">

                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>

                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#btabs-navigation" data-toggle="tab">Navigation</a>
                    </li>
                    <li class="">
                        <a href="#btabs-body" data-toggle="tab">Body</a>
                    </li>
                    <li class="">
                        <a href="#btabs-title" data-toggle="tab">Heading/Title/Button</a>
                    </li>
                    <li class="">
                        <a href="#btabs-msg" data-toggle="tab">Messages</a>
                    </li>
                </ul>


                <div class="block-content tab-content">
                    <div class="tab-pane active" id="btabs-navigation">


                        <!--  //Navigation-->

                        <div class="table-responsive">
                            <table class="table table-striped DataTables " id="Transation_DataTables">
                                <thead>
                                <tr>
                                    <th>English</th>
                                    <th class="col-xs-8"><?= ucwords($editLang) ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($english_menu as $key => $value) : ?>
                                    <tr>
                                        <td><?= $value ?></td>
                                        <td  ><input style="width: 100%" class="form-control" type="text" value="<?= (isset($translation_menu[$key]) ? $translation_menu[$key] : $value) ?>" name="menu[<?= $key ?>]" /></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>



                    </div>
                    <div class="tab-pane" id="btabs-body">
                        <!--  //Body Text-->

                        <div class="table-responsive">
                            <table class="table table-striped DataTables " id="Transation_DataTables">
                                <thead>
                                <tr>
                                    <th>English</th>
                                    <th class="col-xs-8"><?= ucwords($editLang) ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($english_body as $key => $value) : ?>
                                    <tr>
                                        <td><?= $value ?></td>
                                        <td  ><input style="width: 100%" class="form-control" type="text" value="<?= (isset($translation_body[$key]) ? $translation_body[$key] : $value) ?>" name="body[<?= $key ?>]" /></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="tab-pane" id="btabs-title">
                        <!--  //Body Text-->

                        <div class="table-responsive">
                            <table class="table table-striped DataTables " id="Transation_DataTables">
                                <thead>
                                <tr>
                                    <th>English</th>
                                    <th class="col-xs-8"><?= ucwords($editLang) ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($english_title as $key => $value) : ?>
                                    <tr>
                                        <td><?= $value ?></td>
                                        <td  ><input style="width: 100%" class="form-control" type="text" value="<?= (isset($translation_title[$key]) ? $translation_title[$key] : $value) ?>" name="title[<?= $key ?>]" /></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="tab-pane" id="btabs-msg">
                        <!--  //Body Text-->

                        <div class="table-responsive">
                            <table class="table table-striped DataTables " id="Transation_DataTables">
                                <thead>
                                <tr>
                                    <th>English</th>
                                    <th class="col-xs-8"><?= ucwords($editLang) ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($english_msg as $key => $value) : ?>
                                    <tr>
                                        <td><?= $value ?></td>
                                        <td  ><input style="width: 100%" class="form-control" type="text" value="<?= (isset($translation_msg[$key]) ? $translation_msg[$key] : $value) ?>" name="msg[<?= $key ?>]" /></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>

                <button type="submit" class="btn btn-success" value="Save">Save</button>
                <input type="hidden" name="language" value="<?= $editLang ?>">


            </div>
        </div>
        <!-- /.box -->

    </div>
</div>
<?php echo form_close() ?>