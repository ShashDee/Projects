<div class = "row">
    <div class = "col-md-8">
        <h1>Event Activity Checklist</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Transaction</a>
            </li>
            <li>
                <a>Events</a>
            </li>
            <li>
                <a onclick = "loadModule('transaction/checklist/checklist_lookup_view');">Activity Checklist Lookup</a>
            </li>
             <li class = "active">
                <a><strong>Event Activity Checklist</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-4">
        <div class="title-action">
            <a class="btn btn-info" onclick="loadModule('transaction/checklist/checklist_lookup_view');"><i class="fa fa-eye"></i> View Events </a>
            <a class="btn btn-info" onclick="loadLookup()"><i class="fa fa-eye"></i> View Checklists </a>
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
                    <a data-toggle="collapse" href="#event_collapse">Event Activity Checklist <small class = "text-white"> Showing options for creation and update of activity checklists</small></a>
                </h4>
            </div>
            <div id="event_collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class = "form-horizontal" id = "event_form">

                        <div class = "table-responsive">
                            <table id = "act_checklist_table" class = "table table-bordered table-hover table-striped compact">
                                <thead>
                                    <th class = "text-center">#</th>
                                    <th class = "text-center">Activity</th>
                                    <th class = "text-center">Checklist Item</th>
                                    <th class = "text-center">Deadline</th>
                                    <th class = "text-center">Incharge</th>
                                    <th class = "text-center">Status</th>
                                    <th class = "text-center">Action</th>
                                </thead>
                                <tbody id = "act_checklist_table_body">
                                    <tr class = "table-input" id = "input_row">
                                        <th></th>
                                        <th><?php echo form_dropdown('act_select', array(), '', 'id = "act_select" class = "form-control selectpicker" data-live-search = "true" data-container = "body" data-size = "5"'); ?></th>
                                        <th><input type="text" placeholder="Checklist Item" name="tbl_ckl_input" id = "tbl_ckl_input" class="form-control"></th>
                                        <th>
                                            <div class = "input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" placeholder="Deadline" value="<?php echo date('Y-m-d')?>" name="tbl_deadline_input" id = "tbl_deadline_input" class="form-control date">
                                            </div>
                                        </th>
                                        <th><?php echo form_dropdown('emp_select', $emp, '', 'id = "emp_select" class = "form-control selectpicker" data-live-search = "true" data-container = "body" data-size = "5"'); ?></th>
                                        <th><button type="button" class="btn btn-success btn-disabled-success" disabled>On Progress </button></th>
                                        <th><button type = "button" onclick = "addChecklistItem();" id = "ckl_add_btn" name = "ckl_add_btn" class = "btn btn-block btn-primary">Add <i class = "fa fa-level-down"></i></button></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class = "hr-line-dashed"></div>

                        <span class = "pull-right">                             
                            <button class="btn btn-primary" type="button" id="save_btn" onclick = "saveChecklists();">Save</button>
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

<script type="text/javascript">

var act_checklist_table    = null;
var uri_ent_id             = "<?php echo $this->uri->segment(4); ?>";
var checklist_items        = new Object();
var checklist_count        = 0;
var remove_checklist_items = new Object();
var remove_c_count         = 0;

$(document).ready(function()
{
    $('.selectpicker').selectpicker();

    act_checklist_table = $('#act_checklist_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"><"clear">',
        'bSort': false,
        'iDisplayLength' : -1,
        'responsive' : false,
        'autoWidth' : false
    });

    $('.status_checkbox').iCheck(
    {
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $('.date').datetimepicker(
    {
        format: 'YYYY-MM-DD',
        widgetPositioning: { horizontal: 'auto', vertical: 'bottom'},
    });

    if(uri_ent_id != "" && uri_ent_id != null)
    {
        fetchActivties(uri_ent_id);
        fetchChecklists(uri_ent_id);
    }
});

function fetchActivties(ent_id)
{
    if(ent_id == "")
    {
        return false;
    }

    $('#act_select option').remove();
    $('#act_select option').selectpicker('refresh');

    $.getJSON("<?php echo base_url('transaction/checklist/fetch_activities') ?>", {'id' : ent_id},
    function (data)
    {
        if(!$.isEmptyObject(data))
        {
            $('#act_select').append('<option value = "">Select Activity</option>');

            $.each(data, function(i,o)
            {
                $('#act_select').append('<option data-subtext = "'+o['deadline']+'" value = "'+o['act_id']+'">' + o['activity'] + "</option>");
            });

            $('#act_select').selectpicker('refresh');
        }
    });

    return;
}

function fetchChecklists(ent_id)
{
    if(ent_id == "")
    {
        return false;
    }

    $.getJSON("<?php echo base_url('transaction/checklist/fetch_checklists') ?>", {'id' : ent_id},
    function (data)
    {
        if(!$.isEmptyObject(data['aaData']))
        {
            $.each(data['aaData'], function(i,o)
            {
                if($('#act_'+o['act_id']).length == 0)
                    $('#act_checklist_table_body').append('<tr id = "act_'+o['act_id']+'"><th colspan = "6">'+o['activity']+" | Deadline : "+o['deadline']+'<th></tr>');
                else
                    $('#act_'+o['act_id']).show();

                $('#act_'+o['act_id']).after('<tr class = "ckl_tr" id = "tr_ckl_'+checklist_count+'"><td colspan = "2" class = "text-center">'+(checklist_count + 1)+'</td><td>'+o['item']+'</td><td>'+o['ckl_deadline']+'</td><td>'+o['assigned_name']+'</td><td class = "text-center"><input type = "checkbox" class="status_checkbox" '+(o['status'] == 1 ? "checked" : "")+'></td><td><strong><a class = "text-danger" style = "cursor:pointer" onclick = "removeChecklistItem(this, \''+checklist_count+'\');"">Remove</a></strong></t</tr>');
            
                checklist_items[checklist_count] = {'act_id' : o['act_id'], 'act_name' : o['activity'], 'checklist_itm' : o['item'], 'deadline' : o['ckl_deadline'], 'emp_id' : o['incharge'], 'emp_name' : o['assigned_name'], 'status' : o['status'], 'acl_id' : o['id'], 'new' : 0, 'old_status' : o['status'], 'org_com_date' : o['completed']};

                checklist_count++;
            });

            resetChecklistIndex();

            $('.status_checkbox').iCheck(
            {
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        }
    });

    return;
}

function addChecklistItem()
{
    if($('#act_select').selectpicker('val') != "" && $('#tbl_ckl_input').val() != "" && $('#tbl_deadline_input').val() != "" && $('#emp_select').selectpicker('val') != "")
    {
        if($('#act_'+$('#act_select').selectpicker('val')).length == 0)
            $('#act_checklist_table_body').append('<tr id = "act_'+$('#act_select').selectpicker('val')+'"><th colspan = "6">'+$('#act_select option:selected').text()+" | Deadline : "+$('#act_select option:selected').data('subtext')+'<th></tr>');
        else
            $('#act_'+$('#act_select').selectpicker('val')).show();

        $('#act_'+$('#act_select').selectpicker('val')).after('<tr class = "ckl_tr" id = "tr_ckl_'+checklist_count+'"><td colspan = "2" class = "text-center">'+(checklist_count + 1)+'</td><td>'+$('#tbl_ckl_input').val()+'</td><td>'+$('#tbl_deadline_input').val()+'</td><td>'+$('#emp_select option:selected').text()+'</td><td class = "text-center"><input type = "checkbox" class="status_checkbox"></td><td><strong><a class = "text-danger" style = "cursor:pointer" onclick = "removeChecklistItem(this, \''+checklist_count+'\');"">Remove</a></strong></t</tr>');
    
        checklist_items[checklist_count] = {'act_id' : $('#act_select').selectpicker('val'), 'act_name' : $('#act_select option:selected').text(), 'checklist_itm' : $('#tbl_ckl_input').val(), 'deadline' : $('#tbl_deadline_input').val(), 'emp_id' : $('#emp_select').selectpicker('val'), 'emp_name' : $('#emp_select option:selected').text(), 'status' : 0, 'new' : 1};

        checklist_count++;

        $('.status_checkbox').iCheck(
        {
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    
        clearChecklistFields();
        resetChecklistIndex();
    }
}

function clearChecklistFields()
{
    $('#act_select option,#emp_select option').prop('selected', false);
    $('#act_select,#emp_select').selectpicker('refresh');
    $('#tbl_ckl_input,#tbl_deadline_input').val('');
}

function removeChecklistItem(e, index)
{
    if(checklist_items[index]['new'] == 0)
    {
        remove_checklist_items[remove_c_count] = checklist_items[index];

        remove_c_count++;
    }

    var cur_activity = checklist_items[index]['act_id'];

    $(e).parent().parent().parent().remove();

    delete checklist_items[index];

    var act_count = 0;

    $.each(checklist_items, function(i,o)
    {
        if(o['act_id'] == cur_activity)
            act_count++;        
    });

    if(act_count == 0)
    {
        $('#act_'+cur_activity).hide();
    }

    resetChecklistIndex();
}

function resetChecklistIndex()
{
    $.each($('.ckl_tr'),function(i,o)
    {
        $(o).find('td').eq(0).html(i+1);
    });

    return;
}

function loadLookup()
{
    loadModule('transaction/checklist/event_checklist_lookup_view/' + uri_ent_id + '/a');
}

function saveChecklists()
{
    $.each($('.status_checkbox'), function(i,o)
    {
        var tr_id = ($(o).parent().parent().parent().attr('id')).split("_")[2];

        if($(o).is(':checked'))
        {
            checklist_items[tr_id]['status'] = 1;
        }
        else
        {
            checklist_items[tr_id]['status'] = 0;
        }
    });

    var data = new Array();

    data.push({'name' : 'checklist_items', 'value' : JSON.stringify(checklist_items)});
    data.push({'name' : 'remove_checklist_items', 'value' : JSON.stringify(remove_checklist_items)});

    $.ajax(
    {
       url: '<?php echo site_url("transaction/checklist/save_checklists")?>',
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
                loadModule('transaction/checklist/checklist_lookup_view');
            }
       } 
    });
}

</script>