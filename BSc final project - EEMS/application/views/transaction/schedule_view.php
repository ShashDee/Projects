<div class = "row">
    <div class = "col-md-6">
        <h1>Schedule</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Transaction</a>
            </li>
             <li class = "active">
                <a><strong>Schedule</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->

<div class = "wrapper animated fadeInRight">
    <div class="row">
        <div id = "calendar">
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.wrapper -->

<!-- Start of Meeting modal-->
<div class="modal fade" id="meeting_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Meeting <small> Showing options for creating meetings</small></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="modal_form">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-4" for = "title_input">Title</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="Title" name="title_input" id = "title_input" class="form-control">
                                </div>
                            </div>
                            <div class = "form-group">
                                <label class="col-md-4 control-label" for  = "ent_select">Event</label>
                                <div class = "col-md-6">
                                    <?php echo form_dropdown('ent_select', $ent, '', 'id = "ent_select" class = "form-control selectpicker" data-live-search = "true" data-container = "body" data-size = "5"'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4" for = "start_time_input">Start Time</label>
                                <div class="col-md-6">
                                    <div class="input-group time">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                        <input type="text" placeholder="Start Time" name="start_time_input" id = "start_time_input" class="form-control">
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-4" for = "end_time_input">End Time</label>
                                <div class="col-md-6">
                                    <div class="input-group time">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                        <input type="text" placeholder="End Time" name="end_time_input" id = "end_time_input" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class = "form-group">
                                <label class="control-label col-md-4" for = "desc_input">Description</label>
                                <div class="col-md-6">
                                    <textarea type="text" class="form-control" id="desc_input" name="desc_input" placeholder="Description" rows = "2"></textarea>
                                </div>
                            </div>
                            <div class = "form-group">
                                <label class="control-label col-md-4" for = "met_cancel_check">Cancelled</label>
                                <div class="col-md-8 checkbox">
                                    <input type="checkbox" class="sch_icheck" id = "met_cancel_check" name = "met_cancel_check">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick = "addMeeting();">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> <!-- End of Meeting modal -->

<div class="modal fade" id="event_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Event <small> Showing details of selected event</small></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="event_modal_form">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "col-md-10 col-md-offset-2">
                                <dl class = "dl-horizontal">
                                  <dt>Event Code</dt>
                                  <dd id = "code_holder" class="holders">...</dd>
                                  <dt>Event Type</dt>
                                  <dd id = "type_holder" class="holders">...</dd>  
                                  <dt>Customer</dt>
                                  <dd id = "customer_holder" class="holders">...</dd>
                                  <dt>Venue</dt>
                                  <dd id = "venue_holder" class="holders">...</dd>
                                  <dt>Time Period</dt>
                                  <dd id = "time_holder" class="holders">...</dd>
                                  <dt>Status</dt>
                                  <dd id = "status_holder" class="holders">...</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

var clicked_date = "";
var update_id    = false;

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

    $('.sch_icheck').iCheck(
    {
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $('#calendar').fullCalendar({
        // put your options and callbacks here
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        eventLimit: true, // allow "more" link when too many events
        dayClick: function(date, jsEvent, view) 
        {
            $('#ent_select').selectpicker('val', "");
            $('#ent_select').selectpicker('refresh');

            clicked_date = date.unix();

            $('#meeting_modal').modal('show');
            $('#met_cancel_check').iCheck('uncheck');
        },
        eventClick: function( event, jsEvent, view )
        {
            if(event.type == "M")
            {
                $('#ent_select').selectpicker('val', "");
                $('#ent_select').selectpicker('refresh');

                $('#meeting_modal').modal('show');
                $('#title_input').val(event.title);
                $('#ent_select').selectpicker('val', event.ent_id);
                $('#start_time_input').val(event.start_time);
                $('#end_time_input').val(event.end_time);
                $('#desc_input').val(event.desc);

                if(event.cancelled == 1)
                {
                    $('#met_cancel_check').iCheck('check');
                }
                else if(event.cancelled == 0)
                {
                    $('#met_cancel_check').iCheck('uncheck');
                }

                clicked_date = event.date;
                update_id    = (event.id).split('-')[1];
            }
            else if(event.type == "E")
            {
                $('#event_modal').modal('show')
                {
                    $('#code_holder').html(event.title);
                    $('#type_holder').html(event.ent_type);
                    $('#customer_holder').html(event.customer);
                    $('#venue_holder').html(event.venue);
                    $('#time_holder').html(event.start_time+" - "+event.end_time);
                    $('#status_holder').html(event.status);
                }
            }
        },
        events: function(start, end, timezone, callback) 
        {
            $.ajax(
            {
                url: '<?php echo site_url("transaction/schedule/fetch_events")?>',
                dataType: 'json',
                type: 'POST',
                async: false,
                data: {
                    // our hypothetical feed requires UNIX timestamps
                    start: start.unix(),
                    end: end.unix()
                },
                success: function(data) 
                {
                    var events = [];

                    if(!$.isEmptyObject(data))
                    {
                        events = data;
                    }

                    callback(events);
                }
            });
        }
    });
});

$('#meeting_modal').on('shown.bs.modal', function () 
{
    $('.sch_icheck').iCheck(
    {
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
})

$('#meeting_modal').on('hidden.bs.modal', function() 
{
    clicked_date = "";
    update_id    = false;
    resetModalForm();
});

$('#event_modal').on('hidden.bs.modal', function() 
{
    resetEventModal();
});

function addMeeting()
{
    if($('#ent_select option:selected').text() == "")
    {
        $('#ent_select').selectpicker('val', "");
        $('#ent_select').selectpicker('refresh');
    }

    var data = $('#modal_form').serializeArray();

    data.push({'name' : 'date', 'value' : clicked_date});
    data.push({'name' : 'update_id', 'value' : update_id});

    $.ajax(
    {
       url: '<?php echo site_url("transaction/schedule/save_meeting")?>',
       type: 'post',
       dataType: 'json',
       data: data,
       async: false,
       error: function(){alert("An Error Occurred. Please Try Again.")},
       success: function(data)
       {
            refreshNotifications();

            if(data != false)
            {
                $('#meeting_modal').modal('hide');
                addToCal(data);
            }
       } 
    });
}

function addToCal(source)
{
    $('#calendar').fullCalendar( 'removeEvents' , source['id'] );
    $('#calendar').fullCalendar( 'renderEvent', source );

    return;
}

function resetModalForm()
{
    $('#modal_form')[0].reset();
    $('#ent_select').selectpicker('val', "");
    $('#ent_select').selectpicker('refresh');
    $('#met_cancel_check').iCheck('uncheck');  

    return;
}

function resetEventModal()
{
    $('.holders').val("....");

    return;
}


</script>