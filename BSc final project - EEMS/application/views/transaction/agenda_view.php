<div class = "row">
    <div class = "col-md-8">
        <h1>Event Agenda</h1>
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
             <li class = "active">
                <a><strong>Event Agenda</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-8 -->
</div>
<!-- /.row -->

<div class = "wrapper animated fadeInRight">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#event_collapse">Event Agenda <small class = "text-white"> Showing options for creation and update of event agenda</small></a>
                </h4>
            </div>
            <div id="event_collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class = "form-horizontal" id = "event_form">
                        <div class = "row">
                            <div class = "col-md-12">
                                <div class = "col-md-6 col-md-offset-3">
                                    <div class = "form-group">
                                        <label class="col-md-4 control-label" for  = "ent_select">Event</label>
                                        <div class = "col-md-8">
                                            <select name = "ent_select" id = "ent_select" class = "form-control selectpicker" data-container = "body" data-live-search = "true" data-size = "5" onChange = "fetchAgenda();">
                                                <?php echo $ent_select; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class = "hr-line-dashed"></div>

                        <div class = "table-responsive">
                            <table id = "agenda_table" class = "table table-bordered table-hover table-striped compact">
                                <thead>
                                    <th class = "text-center" width = "10%">#</th>
                                    <th class = "text-center">Agenda Item</th>
                                    <th class = "text-center">Start Time</th>
                                    <th class = "text-center">End Time</th>
                                    <th class = "text-center" width = "20%">Action</th>
                                </thead>
                                <tbody id = "agenda_table_body">
                                    <tr class = "table-input" id = "input_row">
                                        <th></th>
                                        <th><input type="text" placeholder="Agenda Item" name="tbl_agenda_input" id = "tbl_agenda_input" class="form-control"></th>
                                        <th>
                                            <div class="input-group time">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                <input type="text" placeholder="Start Time" name="start_time_input" id = "start_time_input" class="form-control">
                                            </div>
                                        </th>
                                        <th>
                                            <div class="input-group time">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                <input type="text" placeholder="End Time" name="end_time_input" id = "end_time_input" class="form-control">
                                            </div>
                                        </th>
                                        <th><button type = "button" onclick = "addItem();" id = "agd_add_btn" name = "agd_add_btn" class = "btn btn-block btn-primary">Add <i class = "fa fa-level-down"></i></button></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class = "hr-line-dashed"></div>

                        <span class = "pull-right">                             
                            <button class="btn btn-primary" type="button" id="save_btn" onclick = "saveAgenda();">Save</button>
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

var agenda_table        = null;
var update_id           = false;
var agenda_items        = new Object();
var agenda_count        = 0;
var remove_agenda_items = new Object();
var remove_a_count      = 0;

$(document).ready(function()
{
    $('.selectpicker').selectpicker();

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

    agenda_table = $('#agenda_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"><"clear">',
        'bSort': false,
        'iDisplayLength' : -1,
        'responsive' : false,
        'autoWidth' : false
    });
});

function addItem()
{
    if($('#ent_select').selectpicker('val') != "")
    {
        if($('#tbl_agenda_input').val() != "" && $('#start_time_input').val() != "" && $('#end_time_input').val() != "")
        {
            $('#agenda_table_body').append('<tr><td class = "text-center">'+(agenda_count + 1)+'</td><td>'+$('#tbl_agenda_input').val()+'</td><td>'+$('#start_time_input').val()+'</td><td>'+$('#end_time_input').val()+'</td><td class = "text-center tr_agd"><strong><a class = "text-danger" style = "cursor:pointer" onclick = "removeAgenda(this, \''+agenda_count+'\');"">Remove</a></strong></td></tr>');

            agenda_items[agenda_count] = {'agenda_item' : $('#tbl_agenda_input').val(), 'start' : $('#start_time_input').val(), 'end' : $('#end_time_input').val(), 'new' : 1};

            agenda_count++;

            clearAgendaFields();
            resetAgendaIndex();
        }   
        else
        {
            toastr['error']('Required Fields Missing!');
        }
    }
    else
    {
        toastr['error']('Please Select An Event to Add Agenda Items.');
    }

    return;
}

function clearAgendaFields()
{
    $('#tbl_agenda_input,#start_time_input,#end_time_input').val('');
}

function removeAgenda(e, index)
{
    if(agenda_items[index]['new'] == 0)
    {
        remove_agenda_items[remove_a_count] = agenda_items[index];

        remove_a_count++;
    }

    $(e).parent().parent().parent().remove();

    delete agenda_items[index];

    resetAgendaIndex();
}

function resetAgendaIndex()
{
    $.each($('#agenda_table_body tr:not("#input_row")'),function(i,o)
    {
        $(o).find('td').eq(0).html(i+1);
    });

    return;
}

function fetchAgenda()
{
    $('#agenda_table_body tr:not("#input_row")').remove();
    agenda_table.api().column( 4 ).visible( true );
    $('#input_row').show();
    $('.tr_agd').show();
    $('#save_btn').show();
    agenda_items = new Object();
    agenda_count = 0;

    if($('#ent_select').selectpicker('val') != "")
    {
        $.getJSON("<?php echo base_url('transaction/agenda/fetch_agenda') ?>", {'id' : $('#ent_select').selectpicker('val')},
        function (data)
        {
            if(!$.isEmptyObject(data))
            {
                $.each(data, function(i,o)
                {
                    $('#agenda_table_body').append('<tr><td class = "text-center">'+(agenda_count + 1)+'</td><td>'+o['agenda_item']+'</td><td>'+o['start_time']+'</td><td>'+o['end_time']+'</td><td class = "text-center tr_agd"><strong><a class = "text-danger" style = "cursor:pointer" onclick = "removeAgenda(this, \''+agenda_count+'\');"">Remove</a></strong></td></tr>');

                    agenda_items[agenda_count] = {'agenda_item' : o['agenda_item'], 'start' : o['start_time'], 'end' : o['end_time'], 'new' : 0, 'ead_id' : o['id']};

                    agenda_count++;
                });

                resetAgendaIndex();  

                if($('#ent_select option:selected').data('status') == 1)
                {
                    agenda_table.api().column( 4 ).visible( false );
                    $('#input_row').hide();
                    $('.tr_agd').hide();
                    $('#save_btn').hide();
                }
                else if($('#ent_select option:selected').data('status') == 0)
                {
                    agenda_table.api().column( 4 ).visible( true );
                    $('#input_row').show();
                    $('.tr_agd').show();
                    $('#save_btn').show();
                }
            }
        })
    }
    else
    {
        resetForm();
    }
}

function saveAgenda()
{
    var data = $('#event_form').serializeArray();

    data.push({'name' : 'agenda_items', 'value' : JSON.stringify(agenda_items)});
    data.push({'name' : 'remove_agenda_items', 'value' : JSON.stringify(remove_agenda_items)});

    $.ajax(
    {
       url: '<?php echo site_url("transaction/agenda/save_agenda")?>',
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
    loadModule('transaction/agenda/agenda_view');
}

</script>