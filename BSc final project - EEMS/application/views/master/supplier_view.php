<div class = "row">
    <div class = "col-md-6">
        <h1>Suppliers</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Master</a>
            </li>
            <li>
                <a onclick = "loadModule('master/supplier/supplier_lookup_view');">Supplier Lookup</a>
            </li>
             <li class = "active">
                <a><strong>Suppliers</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-6">
        <div class="title-action">
            <a class="btn btn-info" onclick="loadModule('master/supplier/supplier_lookup_view');"><i class="fa fa-eye"></i> Lookup </a>
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
                    <a data-toggle="collapse" href="#supplier_collapse">Suppliers <small class = "text-white"> Showing options for creation and updating of suppliers</small></a>
                </h4>
            </div>
            <div id="supplier_collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class = "form-horizontal" id = "supplier_form">
                        <div class = "row">
                            <div class = "col-md-12">

                                <div class = "col-md-6">

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "supplier_code_input">Supplier Code</label>                                    
                                        <div class="col-md-8">
                                            <input type = "text" placeholder = "Supplier Code" class = "form-control" id = "supplier_code_input" name = "supplier_code_input" value = "<?php echo $code; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "sup_name_input">Supplier Name</label>                                      
                                        <div class="col-md-8">
                                            <input type = "text" placeholder = "Supplier Name" class = "form-control" id = "sup_name_input" name = "sup_name_input" data-validation="required">
                                        </div>
                                    </div>

                                    <div class = "form-group">
                                        <label class="col-md-4 control-label" for  = "sup_type_select">Supplier Type</label>
                                        <div class = "col-md-8">
                                            <?php echo form_dropdown('sup_type_select[]', array(), '', 'id = "sup_type_select" class = "form-control selectpicker" data-live-search = "true" data-container = "body" data-size = "5" multiple'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="con_name_input">Contact Person</label>
                                        <div class="col-md-8">
                                        <div class="input-group">                                            
                                            <span class="input-group-addon">Name</span>
                                            <input type="text" class="form-control" id="con_name_input" name="con_name_input" placeholder="Contact Person Name" data-validation="required">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="con_design_input">&nbsp;</label>                                                                           
                                        <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">Designation</span>
                                            <input type="text" class="form-control" id="con_design_input" name="con_design_input" placeholder="Contact Person Designation" data-validation="required">
                                        </div>
                                        </div>
                                    </div>

                                </div>
                                <div class = "col-md-6">

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "sup_email_input">Email</label>                                      
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                <input type = "email" placeholder = "Email Address" class = "form-control" id = "sup_email_input" name = "sup_email_input" data-validation="email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "sup_skype_input">Skype</label>                                      
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-skype"></i></span>
                                                <input type = "text" placeholder = "Skype Address" class = "form-control" id = "sup_skype_input" name = "sup_skype_input">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "sup_min_rate_input">Minimum Rate</label>                                      
                                        <div class="col-md-8">
                                            <div class="input-group">                                            
                                                <span class="input-group-addon">Rs.</span>
                                                <input type = "text" placeholder = "Supplier Minimum Rate" class = "form-control text-right" id = "sup_min_rate_input" name = "sup_min_rate_input" onkeypress='return isNumber(event);' data-validation="required">
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

                        <div class = "row">
                            <div class = "col-md-12">

                                <div class = "hr-line-dashed"></div>
                                <h5>Branch Information</h5>
                                <div class = "hr-line-dashed"></div>

                                <div class = "table-responsive">
                                    <table id = "sup_branch_table" class = "table table-bordered table-hover table-striped compact">
                                        <thead>
                                            <th class = "text-center">#</th>
                                            <th class = "text-center">Office Number</th>
                                            <th class = "text-center">Mobile Number</th>
                                            <th class = "text-center">Address</th>
                                            <th class = "text-center">Action</th>
                                        </thead>
                                        <tbody id = "sup_branch_table_body">
                                            <tr class = "table-input" id = "input_row">
                                                <th></th>
                                                <th><input type = "text" id = "table_office_input" name = "table_office_input" placeholder = "Office Number" class = "form-control"  onkeypress='return isNumber(event);'></th>
                                                <th><input type = "text" id = "table_mobile_input" name = "table_mobile_input" placeholder = "Mobile Number" class = "form-control"  onkeypress='return isNumber(event);'></th>
                                                <th><input type = "text" id = "table_address_input" name = "table_address_input" placeholder = "Branch Address" class = "form-control"></th>
                                                <th><button type = "button" onclick = "addBranch();" id = "branch_add_btn" name = "branch_add_btn" class = "btn btn-block btn-primary">Add <i class = "fa fa-level-down"></i></button></th>
                                            </tr>
                                        </tbody>
                                    </table>
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

<div class="modal fade" id="add_sup_type_modal" role = "dialog" aria-labelledby="Supplier Types">
    <div class="modal-dialog modal-lg" role = "document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Supplier Types <small class ="m-l-sm">Showing options for supplier type creation.</small></h4>
            </div>
            <div class="modal-body">
                <div class = "row">
                    <form class="form-horizontal" id="sup_type_form">
                        <div class = "row">
                            <div class = "col-md-5 col-md-offset-1">
                                <div class = "form-group">
                                    <label class = "col-md-5  control-label" for = "sup_type_input">Supplier Type</label>
                                    <div class = "col-md-7"><input class = "form-control" type = "text" id = "sup_type_input" name = "sup_type_input" ></div>
                                </div>
                                <div class = "form-group">
                                    <div class = "col-md-2 col-md-offset-10"><button class="btn btn-primary pull-right" type="button" onclick="saveSupType();" id="add_sup_type_btn">Add</button></div>
                                </div>
                            </div>
                            <div class = "col-md-6">
                                <div class = "col-md-12">
                                    <table class = "table table-striped table-bordered table-hover table-condensed compact" id = "sup_type_table">
                                        <thead>
                                            <th>No</th>
                                            <th>Supplier Type</th>
                                        </thead>
                                        <tbody id = "sup_type_table_body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

var status_switch         = null;
var update_id             = false;
var sup_branch_table      = null;
var sup_type_table        = null;
var branch_entries        = new Object();
var branch_count          = 0;
var remove_branch_entries = new Object();
var remove_b_count        = 0;
var uri_sup_id            = "<?php echo $this->uri->segment(4); ?>";

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

    $('.date').datetimepicker(
    {
        format: 'YYYY-MM-DD',
        widgetPositioning: { horizontal: 'auto', vertical: 'bottom'}
    });

    sup_branch_table = $('#sup_branch_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"><"clear">',
        'bSort': false,
        'iDisplayLength' : -1,
        'responsive' : false,
        'autoWidth' : false
    });

    sup_type_table = $('#sup_type_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"p><"clear">',
        'bSort': false,
        'iDisplayLength' : 20,
        'responsive' : true,
        'autoWidth' : false,
        'sAjaxSource' : '<?php echo site_url("master/supplier/load_supplier_types") ?>',
        'fnServerData' : function(sSource, aoData, fnCallback, oSettigns){
        $.ajax({
            "dataType" : 'json',
            "type" : 'POST',
            "url" : sSource,
            "data" : aoData,
            "success" : fnCallback
        })},
        'aoColumns' : [
            { 'mData' : 'index', 'sClass' : 'text-center'},
            { 'mData' : 'sup_type'}
        ]
    });

    loadSupplierTypes();

    if(uri_sup_id != null && uri_sup_id != "")
    {
        fetchSupplier(uri_sup_id);
    }

    $.validate(
    {
        form : '#supplier_form',
        modules : 'security',
        onSuccess : function($form) 
        {
            saveSupplier();
            return false;
        }
    });
});

function preProcessSave()
{
    $('#supplier_form').submit();
}

function loadSupplierTypes()
{
    $('#sup_type_select option').remove();
    $('#sup_type_select').selectpicker('refresh');

    $.getJSON('<?php echo site_url("master/supplier/load_supplier_types")?>',
    function(data)
    {
        if(!jQuery.isEmptyObject(data['aaData']))
        {
            $('#sup_type_select').append('<option data-hidden="true" value = "">Select Supplier Type</option>');
            $('#sup_type_select').append('<option value="modal" title = "" class = "text-center btn btn-default">Add Supplier Type</option><option data-divider = "true"></option');

            $.each(data['aaData'],function(i,o)
            {
                $('#sup_type_select').append('<option value = "'+o['id']+'">' + o['sup_type'] + "</option>");
            });
        }
        else
        {
            $('#sup_type_select').append('<option data-hidden="true" value = "">Select Supplier Type</option>');
            $('#sup_type_select').append('<option value="modal" title = "" class = "text-center btn btn-default">Add Supplier Type</option><option data-divider = "true"></option');
        }

        $('#sup_type_select').selectpicker('refresh');

    },'json');

    sup_type_table.api().ajax.reload();
}

$('#sup_type_select').on('change', function()
{
    if($.inArray("modal", $('#sup_type_select').selectpicker('val')) != -1)
    {
        $("#sup_type_select option[value='modal']").prop("selected", false);
        $('#sup_type_select').selectpicker('refresh');
        $('#add_sup_type_modal').modal('show');
    }
});

function addBranch()
{
    if($('#table_office_input').val() != "" && $('#table_mobile_input').val() != "" && $('#table_address_input').val() != "")
    {
        $('#sup_branch_table_body').append('<tr><td>'+(branch_count + 1)+'</td><td>'+$('#table_office_input').val()+'</td><td>'+$('#table_mobile_input').val()+'</td><td>'+$('#table_address_input').val()+'</td><td class = "text-center"><strong><a class = "text-danger" style = "cursor:pointer" onclick = "removeBranch(this, \''+branch_count+'\');"">Remove</a></strong></td></tr>');

        branch_entries[branch_count] = {'office' : $('#table_office_input').val(), 'mobile' : $('#table_mobile_input').val(), 'address' : $('#table_address_input').val(), 'new' : 1};

        branch_count++;

        clearBranchFields();
    }   
    else
    {
        toastr['error']('All Fields Required!');
    }

    resetBranchIndex();
}

function clearBranchFields()
{
    $('#table_office_input').val('');
    $('#table_mobile_input').val('');
    $('#table_address_input').val('');

    return;
}

function resetBranchIndex()
{
    $.each($('#sup_branch_table_body tr:not("#input_row")'),function(i,o)
    {
        $(o).find('td').eq(0).html(i+1);
    });

    return;
}

function removeBranch(e, index)
{
    if(branch_entries[index]['new'] == 0)
    {
        remove_branch_entries[remove_b_count] = branch_entries[index];

        remove_b_count++;
    }

    $(e).parent().parent().parent().remove();

    delete branch_entries[index];

    resetBranchIndex();
}

function isNumber(event)
{
    var charCode = (event.which) ? event.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && !(charCode >= 35 && charCode <= 39))
        return false;

    return true;
}

function fetchSupplier(supplier_id)
{
    if(supplier_id == "")
    {
        resetForm();
        return;
    }

    $.getJSON("<?php echo site_url('master/supplier/fetch_supplier') ?>", {'id' : supplier_id},
    function (data)
    {
        if(!jQuery.isEmptyObject(data))
        {
            resetForm();

            if(!jQuery.isEmptyObject(data['supplier']))
            {
                $('#supplier_code_input').val(data['supplier']['code']);
                $('#sup_name_input').val(data['supplier']['name']);
                $('#con_name_input').val(data['supplier']['contat_person']);
                $('#con_design_input').val(data['supplier']['con_desig']);
                $('#sup_email_input').val(data['supplier']['email']);
                $('#sup_skype_input').val(data['supplier']['skype']);
                $('#sup_type_select').selectpicker('val', data['supplier']['sup_type']);
                $('#sup_min_rate_input').val(data['supplier']['min_rate']);

                var status_switch = document.querySelector('#status_switch');

                if(data['supplier']['status'] == "1")
                {
                    status_switch.checked = true;
                    onChange(status_switch);
                }  
                else if(data['supplier']['status'] == "0")
                {
                    status_switch.checked = false;
                    onChange(status_switch);
                }

                update_id = data['supplier']['id'];
            }

            if(!jQuery.isEmptyObject(data['branch']))
            {
                $.each(data['branch'], function(i,o)
                {
                    $('#sup_branch_table_body').append('<tr><td>'+(branch_count + 1)+'</td><td>'+o['office']+'</td><td>'+o['mobile']+'</td><td>'+o['address']+'</td><td class = "text-center"><strong><a class = "text-danger" style = "cursor:pointer" onclick = "removeBranch(this, \''+branch_count+'\');"">Remove</a></strong></td></tr>');

                    branch_entries[branch_count] = {'office' : o['office'], 'mobile' : o['mobile'], 'address' : o['address'], 'new' : 0, 'branch_id' : o['branch_id']};

                    branch_count++;
                });

                resetBranchIndex();
            }
        }
    });

    return;
}

function saveSupType()
{
    var data = $('#sup_type_form').serializeArray();

    $.ajax(
    {
        url : '<?php echo site_url("master/supplier/save_sup_type")?>',
        type : 'post',
        data : data,
        dataType : 'json',
        async : false,
        error : function(){alert('An Error Occured. Please Try Again Later!')},
        success : function()
        {
            refreshNotifications();
            if(data)
            {
                resetModal();
                sup_type_table.api().ajax.reload();
                loadSupplierTypes();
            }
        }
    });
}

function resetModal()
{
    $('#sup_type_form')[0].reset();
}

function saveSupplier()
{
    var data = $('#supplier_form').serializeArray();

    data.push({'name' : 'branch_entries', 'value' : JSON.stringify(branch_entries)});
    data.push({'name' : 'remove_branch_entries', 'value' : JSON.stringify(remove_branch_entries)});
    data.push({'name' : 'update_id', 'value' : update_id});

    $.ajax(
    {
       url: '<?php echo site_url("master/supplier/save_supplier")?>',
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
        url: '<?php echo site_url("master/supplier/reload_sequence") ?>',
        type: 'post',
        dataType: 'json',
        async: false,
        error: function(){alert("An Error Occurred, Please Try Again.")},
        success: function(data)
        {
            $('#supplier_code_input').val(data['code']);
        }
    });
}

function resetForm()
{
    $('#supplier_form')[0].reset();

    update_id             = false;
    branch_entries        = new Object();
    branch_count          = 0;
    remove_branch_entries = new Object();
    remove_b_count        = 0;

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

    $('.selectpicker option').prop('selected', false);
    $('.selectpicker').selectpicker('refresh');

    $('#sup_branch_table_body tr:not("#input_row")').remove();

    reloadSequence();
}

var changeCheckbox = document.querySelector('.js-switch')
var state          = changeCheckbox.checked;

changeCheckbox.onchange = function(e) 
{
    if(state == true && update_id != false)
    {
        $.getJSON("<?php echo site_url('master/supplier/check_tasks') ?>", {'update_id' : update_id},
        function (data)
        {
            if(!jQuery.isEmptyObject(data))
            {   
                if(data['events'] > 0)
                {
                    $('#validation_placeholder').html('<div class = "alert alert-danger"><strong class = "text-danger">Supplier is assigned to activities of an upcoming event. Cannot Deactive.</strong></div>');
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