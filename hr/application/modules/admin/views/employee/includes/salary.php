<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!-- general form elements -->



<form id="SalaryForm" action="<?php echo site_url('admin/employee/save_salary')?>" method="post" onsubmit="return get_Cookie('csrf_cookie_name')">

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="token">

<div class="box box-primary">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('employee_salary_details') ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->


    <div class="box-body">

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label><?= lang('pay_grade') ?><span class="required">*</span></label>
                    <select class="form-control" name="grade_id" onchange="get_salaryRange(this.value)" id="salaryGrade" >
                        <option value="" ><?= lang('please_select') ?></option>
                        <?php foreach($gradeList as $item):?>
                            <option value="<?php echo $item->id ?>" <?php if(!empty($empSalary->grade_id)) echo $item->id == $empSalary->grade_id ?'selected':'' ?> >
                                <?php echo $item->grade_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span id="resultSalaryRange"></span>
                    <input type="hidden" id="min_salary">
                    <input type="hidden" id="max_salary">
                </div>

                <div class="form-group">
                    <label><?= lang('comment') ?></label>
                    <textarea class="form-control" name="comment"><?php if(!empty($empSalary->comment)) echo $empSalary->comment ?></textarea>
                </div>

            </div>
        </div>


        <!--All Earning-------------------------------------------------------------------------------------------->
        <br/>
        <br/>
        <h4><?= lang('salary_all_earnings') ?></h4>
        <hr/>


        <div class="row">
            <div class="col-md-8">


                <?php if(count($salaryEarningList)): foreach($salaryEarningList as $earning):?>
                        <?php
                            $salary = '';
                            if(!empty($empSalaryDetails)) {
                                foreach ($empSalaryDetails as $key => $details) {
                                    if ($earning->id == $key) {
                                        $salary = $details;
                                    }
                                }
                            }
                        ?>
                    <div class="row">
                        <div class="col-sm-6"><?php echo $earning->component_name ?></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" name="<?php echo $earning->id ?>" class="form-control key earning" id="<?php echo 'earn'.$earning->id ?>"
                                       value="<?php if(!empty($salary)){ echo $salary ;}?>" >
                                <span class="required" id="errorSalaryRange"></span>
                            </div>
                            <input type="hidden" value="<?php echo $earning->type?>" id="<?php echo 'type'.$earning->id ?>">
                            <input type="hidden" value="<?php echo $earning->total_payable?>" id="<?php echo 'pay'.$earning->id ?>">
                            <input type="hidden" value="<?php echo $earning->cost_company?>" id="<?php echo 'cost'.$earning->id ?>">
                            <input type="hidden" value="<?php echo $earning->flag?>" id="<?php echo 'flag'.$earning->id ?>">
                            <input type="hidden" value="<?php echo $earning->value_type?>" id="<?php echo 'valueType'.$earning->id ?>">
                            <input type="hidden" name="earn[]" value="<?php echo $earning->id ?>">

                        </div>
                    </div>
                <?php endforeach; endif ?>

            </div>
        </div>



        <!--All Deduction-------------------------------------------------------------------------------------------->
        <br/>
        <br/>
        <h4><?= lang('salary_all_deductions') ?></h4>
        <hr/>



        <div class="row">
            <div class="col-md-8">
                <?php if(count($salaryDeductionList)): foreach($salaryDeductionList as $deduction):?>
                    <?php
                    $salary = '';
                    if(!empty($empSalaryDetails)) {
                        foreach ($empSalaryDetails as $key => $details) {
                            if ($deduction->id == $key) {
                                $salary = $details;
                            }
                        }
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-6"><?php echo $deduction->component_name?> <strong>(<?php echo $deduction->value_type ==1 ? lang('amount'): lang('percentage') ?>)</strong></div>
                        <div class="col-sm-6">
                            <div class="form-group" >

                                    <input type="text"  name="<?php echo $deduction->id ?>" class="form-control key deduction" id="<?php echo 'earn'.$deduction->id ?>"
                                           value="<?php if(!empty($salary)){ echo $salary ;} ?>">




                            </div>



                            <input type="hidden" value="<?php echo $deduction->type?>" id="<?php echo 'type'.$deduction->id ?>">
                            <input type="hidden" value="<?php echo $deduction->total_payable?>" id="<?php echo 'pay'.$deduction->id ?>">
                            <input type="hidden" value="<?php echo $deduction->cost_company?>" id="<?php echo 'cost'.$deduction->id ?>">
                            <input type="hidden" value="<?php echo $deduction->flag?>" id="<?php echo 'flag'.$deduction->id ?>">
                            <input type="hidden" value="<?php echo $deduction->value_type?>" id="<?php echo 'valueType'.$deduction->id ?>">
                            <input type="hidden" name="deduction[]" value="<?php echo $deduction->id ?>">

                        </div>
                    </div>
                <?php endforeach; endif ?>

            </div>
        </div>



        <!--All Earning-------------------------------------------------------------------------------------------->
        <br/>
        <br/>
        <h4><?= lang('salary_summary') ?></h4>
        <hr/>


        <div class="well well-sm">
            <div class="row">
                <div class="col-md-8">

                    <div class="row" style="padding-bottom: 15px">
                        <div class="col-sm-6"><?= lang('total_deductions') ?> :</div>
                        <div class="col-sm-6" id="resultTotalDeduction"><strong><?php if(!empty($empSalary->total_deduction)){ echo get_option('default_currency').' '.$empSalary->total_deduction ; }else{ echo get_option('default_currency').' '.'00' ;} ?></strong></div>
                        <input type="hidden" name="total_deduction" id="totalDeduction" value="<?php if(!empty($empSalary->total_deduction)){ echo $empSalary->total_deduction ; }else{ echo '0' ;} ?>">
                    </div>

                    <div class="row" style="padding-bottom: 15px">
                        <div class="col-sm-6"><?= lang('total_payable') ?> :</div>
                        <div class="col-sm-6" id="resultTotalPayable"><strong><?php if(!empty($empSalary->total_payable)){ echo get_option('default_currency').' '.$empSalary->total_payable ; }else{ echo get_option('default_currency').' '.'00' ;} ?></strong></div>
                        <input type="hidden" name="total_payable" id="totalPayable" value="<?php if(!empty($empSalary->total_payable)){ echo $empSalary->total_payable ; }else{ echo '0' ;} ?>">
                    </div>

                    <div class="row" style="padding-bottom: 15px">
                        <div class="col-sm-6"><?= lang('cost_to_the_company') ?> :</div>
                        <div class="col-sm-6" id="resultCostToCompany"><strong><?php if(!empty($empSalary->total_cost_company)){ echo get_option('default_currency').' '. $empSalary->total_cost_company ; }else{ echo get_option('default_currency').' '.'00' ;} ?></strong></div>
                        <input type="hidden" name="total_cost_company" id="totalCostCompany" value="<?php if(!empty($empSalary->total_cost_company)){ echo $empSalary->total_cost_company ; }else{ echo '0' ;} ?>">
                    </div>


                </div>
            </div>
        </div>


        <input type="hidden" id="field" value="0">
        <input type="hidden" id="tempDeduction">
        <input type="hidden" id="tempPayable">
        <input type="hidden" id="tempCostCompany">


        <br/>
        <br/>
        <span class="required">*</span> <?= lang('required_field') ?>

        <input type="hidden" name="id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>" >
        <input type="hidden" name="salary_id" value="<?php if(!empty($empSalary->id))echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($empSalary->id)) ?>" >

    </div>
    <!-- /.box-body -->

    <div class="box-footer">

        <button id="saveSalary" type="submit" class="btn bg-olive btn-flat"  ><?= lang('save') ?></button>

    </div>

</div>
<!-- /.box -->

</form>



<script>
    $(document).ready(function() {
        function  calculate(valueType, salary, basicSalary ){
            if(valueType == 2 && salary != 0) {// deduction %
                var tmp  = salary / 100;
                return resultDeductionAmount = tmp * basicSalary;

            }else if(salary != 0){
                return resultDeductionAmount = salary;
            }else{
                return resultDeductionAmount = 0;
            }
        }

        //key press
        $(".key").keyup(function() {

            var allID = [];

            $('div input[name][id][value]').each(function(){
                allID.push($(this).attr('id'));
            });

            var totalPayable = 0 ;
            var totalCostCompany = 0;
            var totalPayableDeduction = 0;
            var totalCompanyDeduction = 0;
            var resultDeduction = 0;

            arrayLength = allID.length;
            for (var i = 0; i < arrayLength; i++) {
                var fieldId = allID[i].slice(4);
                var type = $( "#type"+fieldId ).val();
                var payable = $( "#pay"+fieldId ).val();
                var company = $( "#cost"+fieldId ).val();
                var flag = $( "#flag"+fieldId ).val();
                var valueType = $( "#valueType"+fieldId ).val();// amount or percentage

                var salary = ($.trim($("#earn" + fieldId).val()) != "" && !isNaN($("#earn" + fieldId).val())) ? parseInt($("#earn" + fieldId).val()) : 0;
                var basicSalary = ($.trim($("#earn1").val()) != "" && !isNaN($("#earn1").val())) ? parseInt($("#earn1").val()) : 0;


                if(flag==1)//get Salary Range
                {
                    $('#errorSalaryRange').empty();
                    var min_salary = parseInt($.trim($( "#min_salary" ).val()));
                    var max_salary = parseInt($.trim($( "#max_salary" ).val()));
                    if(salary < min_salary || salary > max_salary  ){

                        $("#errorSalaryRange").append('Salary Range: ' + min_salary + ' - ' + max_salary);
                    }

                }

                if(type == 1){//salary
                    //total payable
                    if(payable == 1){
                        totalPayable  += calculate(valueType, salary, basicSalary );
                    }
                    //Cost to company
                    if(company == 1){
                        totalCostCompany += calculate(valueType, salary, basicSalary );
                    }

                }else{//Deduction

                    if(payable == 1 && company == 1 ){
                        var resultDeductionAmount = calculate(valueType, salary, basicSalary );
                        resultDeduction +=resultDeductionAmount ;
                    }else if(payable == 1){
                        var resultDeductionAmount = calculate(valueType, salary, basicSalary );
                        resultDeduction +=resultDeductionAmount ;
                    }else{
                        var resultDeductionAmount = calculate(valueType, salary, basicSalary );
                        resultDeduction +=resultDeductionAmount ;
                    }

                    if(payable == 1){//payable
                        var resultDeductionAmount = calculate(valueType, salary, basicSalary );
                        totalPayableDeduction +=resultDeductionAmount ;
                    }

                    if(company == 1){//cost to company
                        var resultDeductionAmount = calculate(valueType, salary, basicSalary );
                        totalCompanyDeduction +=resultDeductionAmount ;
                    }
                }
            }

            var myCurrency =  '<?php echo get_option('default_currency')?>';
            // salary payable
            var resultSalaryPayable = totalPayable - totalPayableDeduction
            $('#resultTotalPayable').empty();
            $("#resultTotalPayable").append('<strong>'+ myCurrency +' '+ resultSalaryPayable  +'</strong>');
            $('#totalPayable').val(resultSalaryPayable);

            //salary cost to company
            var resultSalaryCostToCompany = totalCostCompany + totalCompanyDeduction;
            $('#resultCostToCompany').empty();
            $("#resultCostToCompany").append('<strong>'+ myCurrency +' '+ resultSalaryCostToCompany  +'</strong>');
            $('#totalCostCompany').val(resultSalaryCostToCompany);


            $('#resultTotalDeduction').empty();
            $("#resultTotalDeduction").append('<strong>'+ myCurrency +' '+ resultDeduction  +'</strong>');
            $('#totalDeduction').val(resultDeduction);

        });
    });


    $(document).ready(function() {
        var str = $("#salaryGrade").val();
        $('#resultSalaryRange').empty();
        var link = getBaseURL();
        $.ajax({
            type: "POST",
            url: link + 'admin/employee/get_salaryRange_by_id',
            data: { grade_id : str },
            cache: false,
            success: function(result){
                var result = $.parseJSON(result)
                $("#resultSalaryRange").append('Min: ' +result[0] + ' Max: ' + result[1]);
                $('#min_salary').val(result[0]);
                $('#max_salary').val(result[1]);
            }
        });
    });


    function get_Cookie(name) {
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        $('#token').val(cookieValue);
    }


</script>







