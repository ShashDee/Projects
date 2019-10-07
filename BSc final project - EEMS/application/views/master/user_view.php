<div class = "row">
    <div class = "col-md-6">
        <h1>Users</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Master</a>
            </li>
            <li>
                <a onclick = "loadModule('master/user/user_lookup_view');">User Lookup</a>
            </li>
             <li class = "active">
                <a><strong>Users</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-6">
        <div class="title-action">
            <a class="btn btn-info" onclick="loadModule('master/user/user_lookup_view');"><i class="fa fa-eye"></i> Lookup </a>
        </div>
    </div>
    <!-- /.col-lg-8 -->
</div>
<!-- /.row -->

<div class = "wrapper animated fadeInRight">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Users <small class = "text-white"> Showing options for creation and update of users</small>
            </div>
            
            <div class="panel-body">
                <div class="panel-group" id="accordion">
                
                    <div class="panel panel-transparent">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#user_collapse_personal">User Personal Details</a>
                            </h4>
                        </div>
                        <div id="user_collapse_personal" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <form class = "form-horizontal" id = "user_form">
                                    <div class = "row">
                                        <div class = "col-md-12">
                                            <div class = "col-md-6 col-md-offset-3">
                                                <div class="form-group"> 
                                                    <label class="col-md-4 control-label" for  = "emp_select">Employee</label>                                    
                                                    <div class="col-md-8">
                                                        <?php echo form_dropdown('emp_select', $emp, '', 'id = "emp_select" class = "form-control selectpicker" data-live-search = "true" data-container = "body" data-size = "5"'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class = "col-md-12">

                                            <div class = "col-md-6">

                                                <div class="form-group"> 
                                                    <label class="col-md-4 control-label" for  = "user_nic_input">User NIC</label>                                      
                                                    <div class="col-md-8">
                                                        <input type = "text" placeholder = "NIC" class = "form-control" id = "user_nic_input" name = "user_nic_input" data-validation="required">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class = "col-md-6">

                                                <div class="form-group"> 
                                                    <label class="col-md-4 control-label" for  = "user_fname_input">Full Name</label>                                      
                                                    <div class="col-md-8">
                                                        <input type = "text" placeholder = "User Full Name" class = "form-control" id = "user_fname_input" name = "user_fname_input" data-validation="required">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class = "col-md-12">
                                            <div class = "col-md-6">

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="user_home_input">Contact Number</label>
                                                    <div class="col-md-8">
                                                    <div class="input-group">                                            
                                                        <span class="input-group-addon">Home</span>
                                                        <input type="text" class="form-control" id="user_home_input" name="user_home_input" placeholder="Home Number">
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="user_mobile_input">&nbsp;</label>                                                                           
                                                    <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Mobile</span>
                                                        <input type="text" class="form-control" id="user_mobile_input" name="user_mobile_input" placeholder="Mobile Number" data-validation="required">
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "col-md-6">

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="user_add_input">Address</label>
                                                    <div class="col-md-8">
                                                        <textarea type="text" class="form-control" id="user_add_input" name="user_add_input" placeholder="User Address" rows = "4" data-validation="required"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class = "col-md-12">
                                            <div class = "col-md-6">

                                                <div class="form-group"> 
                                                    <label class="col-md-4 control-label" for  = "emp_email_input">Email</label>                                      
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                            <input type = "email" placeholder = "Email Address" class = "form-control" id = "emp_email_input" name = "emp_email_input" data-validation="email" data-validation-optional="true">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class = "col-md-6">

                                                 <div class = "form-group">
                                                    <label class = "control-label col-md-4" for  = "status_switch">Status</label>
                                                    <div class = "col-md-2">
                                                        <input id = "status_switch" name = "status_switch" type = "checkbox" class="js-switch" checked/>
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
                                <a data-toggle="collapse" href="#user_collapse_info">User Information</a>
                            </h4>
                        </div>
                        <div id="user_collapse_info" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <form class = "form-horizontal" id = "user_info_form">
                                    <div class = "row">
                                        <div class = "col-md-12">

                                            <div class = "col-md-6">
                                                <div class="form-group"> 
                                                    <label class="col-md-4 control-label" for  = "username_input">Username</label>                                      
                                                    <div class="col-md-8">
                                                        <input type = "text" placeholder = "Username" class = "form-control" id = "username_input" name = "username_input" data-validation="required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "col-md-6">
                                                <div class = "form-group">
                                                    <label class="col-md-4 control-label" for  = "u_group_select">User Group</label>
                                                    <div class = "col-md-8">
                                                        <select name = "u_group_select" id = "u_group_select" class = "form-control selectpicker" data-container = "body">
                                                            <option value = "">Select User Group</option>
                                                            <option value = "admin">Admin</option>
                                                            <option value = "user">User</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class = "col-md-12">
                                            <div class = "col-md-6">
                                                <div class = "form-group">
                                                    <label class = "col-md-4 control-label" for = "pass_confirmation">Password</label>
                                                    <div class = "col-md-8">
                                                        <input type = "password" value = ""  class = "form-control" id = "pass_confirmation" name = "pass_confirmation" placeholder = "Password" data-validation="required"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "col-md-6">
                                                <div class = "form-group">
                                                    <label class = "col-md-4 control-label" for = "pass">Confirm Password</label>
                                                    <div class = "col-md-8">
                                                        <input type = "password"  value = "" class = "form-control" id = "pass" name = "pass" placeholder = "Confirm Password" data-validation="confirmation"/>
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
                </div>

                <div class = "hr-line-dashed"></div>

                <span class = "pull-right">                             
                    <button class="btn btn-primary" type="button" id="save_btn" onclick = "preProcessSave();">Save</button>
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
var uri_user_id    = '<?php echo $this->uri->segment(4); ?>';

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

    $('.selectpicker').selectpicker();

    if(uri_user_id != null && uri_user_id != '')
    {
        fetchUser(uri_user_id);
    }

    $.validate(
    {
        form : '#user_form, #user_info_form',
        modules : 'security',
        onSuccess : function($form) 
        {
            saveUser();
            return false;
        }
    });
});

function fetchUser(user_id)
{
    if(user_id == null || user_id == '')
    {
        resetForm();
        return;
    }

    $.getJSON("<?php echo base_url('master/user/fetch_user') ?>", {'id' : user_id},
    function(data)
    {
        if(!jQuery.isEmptyObject(data))
        {
            $('#emp_select').append('<option value = "'+data['emp_id']+'">' + data['emp_name'] + "</option>");
            $('#emp_select').selectpicker('val', data['emp_id']);
            $('#emp_select').prop('disabled', true);
            $('#emp_select').selectpicker('refresh');
            
            $('#user_nic_input').val(data['nic']);
            $('#user_fname_input').val(data['full_name']);
            $('#user_home_input').val(data['home']);
            $('#user_mobile_input').val(data['mobile']);
            $('#user_add_input').val(data['address']);
            $('#emp_email_input').val(data['email']);
            $('#username_input').val(data['username']);
            $('#u_group_select').selectpicker('val', data['group']);
            $('#pass_confirmation').val(data['pwd']);
            $('#pass').val(data['pwd']);

            var status_switch = document.querySelector('#status_switch');

            if(data['status'] == "1")
            {
                status_switch.checked = true;
                onChange(status_switch);
            }  
            else if(data['status'] == "0")
            {
                status_switch.checked = false;
                onChange(status_switch);
            }

            $('#u_group_select').selectpicker('refresh');

            update_id = data['id'];
        }
    });

    return;
}

function preProcessSave()
{
    $('#user_form,#user_info_form').submit();
}

function saveUser()
{
    var user_form      = $('#user_form').serializeArray();
    var user_info_form = $('#user_info_form').serializeArray();

    var data = new Array();

    $.each(user_form, function(i,e)
    {
        data.push(e);
    });

    $.each(user_info_form, function(i,e)
    {
        data.push(e);
    });

    data.push({'name' : 'update_id', 'value' : update_id});

    $.ajax(
    {
       url: '<?php echo site_url("master/user/save_user")?>',
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
    loadModule('master/user/user_view');
}

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