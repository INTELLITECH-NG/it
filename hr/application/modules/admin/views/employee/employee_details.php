

    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">

                    <img src="<?php echo $employee->photo !='' ? site_url(UPLOAD_EMPLOYEE.$employee->employee_id.'/'.$employee->photo) : site_url(IMAGE.'client.png') ?>" class="img-responsive" alt="">
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo $employee->first_name.' '.$employee->last_name ?>
                    </div>
                    <?php if($employee->termination){?>
                        <div class="profile-usertitle-job">
                            <?= lang('employee_id') ?> : <?php echo $employee->employee_id ?>
                        </div>
                    <?php }else{ ?>
                        <div class="profile-usertitle-job">
                            <?= lang('employee_id') ?> : <strong style="color: RED"><?= lang('terminated') ?></strong>
                        </div>
                    <?php } ?>

                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons">
                    <?php if($employee->termination){?>
                        <a  data-target="#modalSmall" data-placement="top" data-toggle="modal"
                            onClick="return confirm('<?= lang('are_you_sure_you_want_to_terminate_employee') ?>')"
                            href="<?php echo base_url()?>admin/employee/termination/<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id))?>" class="btn btn-danger btn-sm">
                            <?= lang('termination') ?>
                        </a>
                    <?php }else{ ?>
                        <a onClick="return confirm('<?= lang('are_you_sure_re_join_employment') ?>')"
                            href="<?php echo base_url()?>admin/employee/reJoin/<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id))?>" class="btn bg-navy btn-sm">
                            <?= lang('re_join_employment') ?>
                        </a>
                    <?php } ?>
                </div>
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->
                </br>
                </br>

                <?php if($employee->termination == 0){?>
                    <a href="<?php echo site_url('admin/employee/employeeDetails?tab=termination/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id))); ?>" class="btn btn-block btn-flat bg-maroon text-left"><?= lang('termination_note') ?></a>
                <?php }?>



                <div class="profile-usermenu">
                    <ul class="nav">
                        <li class="<?php if($tab == 'personal') echo 'active' ?>">
                            <a href="<?php echo site_url('admin/employee/employeeDetails?tab=personal/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id))); ?>"><?= lang('personal_details') ?></a>
                        </li>
                        <li class="<?php if($tab == 'contact') echo 'active' ?>">
                            <a href="<?php echo site_url('admin/employee/employeeDetails?tab=contact/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id))); ?>"><?= lang('contact_details') ?></a>
                        </li>
                        <li class="<?php if($tab == 'dependents') echo 'active' ?>">
                            <a href="<?php echo site_url('admin/employee/employeeDetails?tab=dependents/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id))); ?>"><?= lang('dependents') ?></a>
                        </li>
                        <li class="<?php if($tab == 'job') echo 'active' ?>">
                            <a href="<?php echo site_url('admin/employee/employeeDetails?tab=job/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id))); ?>"><?= lang('job') ?></a>
                        </li>
                        <li class="<?php if($tab == 'salary') echo 'active' ?>">
                            <a href="<?php echo site_url('admin/employee/employeeDetails?tab=salary/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id))); ?>"><?= lang('salary') ?></a>
                        </li>
                        <li class="<?php if($tab == 'report') echo 'active' ?>">
                            <a href="<?php echo site_url('admin/employee/employeeDetails?tab=report/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id))); ?>"><?= lang('report-to') ?></a>
                        </li>
                        <li class="<?php if($tab == 'deposit') echo 'active' ?>">
                            <a href="<?php echo site_url('admin/employee/employeeDetails?tab=deposit/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id))); ?>"><?= lang('direct_deposit') ?></a>
                        </li>
                        <li class="<?php if($tab == 'login') echo 'active' ?>">
                            <a href="<?php echo site_url('admin/employee/employeeDetails?tab=login/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id))); ?>"><?= lang('login') ?></a>
                        </li>

                    </ul>
                </div>
                <!-- END MENU -->
            </div>
        </div>

            <div class="col-md-9">
                <?php echo $tab_view; ?>
            </div>

    </div>





