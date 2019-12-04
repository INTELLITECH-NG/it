
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title">Language Settings</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">

                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>

                <div class="row">
                    <div class="panel-body">
                        <?php echo form_open('admin/settings/add_language', $attribute = array('class' => 'form-inline')) ?>
                            <div class="pull-right" style="margin-right: 5px;">
                                <select id="add-language" class="form-control" name="language">
                                    <?php if (!empty($availabe_language)): foreach ($availabe_language as $v_availabe_language) : ?>
                                        <option value="<?= str_replace(" ", "_", $v_availabe_language->language) ?>"><?= ucwords($v_availabe_language->language) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <button type="submit" id="add-translation" class="btn btn-dark">Add Language</button>
                            </div>
                        </form>
                    </div>
                </div>


                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Language</th>
                        <th>progress</th>
                        <th>Done</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php
                    if (!empty($language)){
                    foreach ($language as $v_language) {
                    $st = $translation_stats;
                    $total_data = $st[$v_language->name]['total'];
                    $translated_data = $st[$v_language->name]['translated'];

                    $view_status = intval(($translated_data / $total_data) * 1000) / 10;
                    ?>
                    <tr>
                        <td><img src="<?php echo base_url('assets/img/flags/' . $v_language->icon) ?>.gif" /></td>
                        <td><a href="<?php base_url() ?>admin/settings/edit_translations/<?= $v_language->name ?>"><?= ucwords(str_replace("_", " ", $v_language->name)) ?></a></td>
                        <td>
                            <div class="progress">
                                <?php
                                $status = 'danger';
                                if ($view_status > 20) {
                                    $status = 'warning';
                                } if ($view_status > 50) {
                                    $status = 'primary';
                                } if ($view_status > 80) {
                                    $status = 'success';
                                }
                                ?>
                                <div class="progress-bar progress-bar-<?= $status ?>" role="progressbar" aria-valuenow="<?= $view_status ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $view_status ?>%;">
                                    <?= $view_status ?>%
                                </div>
                            </div>
                        </td>
                        <td class=""><?= $translated_data ?></td>
                        <td class=""><?= $total_data ?></td>
                        <?php
                        if ($v_language->active == 1) {
                            $status = 1;
                        } else {
                            $status = 0;
                        }
                        ?>
                        <td class="">
                            <a data-toggle="tooltip" title="<?= ($v_language->active == 1 ? lang('deactivate') : lang('activate') ) ?>"
                               class="active-translation btn btn-xs <?= ($v_language->active == 0 ? 'btn-default' : 'bg-purple' ) ?>"
                               href="<?= base_url() ?>admin/settings/language_status/<?= $v_language->name ?>" >
                                <i class="fa fa-check"></i></a>
                            <a data-toggle="tooltip" title="<?= lang('edit') ?>" class="btn btn-xs btn-default" href="<?= base_url() ?>admin/settings?tab=language/translation/<?= $v_language->name ?>"><i class="fa fa-pencil"></i></a>
                        </td>
                    </tr>

                    <?php }; } ?>

                    </tbody>
                </table>



            </div>


        </div>
        <!-- /.box -->

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.table').dataTable({
            paging: false
        });
    });
</script>