<div class = "row">
    <div class = "col-md-6">
        <h1>Event</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb -->
            <li>
                <a href = "<?php echo site_url('dashboard'); ?>">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Transaction</a>
            </li>
            <li>
                <a>Events</a>
            </li>
             <li class = "active">
                <a><strong>Event</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-6">
        <div class="title-action">
            <a class="btn btn-info" onclick="loadModule('transaction/event/event_lookup_view');"><i class="fa fa-eye"></i> View Previous Events </a>
        </div>
    </div>
    <!-- /.col-lg-8 -->
</div>
<!-- /.row -->

<div class = "wrapper animated fadeInRight"> <!-- load with animation -->
    <div class="row">
        <div class="panel panel-primary"> <!-- Start of panel -->
            <div class="panel-heading"> <!-- heading section -->
                <h4 class="panel-title">
                    <!-- Title with collapse function -->
                    <a data-toggle="collapse" href="#event_collapse">Event <small class = "text-white"> Showing options for placing of events</small></a>
                </h4>
            </div>
            <div id="event_collapse" class="panel-collapse collapse in">
                <div class="panel-body"> <!-- start of panel bosy section -->
                    <form class = "form-horizontal" id = "event_form"> <!-- Form start-->
                        <div class = "row">
                            <div class = "col-md-12">
                                <div class = "col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for = "evt_code_input">Event Code</label>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Event Date" name="evt_code_input" id = "evt_code_input" class="form-control" value = "<?php echo $code; ?>" readonly> <!-- normal input -->
                                        </div>
                                    </div>
                                </div>
                                <div class = "col-md-6">
                                    <div class = "form-group">
                                        <label class="col-md-4 control-label" for  = "cus_select">Customer</label>
                                        <div class = "col-md-6">
                                            <?php echo form_dropdown('cus_select', $customer, '', 'id = "cus_select" class = "form-control selectpicker" data-live-search = "true" data-container = "body" data-size = "5"'); ?> <!-- dropdown with options loaded by fetching from database-->
                                        </div>
                                        <div class = "col-md-1">
                                            <a id = "cus_a_link" data-toggle='modal' href='master/customer/event_customer_view' data-target='#customer_modal' class = "btn btn-default"><i class = "fa fa-plus"></i></a> <!-- link to open modal where customers can be added -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-12">
                                <div class = "col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for = "evt_select">Event Type</label>
                                        <div class="col-md-8">
                                            <?php echo form_dropdown('evt_select', $evt_types, '', 'id = "evt_select" class = "form-control selectpicker" data-live-search = "true" data-container = "body" data-size = "5"'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class = "col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for = "evt_date_input">Event Date</label>
                                        <div class="col-md-8">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" placeholder="Event Date" name="evt_date_input" id = "evt_date_input" class="form-control" data-validation="date" data-validation-format="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-12">
                                <div class = "col-md-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4" for = "start_time_input">Start Time</label>
                                        <div class="col-md-8">
                                            <div class="input-group time">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                <input type="text" placeholder="Start Time" name="start_time_input" id = "start_time_input" class="form-control" data-validation="time" data-validation-format="HH:mm">
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class = "col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for = "end_time_input">End Time</label>
                                        <div class="col-md-8">
                                            <div class="input-group time">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                <input type="text" placeholder="End Time" name="end_time_input" id = "end_time_input" class="form-control" data-validation="time" data-validation-format="HH:mm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class = "col-md-12">
                                <div class = "col-md-6">
                                    <div class = "form-group">
                                        <label class="col-md-4 control-label" for  = "ven_select">Venue</label>
                                        <div class = "col-md-8">
                                            <?php echo form_dropdown('ven_select', $venue, '', 'id = "ven_select" class = "form-control selectpicker" data-live-search = "true" data-container = "body" data-size = "5" onChange = "fetchHalls();"'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class = "col-md-6">
                                    <div class = "form-group">
                                        <label class="col-md-4 control-label" for  = "hall_select">Hall</label>
                                        <div class = "col-md-8">
                                            <?php echo form_dropdown('hall_select', array(), '', 'id = "hall_select" class = "form-control selectpicker" data-live-search = "true" data-container = "body" data-size = "5" disabled'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-12">
                                <div class = "col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for = "evt_budget_input">Initial Budget</label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">Rs.</span>
                                                <input type="text" placeholder="Budget" name="evt_budget_input" id = "evt_budget_input" class="form-control text-right" onkeypress='return isNumber(event);' data-validation="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for = "act_budget_input">Actual Budget</label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">Rs.</span>
                                                <input type="text" placeholder="Actual Budget" name="act_budget_input" id = "act_budget_input" class="form-control text-right" onkeypress='return isNumber(event);' readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-12">
                                <div class = "col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for = "total_fee_input">Total Fee</label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">Rs.</span>
                                                <input type="text" placeholder="Total Fee" name="total_fee_input" id = "total_fee_input" class="form-control text-right" onkeypress='return isNumber(event);'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for = "evt_complete_check">Event Complete</label>
                                        <div class="col-md-8 checkbox">
                                            <input type="checkbox" class="evt_icheck" id = "evt_complete_check" name = "evt_complete_check">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-12">
                                <div class = "form-group">
                                    <label class="control-label col-md-2" for = "cus_req_input">Requirement</label>
                                    <div class="col-md-10">
                                        <textarea type="text" class="form-control" id="cus_req_input" name="cus_req_input" placeholder="Customer Requirement Description" rows = "2" data-validation="required"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-12">
                                <div class = "form-group">
                                    <label class="control-label col-md-2" for = "ent_remarks_input">Remarks</label>
                                    <div class="col-md-10">
                                        <textarea type="text" class="form-control" id="ent_remarks_input" name="ent_remarks_input" placeholder="Event Remarks Description" rows = "2" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class = "hr-line-dashed"></div>
                        <h5>Event Activities</h5>
                        <div class = "hr-line-dashed"></div>

                        <div class = "table-responsive"> <!-- table-responsive class for adding scrolls when screen size inadequate -->
                            <table id = "ent_activity_table" class = "table table-bordered table-hover table-striped compact"> 
                                <thead><!-- table header -->
                                    <th class = "text-center">#</th>
                                    <th class = "text-center">Activity</th>
                                    <th class = "text-center">Description</th>
                                    <th class = "text-center">Deadline</th>
                                    <th class = "text-center">Supplier</th>
                                    <th class = "text-center">Supplier Role</th>
                                    <th class = "text-center">Budget (Rs.)</th>
                                    <th class = "text-center">Progress</th>
                                    <th class = "text-center">Action</th>
                                </thead>
                                <tbody id = "ent_activity_table_body"> <!-- table body -->
                                    <tr class = "table-input" id = "input_row">
                                        <th></th>
                                        <th><input type="text" placeholder="Activity" name="tbl_activity_input" id = "tbl_activity_input" class="form-control"></th>
                                        <th><input type="text" placeholder="Activity Description" name="tbl_desc_input" id = "tbl_desc_input" class="form-control"></th>
                                        <th>
                                            <div class = "input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" placeholder="Deadline" value="<?php echo date('Y-m-d')?>" name="tbl_deadline_input" id = "tbl_deadline_input" class="form-control date">
                                            </div>
                                        </th>
                                        <th><?php echo form_dropdown('tbl_sup_select', array(), '', 'id = "tbl_sup_select" class = "form-control selectpicker" data-live-search = "true" data-container = "body" data-size = "5" onChange = "loadSupplierTypes();"'); ?></th>
                                        <th><?php echo form_dropdown('tbl_cat_select', array(), '', 'id = "tbl_cat_select" class = "form-control selectpicker" data-live-search = "true" data-container = "body" data-size = "5"'); ?></th>
                                        <th>
                                            <div class = "input-group">
                                                <span class="input-group-addon">Rs.</span>
                                                <input type = "text" id = "tbl_budget_input" name = "tbl_budget_input" placeholder = "Budget" class = "form-control text-right">
                                            </div>
                                        </th>
                                        <th><button type="button" class="btn btn-disabled-danger" disabled>0%</button></th>
                                        <th><button type = "button" onclick = "addActivity();" id = "avt_add_btn" name = "avt_add_btn" class = "btn btn-block btn-primary">Add <i class = "fa fa-level-down"></i></button></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class = "hr-line-dashed"></div>

                        <span class = "pull-right">                             
                            <button class="btn btn-primary" type="button" id="save_btn" onclick = "preProcessSave();">Save</button>
                            <button class="btn btn-default" type="reset" onclick="resetForm();" id = "reset_btn">Reset</button>
                        </span>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.wrapper -->

<!-- Start of Customer modal-->
<div class="modal fade" id="customer_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content">
            
        </div>
    </div>
</div> <!-- End of Customer modal -->

<script type="text/javascript">

var ent_activity_table   = null;
var update_id            = false;
var activity_list        = new Object();
var activity_count       = 0;
var remove_activity_list = new Object();
var remove_a_count       = 0;
var mode                 = "A";
var uri_ent_id           = "<?php echo $this->uri->segment(4); ?>";
var uri_mode             = "<?php echo $this->uri->segment(5); ?>";
var initial_date         = null;

$(document).ready(function()
{
    $('.selectpicker').selectpicker();

    $('.date').datetimepicker(
    {
        format: 'YYYY-MM-DD',
        widgetPositioning: { horizontal: 'auto', vertical: 'bottom'},
    });

    $('.time').datetimepicker(
    {
        format: 'HH:mm',
        widgetPositioning: { horizontal: 'auto', vertical: 'bottom'}
    });

    $('.evt_icheck').iCheck(
    {
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    ent_activity_table = $('#ent_activity_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"><"clear">',
        'bSort': false,
        'iDisplayLength' : -1,
        'responsive' : false,
        'autoWidth' : false
    });

    if(uri_mode == "a")
    {
        mode = "A";
    }
    else if(mode == "e")
    {
        mode = "E";
    }
    else if(mode == "v")
    {
        mode == "V";
    }

    if(uri_ent_id != "" && uri_ent_id != null && uri_ent_id != "null")
    {
        fetchEvent(uri_ent_id,uri_mode);
    }

    $.validate(
    {
        form : '#event_form',
        modules : 'security, date',
        onSuccess : function($form) 
        {
            validateEvent();
            return false;
        }
    });

    fetchSuppliers();
});

function preProcessSave()
{
    $('#event_form').submit();
}

$('#customer_modal').on('hidden.bs.modal', function() 
{
    $(this).removeData('bs.modal');
    reloadCustomers();
});

$('#evt_complete_check').on('ifChecked', function(i,o)
{
    $('#ent_remarks_input').prop('readonly', false);
    $('#act_budget_input').prop('readonly', false);
});

$('#evt_complete_check').on('ifUnchecked', function(i,o)
{
    $('#ent_remarks_input').val("");
    $('#ent_remarks_input').prop('readonly', true);
    $('#act_budget_input').val("");
    $('#act_budget_input').prop('readonly', true);
});

function fetchHalls()
{
    $('#hall_select option').remove();
    $('#hall_select').prop('disabled', true);
    $('#hall_select').selectpicker('refresh');

    if($('#ven_select').selectpicker('val') != "")
    {
        $.getJSON("<?php echo base_url('transaction/event/fetch_halls') ?>", {'id' : $('#ven_select').selectpicker('val')},
        function (data)
        {
            if(!$.isEmptyObject(data))
            {
                $('#hall_select').prop('disabled', false);
                $('#hall_select').append('<option value = "">Select Hall</option>');

                $.each(data, function(i,o)
                {
                    $('#hall_select').append('<option data-subtext = "'+o['type']+'" value = "'+o['id']+'">' + o['name'] + "</option>");
                });

                $('#hall_select').selectpicker('refresh');
            }
        });
    }
}

function reloadCustomers()
{
    $('#cus_select option').remove();
    $('#cus_select').selectpicker('refresh');

    $.getJSON("<?php echo base_url('transaction/event/fetch_customers') ?>",
    function (data)
    {
        if(!$.isEmptyObject(data))
        {
            $('#cus_select').append('<option value = "">Select Customer</option>');

            $.each(data, function(i,o)
            {
                $('#cus_select').append('<option value = "'+o['id']+'">' + o['name'] + "</option>");
            });

            $('#cus_select').selectpicker('refresh');
        }
    });

    return;
}

function fetchSuppliers()
{
    $('#tbl_sup_select option').remove();
    $('#tbl_sup_select').selectpicker('refresh');

    $.getJSON("<?php echo base_url('transaction/event/fetch_suppliers') ?>",
    function (data)
    {
        if(!$.isEmptyObject(data))
        {
            $('#tbl_sup_select').append('<option value = "">Select Supplier</option>');

            $.each(data, function(i,o)
            {
                $('#tbl_sup_select').append('<option data-subtext = "'+o['sup_type_string']+'" value = "'+o['id']+'">' + o['name'] + "</option>");
            });

            $('#tbl_sup_select').selectpicker('refresh');
        }
    });

    return;
}

function loadSupplierTypes()
{
    $('#tbl_cat_select option').remove();
    $('#tbl_cat_select').selectpicker('refresh');

    if($('#tbl_sup_select').selectpicker('val') != "")
    {
        $.getJSON("<?php echo base_url('transaction/event/fetch_sup_types') ?>",{'id' : $('#tbl_sup_select').selectpicker('val')},
        function (data)
        {
            if(!$.isEmptyObject(data))
            {
                $('#tbl_cat_select').append('<option value = "">Select Supplier Role</option>');

                $.each(data, function(i,o)
                {
                    $('#tbl_cat_select').append('<option value = "'+o['id']+'">' + o['name'] + "</option>");
                });

                $('#tbl_cat_select').selectpicker('refresh');
            }
        });
    }

    return;
}

function addActivity()
{
    if($('#tbl_activity_input').val() != "" && $('#tbl_desc_input').val() != "" && $('#tbl_deadline_input').val() != "" && $('#tbl_sup_select').selectpicker('val') != "" && $('#tbl_cat_select').selectpicker('val') != "")
    {
        // var sup_string   = "";
        // var sup_id_array = new Array();

        // $.each($('#tbl_cat_select option:selected'), function(i,o)
        // {
        //     if(sup_string == "")
        //         sup_string += $(o).text();
        //     else
        //         sup_string += (", " + $(o).text());

        //     sup_id_array.push($(o).val());           
        // });

        $('#ent_activity_table_body').append('<tr id = "tr_'+activity_count+'"><td>'+(activity_count + 1)+'</td><td>'+$('#tbl_activity_input').val()+'</td><td>'+$('#tbl_desc_input').val()+'</td><td>'+$('#tbl_deadline_input').val()+'</td><td>'+$('#tbl_sup_select option:selected').text()+'</td><td>'+$('#tbl_cat_select option:selected').text()+'</td><td class = "text-right">'+($('#tbl_budget_input').val() != "" ? 'Rs. '+$('#tbl_budget_input').val()+'.00' : '')+'</td><td class = "text-center danger-bg">0%</td><td class = "text-center act_tr"><strong><a class = "text-danger" style = "cursor:pointer" onclick = "removeActivity(this, \''+activity_count+'\');"">Remove</a></strong></td></tr>');

        activity_list[activity_count] = {'activity' : $('#tbl_activity_input').val(), 'desc' : $('#tbl_desc_input').val(), 'deadline' : $('#tbl_deadline_input').val(), 'sup_id' : $('#tbl_sup_select').val(), 'role_ids' : $('#tbl_cat_select').selectpicker('val'), 'role' : $('#tbl_cat_select option:selected').text(), 'budget' : $('#tbl_budget_input').val(), 'new' : 1, 'com_perc' : 0};

        activity_count++;

        clearActivityFields();
        resetActivityIndex();
    }   
    else
    {
        toastr['error']('Required Fields Missing!');
    }

    return;
}

function clearActivityFields()
{
    $('#tbl_sup_select option').prop('selected', false);
    $('#tbl_cat_select').selectpicker('val', "");
    $('#tbl_cat_select,#tbl_sup_select').selectpicker('refresh');
    $('#tbl_activity_input,#tbl_desc_input,#tbl_deadline_input,#tbl_budget_input').val('');
}

function checkRemove(index)
{
    if(activity_list[index]['new'] == 0)
    {
        //CHECKING IF ACTIVITY HAS A CHECKLIST
        var act_status = validateActivity(activity_list[index]['act_id']);

        if(act_status == false)
        {
            showConfirmation("Are you sure the activity needs to be removed?", "The activity you are tring to remove has assigned checklist items", "removeActivity(null, "+index+");")
        }
        else
        {
            removeActivity(null, index);
        }
    }
    else
    {
        removeActivity(null, index);
    }

    return;
}

function removeActivity(e, index)
{
    if(activity_list[index]['new'] == 0)
    {
        remove_activity_list[remove_a_count] = activity_list[index];

        remove_a_count++;
    }

    if(e == null)
    {
        $('#tr_'+index).remove();
    }
    else
    {
        $(e).parent().parent().parent().remove();
    }
    
    delete activity_list[index];

    resetActivityIndex();

    return;
}

function resetActivityIndex()
{
    $.each($('#ent_activity_table_body tr:not("#input_row")'),function(i,o)
    {
        $(o).find('td').eq(0).html(i+1);
    });

    return;
}

function validateActivity(id)
{
    var act_status = null;

    $.ajax(
    {
        url: '<?php echo site_url("transaction/event/validate_activity") ?>',
        type: 'post',
        dataType: 'json',
        data : {'id':id},
        async: false,
        error: function(){alert("An Error Occurred, Please Try Again.")},
        success: function(data)
        {
            if(data != null)
            {
                if(data['count'] == 0)
                    act_status = true;
                else if(data['count'] > 0)
                    act_status = false;
            }
        }
    });

    return act_status;
}

function fetchEvent(ent_id, ent_mode)
{
    if(ent_id == "")
    {
        resetForm();
        return;
    }

    $.getJSON("<?php echo base_url('transaction/event/fetch_event') ?>", {'id' : ent_id},
    function (data)
    {
        if(!$.isEmptyObject(data))
        {
            // resetForm();

            if(!$.isEmptyObject(data['event']))
            {
                $('#evt_code_input').val(data['event']['code']);
                $('#evt_date_input').val(data['event']['date']);
                $('#start_time_input').val(data['event']['start']);
                $('#end_time_input').val(data['event']['end']);
                $('#evt_budget_input').val(data['event']['ini_budget']);
                $('#act_budget_input').val(data['event']['budget']);
                $('#total_fee_input').val(data['event']['fee']);
                $('#cus_select').selectpicker('val', data['event']['cus_id']);
                $('#evt_select').selectpicker('val', data['event']['type']);
                $('#ven_select').selectpicker('val', data['event']['ven_id']);
                $('#cus_req_input').val(data['event']['req']);
                $('#ent_remarks_input').val(data['event']['remarks']);

                if(data['event']['status'] == 1)
                {
                    $('#evt_complete_check').iCheck('check');
                }
                else
                {
                    $('#evt_complete_check').iCheck('uncheck');   
                }

                $.ajaxSetup({
                    async: false
                });

                fetchHalls();

                $.ajaxSetup({
                    async: true
                });

                $('#hall_select').selectpicker('val', data['event']['hall_id']);

                $('#cus_select,#evt_select,#hall_select').selectpicker('refresh');

                initial_date = data['event']['date']; 
                update_id    = data['event']['id'];

                if(!$.isEmptyObject(data['activities']))
                {
                    $.each(data['activities'], function(i,o)
                    {
                        $('#ent_activity_table_body').append('<tr id = "tr_'+activity_count+'"><td>'+(activity_count + 1)+'</td><td>'+o['activity']+'</td><td>'+o['desc']+'</td><td>'+o['deadline']+'</td><td>'+o['sup_name']+'</td><td>'+o['roles']+'</td><td class = "text-right">'+(o['act_budget'] != "" ? 'Rs. '+o['act_budget'] : '')+'</td><td class = "text-center '+(o['com_perc'] <= 25 ? 'danger-bg' : (o['com_perc'] <= 50 ? 'warning-bg' : (o['com_perc'] <= 75 ? 'info-bg' : (o['com_perc'] < 100 ? 'primary-bg' : (o['com_perc'] == 100 ? 'success-bg' : '')))))+'">'+o['com_perc']+'%</td><td class = "text-center act_tr"><strong><a class = "text-danger" style = "cursor:pointer" onclick = "checkRemove(\''+activity_count+'\');"">Remove</a></strong></td></tr>');

                        activity_list[activity_count] = {'activity' : o['activity'], 'desc' : o['desc'], 'deadline' : o['deadline'], 'sup_id' : o['sup_id'], 'role_ids' : o['role_ids'], 'role' : o['roles'], 'budget' : o['act_budget'], 'new' : 0, 'act_id' : o['act_id']};

                        activity_count++;
                    });

                    resetActivityIndex();
                }

                if(uri_mode == "e")
                {
                    $('input:not("#top_search,#act_budget_input")').prop('readonly', false);
                    $('textarea:not("#ent_remarks_input")').prop('readonly', false);
                    $('.selectpicker:not("#hall_select")').prop('disabled', false);
                    $('#evt_complete_check').iCheck('enable');
                    ent_activity_table.api().column( 7 ).visible( true );
                    $('#input_row').show();
                    $('.act_tr').show();
                    $('#cus_a_link').show();
                    $('#save_btn').show();
                    $('#cus_select,#evt_select,#hall_select,#ven_select').selectpicker('refresh');
                }
                else if(uri_mode == "v")
                {
                    $('input:not("#top_search,#act_budget_input")').prop('readonly', true);
                    $('textarea').prop('readonly', true);
                    $('.selectpicker').prop('disabled', true);
                    $('#evt_complete_check').iCheck('disable');
                    ent_activity_table.api().column( 7 ).visible( false );
                    $('#input_row').hide();
                    $('.act_tr').hide();
                    $('#cus_a_link').hide();
                    $('#save_btn').hide();
                    $('#cus_select,#evt_select,#hall_select,#ven_select').selectpicker('refresh');
                } 
            }
        }
    });
}

function validateEvent() //validating the date selected for the event. checking if another event is undertaken in the selected date
{
    if(update_id == false) //during add
    {
        //using $.getJSON to retrieve information. passing selected date and update ID.
        $.getJSON("<?php echo base_url('transaction/event/validate_event') ?>", {'date' : $('#evt_date_input').val(), 'start' : $('#start_time_input').val(), 'end' : $('#end_time_input').val()},
        function (data)
        {
            refreshNotifications(); //showing any notifications set at the model

            if(data['m']['count'] == 0 && data['e']['count'] == 0) //if no event and meetings are available
            {
                saveEvent();
            }
            else
            {
                if(data['m']['count'] > 0) //if one or more meetings are found
                {
                    //shows notification message
                    showConfirmation("Event Cannot Be Placed!", (data['m']['count'] != 1 ? data+' meetings are' : data['m']['count']+' meeting is')+" available during the selected date and time period. Please change or cancel meeting(s) and come back to place event.","", "");
                }
                else if(data['e']['count'] > 0) //if one or more events are found
                {
                    //show a confirmation message with yes and no options to save
                    showConfirmation("Are you sure you want to place an event?", (data['e']['count'] != 1 ? data['e']['count']+' events are' : data['e']['count']+' event is')+" already added for the selected date.", "saveEvent();");
                }
            }
        });
    }
    else //during update
    {
        if($('#evt_date_input').val() != initial_date) //validate date only if the date was changed. Not necessary if else since during adding it was validated
        {
            //using $.getJSON to retrieve information. passing selected date and update ID.
            $.getJSON("<?php echo base_url('transaction/event/validate_event') ?>", {'date' : $('#evt_date_input').val()},
            function (data)
            {
                refreshNotifications(); //showing any notifications set at the model

                if(data['m']['count'] == 0 && data['e']['count'] == 0) //if no events and meetings are available
                {
                    saveEvent();
                }
                else
                {
                    if(data['m']['count'] > 0) //if one or more meetings are found
                    {
                        //shows notification message
                        showConfirmation("Event Cannot Be Placed!", (data['m']['count'] != 1 ? data+' meetings are' : data['m']['count']+' meeting is')+" available during the selected date and time period. Please change or cancel meeting(s) and come back to place event.","", "");
                    }
                    else if(data['e']['count'] > 0) //if one or more events are found
                    {
                        //show a confirmation message with yes and no options to save
                        showConfirmation("Are you sure you want to place an event?", (data['e']['count'] != 1 ? data['e']['count']+' events are' : data['e']['count']+' event is')+" already added for the selected date.", "saveEvent();");
                    }
                }
            });
        }
        else
        {
            saveEvent();
        }
    }

    return;
}

function isNumber(event) //allow only integers to be typed
{
    var charCode = (event.which) ? event.which : event.keyCode //getting character

    //checking if character is not integer, tab or navigation arrow buttons
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && !(charCode >= 35 && charCode <= 39)) 
        return false; //return false. character is not valid

    return true; //valid character
}

function saveEvent() //saving information to database
{
    var data  = $('#event_form').serializeArray(); //getting all fields from the form

    data.push({'name' : 'activity_list', 'value' : JSON.stringify(activity_list)}); //adding the activity list to array being passsed to the backend. Object is first stringyfied
    data.push({'name' : 'remove_activity_list', 'value' : JSON.stringify(remove_activity_list)}); //adding the removed activity list to array being passsed to the backend. 
    data.push({'name' : 'update_id', 'value' : update_id}); //adding update_id which will hold the primary key if it is an update

    $.ajax( //ajax call
    {
       url: '<?php echo site_url("transaction/event/save_event")?>',
       type: 'post',
       dataType: 'json',
       data: data,
       async: false,
       error: function(){alert("An Error Occurred. Please Try Again.")}, //error event
       success: function(data) //success event
       {
            refreshNotifications(); //showing any notifications set at the model
            if(data) //if true
            {
                resetForm(); //reset the page as initial
            }
       } 
    });
}

function reloadSequence()
{
    $.ajax(
    {
        url: '<?php echo site_url("transaction/event/reload_sequence") ?>',
        type: 'post',
        dataType: 'json',
        async: false,
        error: function(){alert("An Error Occurred, Please Try Again.")},
        success: function(data)
        {
            $('#evt_code_input').val(data['code']);
        }
    });
}

function resetForm()
{
    loadModule('transaction/event/event_view');
}

</script>