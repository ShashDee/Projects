<div class = "row">
    <div class = "col-md-6">
        <h1>Venues</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Master</a>
            </li>
            <li>
                <a onclick = "loadModule('master/venue/venue_lookup_view');">Venue Lookup</a>
            </li>
             <li class = "active">
                <a><strong>Venues</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-6">
        <div class="title-action">
            <a class="btn btn-info" onclick="loadModule('master/venue/venue_lookup_view');"><i class="fa fa-eye"></i> Lookup </a>
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
                    <a data-toggle="collapse" href="#venue_collapse">Venues <small class = "text-white"> Showing options for creation and updating of venues</small></a>
                </h4>
            </div>
            <div id="venue_collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class = "form-horizontal" id = "venue_form">
                        <div class = "row">
                            <div class = "col-md-12">

                                <div class = "col-md-6">

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "venue_code_input">Venue Code</label>                                    
                                        <div class="col-md-8">
                                            <input type = "text" placeholder = "Venue Code" class = "form-control" id = "venue_code_input" name = "venue_code_input" value = "<?php echo $code; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "ven_name_input">Venue Name</label>                                      
                                        <div class="col-md-8">
                                            <input type = "text" placeholder = "Venue Name" class = "form-control" id = "ven_name_input" name = "ven_name_input" data-validation="required">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="con_no1_input">Contact Number</label>
                                        <div class="col-md-8">
                                        <div class="input-group">                                            
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" class="form-control" id="con_no1_input" name="con_no1_input" placeholder="Contact Number One" onkeypress = "return isNumber(event);" data-validation="required">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="con_no2_input">&nbsp;</label>                                                                           
                                        <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" class="form-control" id="con_no2_input" name="con_no2_input" placeholder="Contact Number Two" onkeypress = "return isNumber(event);">
                                        </div>
                                        </div>
                                    </div>

                                </div>
                                <div class = "col-md-6">

                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="ven_add_input">Address</label>
                                        <div class="col-md-8">
                                            <textarea type="text" class="form-control" id="ven_add_input" name="ven_add_input" placeholder="Venue Address" rows = "4" data-validation="required"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="col-md-4 control-label" for  = "ven_email_input">Email</label>                                      
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                <input type = "email" placeholder = "Email Address" class = "form-control" id = "ven_email_input" name = "ven_email_input" data-validation="email">
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
                                <h5>Hall Information</h5>
                                <div class = "hr-line-dashed"></div>

                                <table id = "hall_table" class = "table table-bordered table-hover table-striped compact">
                                    <thead>
                                        <th class = "text-center">#</th>
                                        <th class = "text-center">Hall Name</th>
                                        <th class = "text-center">Type</th>
                                        <th class = "text-center">Accomadation</th>
                                        <th class = "text-center">Price (Rs.)</th>
                                        <th class = "text-center">Action</th>
                                    </thead>
                                    <tbody id = "hall_table_body">
                                        <tr class = "table-input" id = "input_row">
                                            <th></th>
                                            <th><input type = "text" id = "tbl_hall_input" name = "tbl_hall_input" placeholder = "Hall Name" class = "form-control"></th>
                                            <th><?php echo form_dropdown('hall_type_select', array('indoor' => 'Indoor', 'outdoor' => 'Outdoor'),'','id = "hall_type_select" class = "form-control selectpicker" data-container = "body"');?></th>
                                            <th><input type = "text" id = "tbl_accomadation_input" name = "tbl_accomadation_input" placeholder = "No. of People" class = "form-control text-right" onkeypress = "return isNumber(event);"></th>
                                            <th><input type = "text" id = "tbl_price_input" name = "tbl_price_input" placeholder = "Price" class = "form-control text-right" onkeypress = "return isNumber(event);"></th>
                                            <th><button type = "button" onclick = "addHall();" id = "hall_add_btn" name = "hall_add_btn" class = "btn btn-block btn-primary">Add <i class = "fa fa-level-down"></i></button></th>
                                        </tr>
                                    </tbody>
                                </table>
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

var status_switch       = null;
var update_id           = false;
var hall_table          = null;
var hall_entries        = new Object();
var hall_count          = 0;
var remove_hall_entries = new Object();
var remove_h_count      = 0;
var uri_ven_id          = "<?php echo $this->uri->segment(4); ?>";

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

    $('.date').datetimepicker(
    {
        format: 'YYYY-MM-DD',
        widgetPositioning: { horizontal: 'auto', vertical: 'bottom'}
    });

    hall_table = $('#hall_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"><"clear">',
        'bSort': false,
        'iDisplayLength' : -1,
        'responsive' : true,
        'autoWidth' : false
    });

    $('.selectpicker').selectpicker();

    if(uri_ven_id != null && uri_ven_id != "")
    {
        fetchVenue(uri_ven_id);
    }

    $.validate(
    {
        form : '#venue_form',
        modules : 'security',
        onSuccess : function($form) 
        {
            saveVenue();
            return false;
        }
    });
});

function preProcessSave()
{
    $('#venue_form').submit();
}

function addHall()
{
    if($('#hall_type_select').selectpicker('val') != "" && $('#tbl_hall_input').val() != "" && $('#tbl_accomadation_input').val() != "" && $('#tbl_price_input').val() != "")
    {
        $('#hall_table_body').append('<tr><td class = "text-center">'+(hall_count + 1)+'</td><td>'+$('#tbl_hall_input').val()+'</td><td>'+$('#hall_type_select option:selected').text()+'</td><td class = "text-right">'+($('#tbl_accomadation_input').val() + " People")+'</td><td class = "text-right">'+('Rs.'+$('#tbl_price_input').val()+".00")+'</td><td class = "text-center"><strong><a class = "text-danger" style = "cursor:pointer" onclick = "removeHall(this, \''+hall_count+'\');"">Remove</a></strong></td></tr>');

        hall_entries[hall_count] = {'hall_name' : $('#tbl_hall_input').val(), 'hall_type' : $('#hall_type_select').selectpicker('val'), 'accomadation' : $('#tbl_accomadation_input').val(), 'price' : $('#tbl_price_input').val(), 'new' : 1};

        hall_count++;

        clearHallFields();
    }   
    else
    {
        toastr['error']('All Fields Required!');
    }

    resetHallIndex();
}

function clearHallFields()
{
    $('hall_type_select').selectpicker('refresh');
    $('#tbl_hall_input').val('');
    $('#tbl_accomadation_input').val('');
    $('#tbl_price_input').val('');

    return;
}

function resetHallIndex()
{
    $.each($('#hall_table_body tr:not("#input_row")'),function(i,o)
    {
        $(o).find('td').eq(0).html(i+1);
    });

    return;
}

function removeHall(e, index)
{
    if(hall_entries[index]['new'] == 0)
    {
        remove_hall_entries[remove_h_count] = hall_entries[index];

        remove_h_count++;
    }

    $(e).parent().parent().parent().remove();

    delete hall_entries[index];

    resetHallIndex();
}

function isNumber(event)
{
    var charCode = (event.which) ? event.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && !(charCode >= 35 && charCode <= 39))
        return false;

    return true;
}

function fetchVenue(venue_id)
{
    if(venue_id == "")
    {
        resetForm();
        return;
    }

    $.getJSON("<?php echo site_url('master/venue/fetch_venue') ?>", {'id' : venue_id},
    function (data)
    {
        if(!jQuery.isEmptyObject(data))
        {
            resetForm();

            if(!jQuery.isEmptyObject(data['venue']))
            {
                $('#venue_code_input').val(data['venue']['code']);
                $('#ven_name_input').val(data['venue']['name']);
                $('#con_no1_input').val(data['venue']['con_one']);
                $('#con_no2_input').val(data['venue']['con_two']);
                $('#ven_add_input').val(data['venue']['address']);
                $('#ven_email_input').val(data['venue']['email']);

                var status_switch = document.querySelector('#status_switch');

                if(data['venue']['status'] == "1")
                {
                    status_switch.checked = true;
                    onChange(status_switch);
                }  
                else if(data['venue']['status'] == "0")
                {
                    status_switch.checked = false;
                    onChange(status_switch);
                }

                update_id = data['venue']['id'];
            }

            if(!jQuery.isEmptyObject(data['halls']))
            {
                $.each(data['halls'], function(i,o)
                {
                    $('#hall_table_body').append('<tr><td>'+(hall_count + 1)+'</td><td>'+o['hall_name']+'</td><td>'+(o['type'].charAt(0).toUpperCase() + o['type'].slice(1))+'</td><td class = "text-right">'+(o['accomadation'] + " People")+'</td><td class = "text-right">'+("Rs."+o['price'])+'</td><td class = "text-center"><strong><a class = "text-danger" style = "cursor:pointer" onclick = "removeHall(this, \''+hall_count+'\');"">Remove</a></strong></td></tr>');

                    hall_entries[hall_count] = {'hall_id' : o['hall_id'], 'hall_name' : o['hall_name'], 'hall_type' : o['type'], 'accomadation' : o['accomadation'], 'price' : o['price'], 'new' : 0};

                    hall_count++;
                });

                resetHallIndex();
            }
        }
    });

    return;
}

function saveVenue()
{
    var data = $('#venue_form').serializeArray();

    data.push({'name' : 'hall_entries', 'value' : JSON.stringify(hall_entries)});
    data.push({'name' : 'remove_hall_entries', 'value' : JSON.stringify(remove_hall_entries)});
    data.push({'name' : 'update_id', 'value' : update_id});

    $.ajax(
    {
       url: '<?php echo site_url("master/venue/save_venue")?>',
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
        url: '<?php echo site_url("master/venue/reload_sequence") ?>',
        type: 'post',
        dataType: 'json',
        async: false,
        error: function(){alert("An Error Occurred, Please Try Again.")},
        success: function(data)
        {
            $('#venue_code_input').val(data['code']);
        }
    });
}

function resetForm()
{
    $('#venue_form')[0].reset();

    update_id             = false;
    hall_entries        = new Object();
    hall_count          = 0;
    remove_hall_entries = new Object();
    remove_h_count        = 0;

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

    $('#hall_table_body tr:not("#input_row")').remove();

    reloadSequence();
}

var changeCheckbox = document.querySelector('.js-switch')
var state          = changeCheckbox.checked;

changeCheckbox.onchange = function(e) 
{
    if(state == true && update_id != false)
    {
        $.getJSON("<?php echo site_url('master/venue/check_events') ?>", {'update_id' : update_id},
        function (data)
        {
            if(!jQuery.isEmptyObject(data))
            {   
                if(data['events'] > 0)
                {
                    $('#validation_placeholder').html('<div class = "alert alert-danger"><strong class = "text-danger">Upcoming events available for venue. Cannot Deactive.</strong></div>');
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