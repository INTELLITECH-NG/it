<div class="row">
    <div class="col-md-12">

        <div class="box">
            <div class="box-body" style="border: solid 1px #E4E5E7">
                    <div class="tabbable-line" style="background-color: #FBFBFB; border: solid 1px #F1F1F1">
                        <ul class="nav nav-tabs ">
                            <li class="<?php if($tab == 'company') echo 'active' ?>">
                                <a href="<?php echo site_url('admin/settings?tab=company'); ?>">
                                    <?= lang('company_info') ?> </a>
                            </li>

                            <li class="<?php if($tab == 'localization') echo 'active' ?>">
                                <a href="<?php echo site_url('admin/settings?tab=localization'); ?>" >
                                    <?= lang('localization') ?> </a>
                            </li>
                            <li class="<?php if($tab == 'invoice') echo 'active' ?>">
                                <a href="<?php echo site_url('admin/settings?tab=invoice'); ?>" >
                                    <?= lang('invoice_settings') ?> </a>
                            </li>
                            <li class="<?php if($tab == 'smtp_settings') echo 'active' ?>">
                                <a href="<?php echo site_url('admin/settings?tab=smtp_settings'); ?>" >
                                    <?= lang('smtp_settings') ?> </a>
                            </li>
                            <li class="<?php if($tab == 'email') echo 'active' ?>">
                                <a href="<?php echo site_url('admin/settings?tab=email'); ?>" >
                                    <?= lang('email_address') ?> </a>
                            </li>
                            <li class="<?php if($tab == 'language') echo 'active' ?>">
                                <a href="<?php echo site_url('admin/settings?tab=language'); ?>">
                                    <?= lang('language') ?> </a>
                            </li>
                        </ul>
                    </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

<?php echo $tab_view; ?>
