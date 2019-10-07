<div class = "row">
    <div class = "col-md-6">
        <h1>Event Types</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Configuration</a>
            </li>
            <li>
                <a onclick = "loadModule('config/event_type/event_type_lookup_view');">Event Types Lookup</a>
            </li>
             <li class = "active">
                <a><strong>Event Types</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-6">
        <div class="title-action">
            <a class="btn btn-info" onclick="loadModule('config/event_type/event_type_lookup_view');"><i class="fa fa-eye"></i> Lookup </a>
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
                    <a data-toggle="collapse" href="#event_type_collapse">Event Types <small class = "text-white"> Showing options for creation of event types</small></a>
                </h4>
            </div>
            <div id="event_type_collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class = "form-horizontal" id = "event_type_form">
                        <div class = "row">
                            <div class = "col-md-6 col-md-offset-2">

                                <div class="form-group"> 
                                    <label class="col-md-4 control-label" for  = "evt_code_input">Event Type Code</label>                                      
                                    <div class="col-md-8">
                                        <input type = "text" placeholder = "Event Type Code" class = "form-control" id = "evt_code_input" name = "evt_code_input"  value = "<?php echo $code; ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group"> 
                                    <label class="col-md-4 control-label" for  = "event_type_input">Event Type</label>                                      
                                    <div class="col-md-8">
                                        <input type = "text" placeholder = "Event Type" class = "form-control" id = "event_type_input" name = "event_type_input" data-validation="required">
                                    </div>
                                </div>

                                <div class="form-group"> 
                                    <label class="col-md-4 control-label" for  = "event_short_input">Event Shortname</label>                                      
                                    <div class="col-md-8">
                                        <input type = "text" placeholder = "Event Shortname" class = "form-control" id = "event_short_input" name = "event_short_input">
                                    </div>
                                </div>

                                <div class = "form-group">
                                    <label class = "control-label col-md-4" for  = "status_switch">Status</label>
                                    <div class = "col-md-2">
                                        <input id = "status_switch" name = "status_switch" type = "checkbox" class="js-switch" checked/>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class = "hr-line-dashed"></div>

                        <span class = "pull-right">                             
                            <button class="btn btn-primary" type="button" id="save_btn" onclick = "preProcessSave();">Save</button>
                            <button class="btn btn-default" type="reset" onclick="resetForm();">Reset</button>
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

var status_switch     = null;
var update_id         = false;
var uri_event_type_id = "<?php echo $this->uri->segment(4); ?>";

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

    if(uri_event_type_id != null)
    {
        fetchEventType(uri_event_type_id);
    }

    $.validate(
    {
        form : '#event_type_form',
        modules : 'security',
        onSuccess : function($form) 
        {
            saveEventType();
            return false;
        }
    });
});

function preProcessSave()
{
    $('#event_type_form').submit();
}

function fetchEventType(event_type_id)
{
    if(event_type_id == null)
    {
        resetForm();
        return;
    }

    $.getJSON("<?php echo base_url('config/event_type/fetch_event_type') ?>", {'id' : event_type_id},
    function (data)
    {
        if(!jQuery.isEmptyObject(data))
        {
            $('#evt_code_input').val(data[0]['code']);
            $('#event_type_input').val(data[0]['event_type']);
            $('#event_short_input').val(data[0]['shortname']);

            var status_switch = document.querySelector('#status_switch');

            if(data[0]['status'] == "1")
            {
                status_switch.checked = true;
                onChange(status_switch);
            }  
            else if(data[0]['status'] == "0")
            {
                status_switch.checked = false;
                onChange(status_switch);
            }

            update_id = data[0]['id'];
        }
    });

    return;
}   

function saveEventType()
{
    var data = $('#event_type_form').serializeArray();

    data.push({'name' : 'update_id', 'value' : update_id});

    $.ajax(
    {
       url: '<?php echo site_url("config/event_type/save_event_type")?>',
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
        url: '<?php echo site_url("config/event_type/reload_sequence") ?>',
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
    $('#event_type_form')[0].reset();
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