<section class="content">
    <div class="row">
        <div class="col-sm-12">

            <div class="row">
                <div class="col-sm-12" data-offset="0">
                    <div class="wrap-fpanel">
                        <div class="box box-primary" data-collapsed="0">
                            <div class="box-header with-border bg-primary-dark">
                                <h3 class="box-title"><?= lang('list_of_notice') ?></h3>
                            </div>
                            <div class="panel-body">


                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th><?= lang('date') ?></th>
                                        <th><?= lang('title') ?></th>
                                        <th><?= lang('short_description') ?></th>
                                        <th><?= lang('actions') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($notice)){ foreach($notice as $item){ ?>
                                        <tr>
                                            <td><?php echo date(get_option('date_format'), strtotime($item->date)) ?></td>
                                            <td><?php echo $item->title ?></td>
                                            <td><?php echo $item->short ?></td>
                                            <td><a class="btn btn-xs btn-default" href="<?php echo base_url('employee/home/viewNotice/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))) ?>"><i class="fa fa-eye"></i></a></td>
                                        </tr>
                                    <?php } } ?>
                                    </tbody>
                                </table>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div></section>
