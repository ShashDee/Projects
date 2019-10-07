<div class = "row">
    <div class = "col-md-6">
        <h1>Employees</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Master</a>
            </li>
            <li>
                <a onclick = "loadModule('master/employee/employee_lookup_view');">Employee Lookup</a>
            </li>
             <li class = "active">
                <a><strong>Employees</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-6">
        <div class="title-action">
            <a class="btn btn-info" onclick="loadModule('master/employee/employee_lookup_view');"><i class="fa fa-eye"></i> Lookup </a>
        </div>
    </div>
    <!-- /.col-lg-8 -->
</div>
<!-- /.row -->

<div class = "wrapper animated fadeInRight">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Employees <small class = "text-white"> Showing options for creation and updation of employees</small>
            </div>
            
            <div class="panel-body">
                <div class="panel-group" id="accordion">
                
                    <div class="panel panel-transparent">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#emp_collapse_personal">Employee Personal Details</a>
                            </h4>
                        </div>
                        <div id="emp_collapse_personal" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <form class = "form-horizontal" id = "employee_form">
                                    <div class = "row">
                                        <div class = "col-md-12">

                                            <div class = "col-md-6">

                                                <div class="form-group"> 
                                                    <label class="col-md-4 control-label" for  = "employee_no_input">Employee No</label>                                      
                                                    <div class="col-md-8">
                                                        <input type = "text" placeholder = "Employee EPF Number" class = "form-control" id = "employee_no_input" name = "employee_no_input" data-validation="required">
                                                    </div>
                                                </div>

                                                <div class="form-group"> 
                                                    <label class="col-md-4 control-label" for  = "emp_fname_input">Full Name</label>                                      
                                                    <div class="col-md-8">
                                                        <input type = "text" placeholder = "Employee Full Name" class = "form-control" id = "emp_fname_input" name = "emp_fname_input" onkeyup = "generateName(this);" data-validation="required">
                                                    </div>
                                                </div>

                                                <div class = "form-group">
                                                    <label class = "col-md-4 control-label">Gender</label>
                                                    <div class="col-md-3 col-md-offset-1 iradio">
                                                        <input type="radio" id="radio_male" class = "emp_icheck" name = "radio_gender" value = "male" checked>&nbsp;&nbsp;&nbsp;&nbsp;Male
                                                    </div>
                                                    <div class="col-md-4 iradio">
                                                        <input type="radio" id="radio_female" class = "emp_icheck" name = "radio_gender" value = "female">&nbsp;&nbsp;&nbsp;&nbsp;Female
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="emp_home_input">Contact Number</label>
                                                    <div class="col-md-8">
                                                    <div class="input-group">                                            
                                                        <span class="input-group-addon">Home</span>
                                                        <input type="text" class="form-control" id="emp_home_input" name="emp_home_input" placeholder="Home Number" data-validation="required" onkeypress='return isNumber(event);'>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="emp_mobile_input">&nbsp;</label>                                                                           
                                                    <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Mobile</span>
                                                        <input type="text" class="form-control" id="emp_mobile_input" name="emp_mobile_input" placeholder="Mobile Number" data-validation="required" onkeypress='return isNumber(event);'>
                                                    </div>
                                                    </div>
                                                </div>

                                                <div class="form-group"> 
                                                    <label class="col-md-4 control-label" for  = "emp_email_input">Email</label>                                      
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                            <input type = "email" placeholder = "Email Address" class = "form-control" id = "emp_email_input" name = "emp_email_input" data-validation="email">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class = "col-md-6">

                                                <div class="form-group"> 
                                                    <label class="col-md-4 control-label" for  = "emp_nic_input">Employee NIC</label>                                      
                                                    <div class="col-md-8">
                                                        <input type = "text" placeholder = "NIC" class = "form-control" id = "emp_nic_input" name = "emp_nic_input" data-validation="required">
                                                    </div>
                                                </div>

                                                <div class="form-group"> 
                                                    <label class="col-md-4 control-label" for  = "emp_initials_input">Initials</label>                                      
                                                    <div class="col-md-3">
                                                        <input type = "text" placeholder = "Initials" class = "form-control" id = "emp_initials_input" name = "emp_initials_input" readonly>
                                                    </div>

                                                    <label class="col-md-2 control-label" for  = "emp_surname_input">Surname</label>                                      
                                                    <div class="col-md-3">
                                                        <input type = "text" placeholder = "Surname" class = "form-control" id = "emp_surname_input" name = "emp_surname_input" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="emp_add_input">Address</label>
                                                    <div class="col-md-8">
                                                        <textarea type="text" class="form-control" id="emp_add_input" name="emp_add_input" placeholder="Employee Address" rows = "5" data-validation="required"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group"> 
                                                    <label class="col-md-4 control-label" for  = "emp_skype_input">Skype</label>                                      
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-skype"></i></span>
                                                            <input type = "text" placeholder = "Skype Address" class = "form-control" id = "emp_skype_input" name = "emp_skype_input">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel one -->

                    <div class="panel panel-transparent">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#emp_collapse_employement">Employment Details</a>
                            </h4>
                        </div>
                        <div id="emp_collapse_employement" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <form class = "form-horizontal" id = "employment_form">
                                    <div class = "row">
                                        <div class = "col-md-12">

                                            <div class = "col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4" for = "joined_date_input">Joined Date</label>
                                                    <div class="col-md-8">
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            <input type="text" placeholder="Joined Date" name="joined_date_input" id = "joined_date_input" class="form-control" data-validation="date" data-validation-format="yyyy-mm-dd">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class = "form-group">
                                                    <label class = "control-label col-md-4" for  = "status_switch">Status</label>
                                                    <div class = "col-md-2">
                                                        <input id = "status_switch" name = "status_switch" type = "checkbox" class="js-switch" checked/>
                                                    </div>
                                                    <p class = "col-sm-6" id = "validation_placeholder"></p>
                                                </div>
                                            </div>
                                            <div class = "col-md-6">
                                                <div class="form-group"> 
                                                    <label class="col-md-4 control-label" for  = "emp_desig_input">Designation</label>                                      
                                                    <div class="col-md-8">
                                                        <input type = "text" placeholder = "Designation" class = "form-control" id = "emp_desig_input" name = "emp_desig_input" data-validation="required">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel two -->

                    <div class="panel panel-transparent">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#emp_collapse_skills">Employee Skills</a>
                            </h4>
                        </div>
                        <div id="emp_collapse_skills" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <form class = "form-horizontal" id = "emp_skills_form">
                                    <div class = "row">
                                        <div class = "col-md-12">
                                            <div class = "col-md-4">

                                                <div class="form-group">
                                                    <div class="col-md-12 checkbox">
                                                        <input type="checkbox" class="emp_icheck" id = "excellent_time_management" value = "excellent time management" name = "excellent_time_management">&nbsp;&nbsp;&nbsp;&nbsp;Excellent Time Management
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-12 checkbox">
                                                        <input type="checkbox" class="emp_icheck" id = "resuorcefulness" value = "resuorcefulness" name = "resuorcefulness">&nbsp;&nbsp;&nbsp;&nbsp;Resourcefulness
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-12 checkbox">
                                                        <input type="checkbox" class="emp_icheck" id = "good_communication_skills" value = "good communication skills" name = "good_communication_skills">&nbsp;&nbsp;&nbsp;&nbsp;Good Communication Skills
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-12 checkbox">
                                                        <input type="checkbox" class="emp_icheck" id = "creativity" value = "creativity" name = "creativity">&nbsp;&nbsp;&nbsp;&nbsp;Creativity
                                                    </div>
                                                </div>

                                            </div>

                                            <div class = "col-md-4">

                                                <div class="form-group">
                                                    <div class="col-md-12 checkbox">
                                                        <input type="checkbox" class="emp_icheck" id = "excellent_problem_sloving_skills" value = "excellent problem sloving skills" name = "excellent_problem_sloving_skills">&nbsp;&nbsp;&nbsp;&nbsp;Excellent Problem Solving Skills
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-12 checkbox">
                                                        <input type="checkbox" class="emp_icheck" id = "ability_to_handle_situations_calmly" value = "ability to handle situations calmly" name = "ability_to_handle_situations_calmly">&nbsp;&nbsp;&nbsp;&nbsp;Ability to Handle Situations Clamly
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-12 checkbox">
                                                        <input type="checkbox" class="emp_icheck" id = "ability_to_multitask" value = "ability to multitask" name = "ability_to_multitask">&nbsp;&nbsp;&nbsp;&nbsp;Ability to Multi Task
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-12 checkbox">
                                                        <input type="checkbox" class="emp_icheck" id = "excellent_customer_service" value = "excellent customer service" name = "excellent_customer_service">&nbsp;&nbsp;&nbsp;&nbsp;Excellent Customer Service
                                                    </div>
                                                </div>

                                            </div>

                                            <div class = "col-md-4">

                                                <div class="form-group">
                                                    <div class="col-md-12 checkbox">
                                                        <input type="checkbox" class="emp_icheck" id = "good_budgeting_skills" value = "good budgeting skills" name = "good_budgeting_skills">&nbsp;&nbsp;&nbsp;&nbsp;Good Budgeting Skills
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-12 checkbox">
                                                        <input type="checkbox" class="emp_icheck" id = "attention_to_detail" value = "attention to detail" name = "attention_to_detail">&nbsp;&nbsp;&nbsp;&nbsp;Attention to Detail
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel three -->
                </div>

                <div class = "hr-line-dashed"></div>

                <span class = "pull-right">                             
                    <button class="btn btn-primary" type="submit" id="save_btn" onclick = "preProcessSave();">Save</button>
                    <button class="btn btn-default" type="reset" onclick="resetForm();">Reset</button>
                </span>
                
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.wrapper -->

<script type="text/javascript">

var status_switch = null;
var update_id     = false;
var uri_emp_id    = '<?php echo $this->uri->segment(4); ?>';

$(document).ready(function()
{   
    elem = document.querySelector('.js-switch');

    status_switch = new Switchery(
    elem, {
        color: '#1AB394',
        secondaryColor: '#ed5565',
        className : 'switchery m-t-xs',
        size: 'small'
    });

    $('.emp_icheck').iCheck(
    {
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $('.date').datetimepicker(
    {
        format: 'YYYY-MM-DD',
        widgetPositioning: { horizontal: 'auto', vertical: 'bottom'}
    });

    if(uri_emp_id != null && uri_emp_id != '')
    {
        fetchEmployee(uri_emp_id);
    }

    $.validate(
    {
        form : '#employment_form,#employee_form',
        modules : 'security, date',
        onSuccess : function($form) 
        {
            saveEmployee();
            return false;
        }
    });
});

function preProcessSave()
{
    $('#employment_form,#employee_form').submit();
}

function generateName(e)
{
    var full_name   = $('#emp_fname_input').val();
    var names       = full_name.split(' ');
    var surname     = $.trim(names[names.length -1]);
    var common_name = $.trim(names[0]);
    
    var initials;

    $(names).each(function(index,value)
    {
        if (index == 0)
            initials = (value.charAt(0)).toUpperCase();
        else if (value != surname)
            initials = initials + '.' +(value.charAt(0)).toUpperCase();
        
    });
    $('#emp_initials_input').val(initials);
    $('#emp_surname_input').val(surname.charAt(0).toUpperCase() + surname.slice(1));
}

function fetchEmployee(emp_id)
{
    if(emp_id == null || emp_id == '')
    {
        resetForm();
        return;
    }

    $.getJSON("<?php echo base_url('master/employee/fetch_employee') ?>", {'id' : emp_id},
    function(data)
    {
        if(!jQuery.isEmptyObject(data))
        {
            if(!jQuery.isEmptyObject(data['employee']))
            {
                $('#employee_no_input').val(data['employee']['epf_no']);
                $('#emp_fname_input').val(data['employee']['full_name']);
                $('#emp_home_input').val(data['employee']['home_no']);
                $('#emp_mobile_input').val(data['employee']['mobile']);
                $('#emp_email_input').val(data['employee']['email']);
                $('#emp_nic_input').val(data['employee']['nic']);
                $('#emp_initials_input').val(data['employee']['initials']);
                $('#emp_surname_input').val(data['employee']['surname']);
                $('#emp_add_input').val(data['employee']['address']);
                $('#emp_skype_input').val(data['employee']['skype']);
                $('#joined_date_input').val(data['employee']['joined_date']);
                $('#emp_desig_input').val(data['employee']['desig']);

                if(data['employee']['gender'] == "male")
                    $('#radio_male').iCheck('check');
                else
                    $('#radio_female').iCheck('check');

                var status_switch = document.querySelector('#status_switch');

                if(data['employee']['status'] == "1")
                {
                    status_switch.checked = true;
                    onChange(status_switch);
                }  
                else if(data['employee']['status'] == "0")
                {
                    status_switch.checked = false;
                    onChange(status_switch);
                }

                update_id = data['employee']['id'];
            }

            if(!jQuery.isEmptyObject(data['skills']))
            {
                $.each(data['skills'], function(i,o)
                {
                    var check_id = o['skill'].replace(/ /g, '_');
                    $('#'+check_id).iCheck('check');
                });
            }
        }
    });

    return;
}

function isNumber(event)
{
    var charCode = (event.which) ? event.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && !(charCode >= 35 && charCode <= 39))
        return false;

    return true;
}

function saveEmployee()
{
    var emp_form        = $('#employee_form').serializeArray();
    var employment_form = $('#employment_form').serializeArray();
    var skills_form     = $('#emp_skills_form').serializeArray();

    var data = new Array();

    $.each(emp_form, function(i,e)
    {
        data.push(e);
    });

    $.each(employment_form, function(i,e)
    {
        data.push(e);
    });

    data.push({'name' : 'skills', 'value' : JSON.stringify(skills_form)});
    data.push({'name' : 'update_id', 'value' : update_id});

    $.ajax(
    {
       url: '<?php echo site_url("master/employee/save_employee")?>',
       type: 'post',
       dataType: 'json',
       data: data,
       async: false,
       error: function(){alert("An Error Occurred. Please Try Again.")},
       success: function(data)
       {
            refreshNotifications();
            if(data)
            {
                resetForm();
            }
       } 
    });
}

function resetForm()
{
    loadModule('master/employee/employee_view');
}

var changeCheckbox = document.querySelector('.js-switch')
var state          = changeCheckbox.checked;

changeCheckbox.onchange = function(e) 
{
    if(state == true && update_id != false)
    {
        $.getJSON("<?php echo site_url('master/employee/check_tasks') ?>", {'update_id' : update_id},
        function (data)
        {
            if(!jQuery.isEmptyObject(data))
            {   
                if(data['events'] > 0)
                {
                    $('#validation_placeholder').html('<div class = "alert alert-danger"><strong class = "text-danger">Employee is assigned to incomplete checklist items of an upcoming event. Cannot Deactive.</strong></div>');
                    changeCheckbox.checked = true;   
                    onChange(changeCheckbox);
                }
                else
                {
                    $("#validation_placeholder").html("");
                }
            }
            else
            {
                $("#validation_placeholder").html("");
            }
        });
    }
  
    state = changeCheckbox.checked;
};

var special = document.querySelector('#status_switch');

function onChange(el) 
{
    if (typeof Event === 'function' || !document.fireEvent) 
    {
        var event = document.createEvent('HTMLEvents');
        event.initEvent('change', true, true);
        el.dispatchEvent(event);
    } 

    else {
        el.fireEvent('onchange');
    }
}
</script>