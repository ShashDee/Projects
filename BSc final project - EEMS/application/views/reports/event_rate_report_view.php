<div class = "wrapper animated fadeInRight">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    Event Rate Report <small> Summary report of an selected event</small>
                    <a style = "cursor:pointer">
                        <i class="fa fa-cog pull-right" data-toggle="modal" data-target="#report_config_modal"></i>
                    </a>
                </h4>
            </div>
            
            <div class="panel-body">
                <div class = "row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <h3 class = "text-center">Event Rate Report</h3>
                    </div>
                    <div class="col-md-4">
                        <dl class = "dl-horizontal">
                          <dt>User</dt>
                          <dd id = "user_holder" class="header_holders"><?php echo $this->session->userdata('username'); ?></dd>
                          <dt>Date</dt>
                          <dd id = "datetime_holder" class="header_holders"><?php echo date('Y-m-d'); ?></dd>  
                          <dt>From Date</dt>
                          <dd id = "from_holder" class="header_holders">....</dd>
                          <dt>To Date</dt>
                          <dd id = "to_holder" class="header_holders">....</dd>  
                        </dl>
                    </div>
                </div>

                <div class = "hr-line-dashed"></div>

                <div class = "row">
                    <div class = "col-md-12" id = "info_holder" style = "display:none"></div><br><br><br>

                    <div class = "col-md-12">

                        <div id = "event_count_tbl_div">

                            <table id = "event_count_table" class = "table table-bordered table-hover table-striped compact">
                                <thead>
                                    <tr>
                                        <th class = "text-center">#</th>
                                        <th class = "text-center">Event Type</th>
                                        <th class = "text-center">Event Count</th>
                                    </tr>
                                </thead>
                                <tbody id = "event_count_table_body">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class = "col-md-12">
                        <div class = "hr-line-dashed"></div>

                        <div id = "event_count_chart">
                            <h4 class = "text-center">Event Rate Graph</h4><br>

                            <svg></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start of Modal-->
<div class="modal fade" id="report_config_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Factory Report Configuration</h4>
                <small>Showing Options to configure current report.</small>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="modal_form">
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "form-group">
                                <label class="control-label col-md-2" for = "from_date_input">From</label>
                                <div class="col-md-8">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" placeholder="Event Date" name="from_date_input" id = "from_date_input" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class = "form-group">
                                <label class="control-label col-md-2" for = "to_date_input">To</label>
                                <div class="col-md-8">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" placeholder="Event Date" name="to_date_input" id = "to_date_input" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end of row -->
                </form>     
            </div><!-- end of modal body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick = "fetchData();">Filter</button>
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
        </div>
    </div>
</div> <!-- End of modal -->

<!-- Start of Modal-->
<div class="modal fade" id="event_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Event - <span id = "event_code_span"></span></h4>
                <small>Showing details of selected event.</small>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="event_form">
                    <div class = "row">
                        <div class = "col-md-6">
                            <dl class = "dl-horizontal">
                              <dt>Customer</dt>
                              <dd id = "cus_holder" class="holders">...</dd> 
                              <dt>Event Type</dt>
                              <dd id = "evt_holder" class="holders">...</dd>
                              <dt>Event Date</dt>
                              <dd id = "date_holder" class="holders">...</dd>  
                              <dt>Start Time</dt>
                              <dd id = "st_holder" class="holders">...</dd>
                              <dt>End Time</dt>
                               <dd id = "et_holder" class="holders">...</dd>
                            </dl>
                        </div>
                        <div class = "col-md-6">
                            <dl class = "dl-horizontal">
                               <dt>Venue</dt>
                               <dd id = "venue_holder" class="holders">...</dd>
                               <dt>Hall</dt>
                               <dd id = "hall_holder" class="holders">...</dd>
                               <dt>Inital Budget</dt>
                               <dd id = "ini_holder" class="holders">...</dd>
                               <dt>Actual Budget</dt>
                               <dd id = "budget_holder" class="holders">...</dd>
                               <dt>Event Status</dt>
                              <dd id = "status_holder" class="holders">...</dd>
                            </dl>
                        </div>
                        <div class = "col-md-12">
                            <dl class = "dl-horizontal">
                                <dt>Requirement</dt>
                                <dd class="holders" id = "req_holder">....</dd>
                                <dt>Remarks</dt>
                                <dd class="holders" id = "rem_holder">....</dd>
                            </dl>
                        </div>
                    </div> <!-- end of row -->
                    <div class = "row">
                        <div class = "col-md-12">
                            <table id = "atc_table" class = "table table-bordered table-hover table-striped compact">
                                <thead>
                                    <tr>
                                        <th class = "text-center">Activity</th>
                                        <th class = "text-center">Description</th>
                                        <th class = "text-center">Deadline</th>
                                        <th class = "text-center">Supplier</th>
                                        <th class = "text-center">Supplier Role</th>
                                        <th class = "text-center">Budget</th>
                                        <th class = "text-center">Progress</th>
                                    </tr>
                                </thead>
                                <tbody id = "atc_table_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>     
            </div><!-- end of modal body -->
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
        </div>
    </div>
</div> <!-- End of modal -->

<link href="<?php echo base_url('vendor/novus/nv.d3.css'); ?>" rel = "stylesheet">  
<script src="<?php echo base_url('vendor/novus/d3.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('vendor/novus/nv.d3.js');?>" type="text/javascript"></script>
    

<script type="text/javascript">

var event_count_table = null;
var this_id_count     = 0;
var detailRows        = [];
var sub_data          = '';
var item_count        = 0;
var atc_table         = null;

$(document).ready(function()
{
    $('.date').datetimepicker(
    {
        format: 'YYYY-MM-DD',
        widgetPositioning: { horizontal: 'auto', vertical: 'bottom'},
    });

    if($('#from_date_input').val() == "" && $('#to_date_input').val() == "")
    {
        $('#info_holder').show();
        $('#info_holder').html("<p class = 'text-center text-danger'>Please Select A Date By Clicking the Configuration Icon Above to Generate Report.</p>");
    }

    atc_table = $('#atc_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"><"clear">',
        'bSort': false,
        'iDisplayLength' : -1,
        'responsive' : false,
        'autoWidth' : false
    });

    event_count_table = $('#event_count_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"><"clear">',
        'bSort': false,
        'iDisplayLength' : -1,
        'responsive' : false,
        'autoWidth' : false,
        'sAjaxSource' : '<?php echo site_url("reports/event_rate_report/fetch_event_count") ?>',
        'fnServerData' : function(sSource, aoData, fnCallback, oSettigns){
        $.ajax({
            "dataType" : 'json',
            "type" : 'POST',
            "url" : sSource,
            "data" : aoData,
            "success" : fnCallback
        })},
        'fnServerParams' : function(aoData)
        {
            aoData.push({'name' : 'from', 'value' : $('#from_date_input').val()});
            aoData.push({'name' : 'to', 'value' : $('#to_date_input').val()});
        },
        'aoColumns' : [
            { 'mData' : 'index', 'sClass' : 'text-center'},
            { 'mData' : 'type','sClass' : 'link', "mRender" : function(data){ return "<a style = 'text-decoration:none; cursor:pointer'>"+data+"</a>"}},
            { 'mData' : 'count', 'sClass' : 'text-right'}
        ],
        "createdRow" : function(row, data, rowIndex, colIndex)
        { 
            $.each($('td:eq(1)', row), function () 
            {
                this_id_count++;

                $(this).attr('id','count'+this_id_count);
            });
        }
    });
    
    //table child rows code
    $("#event_count_table tbody").on('click', 'tr td.link', function() //onclick of link made
    {
        var tr  = $(this).closest('tr'); //get table row
        var row = event_count_table.api().row( tr ); //get row element
        var idx = $.inArray( tr.find('td:eq(1)').attr('id'), detailRows ); 

        if ( row.child.isShown() )  //if child rows are displaying
        {
            row.child.hide(); //hide child rows

            // Remove from the 'open' array
            detailRows.splice( idx, 1 ); 
        }
        else 
        {
            //show child rows with data fetched.
            row.child( $(fetchEvents(row.data())) ).show();  //calling fetchEvents function to fetch data

            // Add to the 'open' array
            if ( idx === -1 ) 
                detailRows.push( tr.find('td:eq(1)').attr('id') );
        }
    });

    // On each draw, loop over the `detailRows` array and show any child rows
    event_count_table.on( 'draw', function () 
    {
        $.each( detailRows, function (i,id) 
        {
            $('#'+id).trigger( 'click' );
        });
    });
});

function fetchData()
{
    if($('#ent_select').selectpicker('val') != "")
    {
        $('#info_holder').hide();
        $('#info_holder').html("");
        $('#from_holder').html(($('#from_date_input').val() != "" ? $('#from_date_input').val() : '....'));
        $('#to_holder').html(($('#to_date_input').val() != "" ? $('#to_date_input').val() : '....'));

        event_count_table.api().ajax.reload();
        loadCountGraph();
    }
    else
    {
        $('#info_holder').show();
        $('#info_holder').html("<p class = 'text-center text-danger'>Please Select A Date By Clicking the Configuration Icon Above to Generate Report.</p>");
        $('#from_holder').html('....');
        $('#to_holder').html('....');
        $('#event_count_table_body').empty();
        d3.selectAll("svg > *").remove();
    }

    $('#report_config_modal').modal('hide');
}

function loadCountGraph()
{
    nv.addGraph(function() {
        var chart = nv.models.discreteBarChart()
            .margin({bottom: 60})
            .x(function(d) { return d.label })
            .y(function(d) { return d.value })
            .staggerLabels(true)
            //.staggerLabels(historicalBarChart[0].values.length > 8)
            .showValues(true)
            .duration(250)
            ;

        chart.xAxis     //Chart x-axis settings
          .axisLabel('Type');

        chart.yAxis     //Chart y-axis settings
          .axisLabel('Count');

        var myData = fetchEventCount();

        if(myData != null)
        {
            d3.select('#event_count_chart svg')
                .datum([myData])
                .call(chart);
            nv.utils.windowResize(chart.update);
            return chart;
        }
        else
        {
            d3.select('#event_count_chart svg')
                .datum([])
                .call(chart);
            nv.utils.windowResize(chart.update);
            return chart;   
        }
    });
}

function fetchEventCount()
{
    result = {};

    $.ajax(
    {
        url : '<?php echo site_url("reports/event_rate_report/fetch_event_count_graph")?>',
        type : 'POST',
        dataType : 'json',
        data : { 'from' : $('#from_date_input').val(), 'to' : $('#to_date_input').val() },
        async : false,
        error : function(){},
        success : function(data)
        {
            if(data != null)
                result = data;
              else
                result = null;
        }
    }); 

    return result;   
}

function fetchEvents(main_data)
{
    item_count = 0;

    $.ajax(
    {
        url : '<?php echo site_url("reports/event_rate_report/fetch_events")?>',
        type : 'post',
        dataType : 'json',
        async : false,
        data : {'data' : main_data, 'from' : $("#from_date_input").val(), 'to' : $('#to_date_input').val()},
        error : function(){alert('An error occured. Please try again later.')},
        success : function(data)
        {
            sub_data = '';

            if(!jQuery.isEmptyObject(data))
            {
                sub_data += "<tr><th class = 'text-center blue-bg'>#</th><th class = 'text-center blue-bg'>Event Code</th><th class = 'text-center blue-bg'>Date</th></tr>";

                $.each(data, function(i,o)
                {
                    sub_data += "<tr class = 'animated fadeIn text-center'><td class = 'white-bg text-primary'><strong>"+(++item_count)+"</strong></td><td class = 'text-left white-bg text-primary'><a style = 'text-decoration:none;cursor:pointer' onclick = 'fetchEvent("+o['id']+");'><strong>"+o['code']+"</strong></a></td><td class = 'text-left white-bg text-primary'><strong>"+o['date']+"</strong></td></tr>";
                });
            }
            else
            {
                sub_data += "<tr class = 'animated fadeIn text-center white-bg'><td colspan = '3'>No Events Available</td></tr>";
            }
        }
    });

    return sub_data;
}

function fetchEvent(id)
{
    $.ajax(
    {
        url : '<?php echo site_url("reports/event_rate_report/fetch_event")?>',
        type : 'post',
        dataType : 'json',
        async : false,
        data : {'id' : id},
        error : function(){alert('An error occured. Please try again later.')},
        success : function(data)
        {
            $('#event_modal').modal('show');
            resetModalForm();

            if(!jQuery.isEmptyObject(data))
            {
                if(!jQuery.isEmptyObject(data['main']))
                {
                    $('#event_code_span').html(data['main']['code']);
                    $('#cus_holder').html(data['main']['customer']);
                    $('#evt_holder').html(data['main']['type']);
                    $('#date_holder').html(data['main']['date']);
                    $('#st_holder').html(data['main']['start']);
                    $('#et_holder').html(data['main']['end']);
                    $('#venue_holder').html(data['main']['venue']);
                    $('#hall_holder').html(data['main']['hall']);
                    $('#ini_holder').html("Rs. "+data['main']['ini_budget']);
                    $('#budget_holder').html("Rs. "+data['main']['budget']);
                    $('#status_holder').html((data['main']['status'] == 0 ? "<span class='label label-warning'>On Progress</span>" : "<span class='label label-success'>Complete</span>"));
                    $('#req_holder').html(data['main']['req']);
                    $('#rem_holder').html(data['main']['remarks']);
                } 

                if(!jQuery.isEmptyObject(data['activities']))  
                {
                    $.each(data['activities'], function(i,o)
                    {
                        $('#atc_table_body').append('<tr><td>'+o['activity']+'</td><td>'+o['desc']+'</td><td>'+o['deadline']+'</td><td>'+o['sup_name']+'</td><td>'+o['roles']+'</td><td class = "text-right">'+(o['act_budget'] != "" ? 'Rs. '+o['act_budget']+'.00' : '')+'</td><td class = "text-center '+(o['com_perc'] <= 25 ? 'danger-bg' : (o['com_perc'] <= 50 ? 'warning-bg' : (o['com_perc'] <= 75 ? 'info-bg' : (o['com_perc'] < 100 ? 'primary-bg' : (o['com_perc'] == 100 ? 'success-bg' : '')))))+'">'+o['com_perc']+'%</td></tr>');
                    });
                } 
            }
        }
    });
}

function resetModalForm()
{
    console.log("reset");
    $('.holders').html('....');
    $('#atc_table_body').empty();
}

</script>