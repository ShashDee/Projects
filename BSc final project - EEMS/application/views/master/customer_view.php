<div class = "row">
    <div class = "col-md-6">
        <h1>Customer</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Master</a>
            </li>
            <li>
                <a onclick = "loadModule('master/customer/customer_lookup_view');">Customer Lookup</a>
            </li>
             <li class = "active">
                <a><strong>Customer</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-6">
        <div class="title-action">
            <a class="btn btn-info" onclick="loadModule('master/customer/customer_lookup_view');"><i class="fa fa-eye"></i> Lookup </a>
        </div>
    </div>
    <!-- /.col-lg-8 -->
</div>
<!-- /.row -->

<div class = "wrapper animated fadeInRight">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#customer_collapse">Customers <small class = "text-white"> Showing options for creation and updation of customers</small></a>
                </h4>
            </div>
            <div id="customer_collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class = "form-horizontal" id = "customer_form">
                        <div class = "row">
                            <div class = "col-md-12">

                                <div class = "col-md-6">

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "customer_code_input">Customer Code</label>                                    
                                        <div class="col-md-8">
                                            <input type = "text" placeholder = "Customer Code" class = "form-control" id = "customer_code_input" name = "customer_code_input" value = "<?php echo $code; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "cus_nic_input">Customer NIC</label>                                      
                                        <div class="col-md-8">
                                            <input type = "text" placeholder = "Customer NIC" class = "form-control" id = "cus_nic_input" name = "cus_nic_input" data-validation="required">
                                        </div>
                                    </div>

                                    <div class = "form-group">
                                        <label class="col-md-4 control-label" for  = "title_select">Title</label>
                                        <div class = "col-md-8">
                                            <select name = "title_select" id = "title_select" class = "form-control selectpicker" data-container = "body" data-live-search = "true">
                                                <option data-hidden="true" value = "">Select Title</option>
                                                <option value = "Mr">Mr</option>
                                                <option value = "Mrs">Mrs</option>
                                                <option value = "Ms">Ms</option>
                                                <option value = "Dr">Dr</option>
                                                <option value = "Hon">Hon</option>
                                                <option value = "Prof">Prof</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "cus_name_input">Customer Name</label>                                      
                                        <div class="col-md-8">
                                            <input type = "text" placeholder = "Customer Name" class = "form-control" id = "cus_name_input" name = "cus_name_input" data-validation="required">
                                        </div>
                                    </div>

                                    <div class = "form-group">
                                        <label class = "col-md-4 control-label">Gender</label>
                                        <div class="col-md-3 col-md-offset-1 iradio">
                                            <input type="radio" id="radio_male" class = "cus_icheck" name = "radio_gender" value = "male" checked>&nbsp;&nbsp;&nbsp;&nbsp;Male
                                        </div>
                                        <div class="col-md-4 iradio">
                                            <input type="radio" id="radio_female" class = "cus_icheck" name = "radio_gender" value = "female">&nbsp;&nbsp;&nbsp;&nbsp;Female
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="cus_home_input">Contact Number</label>
                                        <div class="col-md-8">
                                        <div class="input-group">                                            
                                            <span class="input-group-addon">Home</span>
                                            <input type="text" class="form-control" id="cus_home_input" name="cus_home_input" placeholder="Home Number"onkeypress='return isNumber(event);'>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="cus_mobile_input">&nbsp;</label>                                                                           
                                        <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">Mobile</span>
                                            <input type="text" class="form-control" id="cus_mobile_input" name="cus_mobile_input" placeholder="Mobile Number" data-validation="required"onkeypress='return isNumber(event);'>
                                        </div>
                                        </div>
                                    </div>

                                </div>
                                <div class = "col-md-6">

                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="cus_add_input">Address</label>
                                        <div class="col-md-8">
                                            <textarea type="text" class="form-control" id="cus_add_input" name="cus_add_input" placeholder="Customer Address" rows = "5" data-validation="required"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "cus_email_input">Email</label>                                      
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                <input type = "email" placeholder = "Email Address" class = "form-control" id = "cus_email_input" name = "cus_email_input" data-validation="email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "cus_skype_input">Skype</label>                                      
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-skype"></i></span>
                                                <input type = "text" placeholder = "Skype Address" class = "form-control" id = "cus_skype_input" name = "cus_skype_input">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-4" for = "reg_date_input">Registered Date</label>
                                        <div class="col-md-8">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" placeholder="Registered Date" name="reg_date_input" id = "reg_date_input" value = "<?php echo date('Y-m-d'); ?>" class="form-control" data-validation="date" data-validation-format="yyyy-mm-dd">
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
                            </div>
                        </div>
                    </form>

                    <div class = "hr-line-dashed"></div>

                    <span class = "pull-right">                             
                        <button class="btn btn-primary" type="submit" id="save_btn" onclick = "preProcessSave();">Save</button>
                        <button class="btn btn-default" type="reset" onclick="resetForm();">Reset</button>
                    </span>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.wrapper -->

<script type="text/javascript">

var status_switch = null;
var update_id     = false;
var uri_cus_id    = '<?php echo $this->uri->segment(4); ?>';

$(document).ready(function()
{   
    $('.selectpicker').selectpicker();

    elem = document.querySelector('.js-switch');

    status_switch = new Switchery(
    elem, {
        color: '#1AB394',
        secondaryColor: '#ed5565',
        className : 'switchery m-t-xs',
        size: 'small'
    });

    $('.cus_icheck').iCheck(
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

    if(uri_cus_id != null && uri_cus_id != '')
    {
        fetchCustomer(uri_cus_id);
    }

    $.validate(
    {
        form : '#customer_form',
        modules : 'security, date',
        onSuccess : function($form) 
        {
            saveCustomer();
            return false;
        }
    });
});

function preProcessSave()
{
    $('#customer_form').submit();
}

function fetchCustomer(cus_id)
{
    if(cus_id == null || cus_id == '')
    {
        resetForm();
        return;
    }

    $.getJSON("<?php echo base_url('master/customer/fetch_customer') ?>", {'id' : cus_id},
    function(data)
    {
        if(!jQuery.isEmptyObject(data))
        {
            $('#customer_code_input').val(data['code']);
            $('#cus_nic_input').val(data['nic']);
            $('#title_select').selectpicker('val', data['title']);
            $('#cus_name_input').val(data['name']);
            $('#cus_home_input').val(data['home']);
            $('#cus_mobile_input').val(data['mobile']);
            $('#cus_add_input').val(data['address']);
            $('#cus_email_input').val(data['email']);
            $('#cus_skype_input').val(data['skype']);
            $('#reg_date_input').val(data['reg_date']);

            if(data['gender'] == "male")
                $('#radio_male').iCheck('check');
            else
                $('#radio_female').iCheck('check');

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

            update_id = data['id'];
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

function saveCustomer()
{
    var data = $('#customer_form').serializeArray();

    data.push({'name' : 'update_id', 'value' : update_id});

    $.ajax(
    {
       url: '<?php echo site_url("master/customer/save_customer")?>',
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

function reloadSequence()
{
    $.ajax(
    {
        url: '<?php echo site_url("master/customer/reload_sequence") ?>',
        type: 'post',
        dataType: 'json',
        async: false,
        error: function(){alert("An Error Occurred, Please Try Again.")},
        success: function(data)
        {
            $('#customer_code_input').val(data['code']);
        }
    });
}

function resetForm()
{
    $('.cus_icheck').iCheck('uncheck');
    $('#radio_male').iCheck('check');
    $('#customer_form')[0].reset();
    $('.selectpicker option').prop('selected', false);
    $('.selectpicker').selectpicker('refresh');

    update_id = false;

    if (special.checked) 
    {
        special.checked = true;
        onChange(special);
    }
    else 
    {
        special.checked = true;
        onChange(special);
    }

    reloadSequence();
}

var changeCheckbox = document.querySelector('.js-switch')
var state          = changeCheckbox.checked;

changeCheckbox.onchange = function(e) 
{
    if(state == true && update_id != false)
    {
        $.getJSON("<?php echo site_url('master/customer/check_events') ?>", {'update_id' : update_id},
        function (data)
        {
            if(!jQuery.isEmptyObject(data))
            {   
                if(data['events'] > 0)
                {
                    $('#validation_placeholder').html('<div class = "alert alert-danger"><strong class = "text-danger">Customer has Upcoming Incomplete Events. Cannot Deactive.</strong></div>');
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