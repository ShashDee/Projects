<div class = "wrapper animated fadeInRight">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    Event Summary Report <small> Summary report of an selected event</small>
                    <a style = "cursor:pointer">
                        <i class="fa fa-cog pull-right" data-toggle="modal" data-target="#report_config_modal"></i>
                    </a>
                </h4>
            </div>
            
            <div class="panel-body">
                <div class = "row"> <!-- Report header -->
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <h3 class = "text-center">Event Summary Report</h3>
                    </div>
                    <div class="col-md-4">
                        <dl class = "dl-horizontal">
                          <dt>User</dt>
                          <dd id = "user_holder" class="header_holders"><?php echo $this->session->userdata('username'); ?></dd>
                          <dt>Date</dt>
                          <dd id = "datetime_holder" class="header_holders"><?php echo date('Y-m-d'); ?></dd>  
                        </dl>
                    </div>
                </div>

                <div class = "hr-line-dashed"></div>

                <div class = "row"> 
                    <div class = "col-md-12" id = "info_holder" style = "display:none"></div><br><br><br>

                    <div class = "col-md-12"><!-- Event basic info -->
                        <div class = "col-md-4">
                            <dl class = "dl-horizontal">
                              <dt>Event Status</dt>
                              <dd id = "status_holder" class="holders">...</dd>
                              <dt>Event Date</dt>
                              <dd id = "date_holder" class="holders">...</dd>  
                              <dt>Start Time</dt>
                              <dd id = "st_holder" class="holders">...</dd>
                            </dl>
                        </div>
                        <div class = "col-md-4">
                            <dl class = "dl-horizontal">
                               <dt>End Time</dt>
                               <dd id = "et_holder" class="holders">...</dd>
                              <dt>Event Type</dt>
                              <dd id = "evt_holder" class="holders">...</dd>
                              <dt>Customer</dt>
                              <dd id = "cus_holder" class="holders">...</dd>  
                            </dl>
                        </div>
                        <div class = "col-md-4">
                            <dl class = "dl-horizontal">
                               <dt>Venue</dt>
                              <dd id = "venue_holder" class="holders">...</dd>
                              <dt>Hall</dt>
                              <dd id = "hall_holder" class="holders">...</dd>
                              <dt>Activity Count</dt>
                              <dd id = "act_holder" class="holders">...</dd>
                            </dl>
                        </div>
                    </div>

                    <div class = "col-md-12" id = "progress_div"> <!-- event progress -->
                        <div class = "hr-line-dashed"></div>

                        <label class = "col-sm-2 control-label" for = "event_progress" style="text-align:left">Event Progress</label>
                        <div class = "col-sm-9">
                            <div class="progress progress-striped active" id = "event_progress_holder">
                                <div id = "event_progress" class="progress-bar progress-bar-danger progress-bar-striped" aria-valuemax="20" aria-valuemin="0" aria-valuenow="0" data-cap = "20" style="width:0%; min-width:2em">
                                    <span>0%</span>
                                </div>
                                <div class="progress-bar progress-bar-warning progress-bar-striped" aria-valuemax="20" aria-valuemin="0" aria-valuenow="0" data-cap = "40" style="width:0%">
                                    <span></span>
                                </div>
                                <div class="progress-bar progress-bar-info progress-bar-striped" aria-valuemax="20" aria-valuemin="0" aria-valuenow="0" data-cap = "60" style="width:0%">
                                    <span></span>
                                </div>
                                <div class="progress-bar progress-bar progress-bar-striped"aria-valuemax="20" aria-valuemin="0" aria-valuenow="0" data-cap = "80" style="width:0%">
                                    <span></span>
                                </div>
                                <div class="progress-bar progress-bar-success progress-bar-striped" aria-valuemax="20" aria-valuemin="0" aria-valuenow="0" data-cap = "100" style="width:0%">
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class = "row"> <!-- progress rate graph -->
                    <div class = "col-md-12">
                        <div class = "hr-line-dashed"></div>

                        <div id = "progress_rate_div">
                            <h4 class = "text-center">Event Progress Rate</h4><br>
                            <svg></svg>
                        </div>
                    </div>
                </div>

                <div class = "row"> <!-- budget varience table -->
                    <div class = "col-md-12">
                        <br><br><div class = "hr-line-dashed"></div>

                        <div id = "budget_variance_div">
                            <h4 class = "text-center">Event Budget Variance</h4><br>

                            <table id = "variance_table" class = "table table-bordered table-hover table-striped compact">
                            <thead>
                                <tr>
                                    <th class = "text-center" rowspan = "2">Event Code</th>
                                    <th class = "text-center" rowspan = "2">Initial Budget</th>
                                    <th class = "text-center" rowspan = "2">Actual Budget</th>
                                    <th class = "text-center" colspan = "2">Vairance</th>
                                </tr>
                                <tr>
                                    <th class = "text-center">( + )</th>
                                    <th class = "text-center">( - )</th>
                                </tr>
                            </thead>
                            <tbody id = "variance_table_body">
                            </tbody>
                        </table>
                        </div>
                    </div>

                    <div class = "col-md-12"> <!-- budget breakdown graph -->
                        <div class = "hr-line-dashed"></div>

                        <div id = "activity_budget_breakdown">
                            <h4 class = "text-center">Event Budget Breakdown</h4><br>

                            <svg></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div> <!-- Row -->
</div> <!-- Wrapper -->


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
                            <label class="col-md-2 control-label" for  = "ent_select">Event</label>
                            <div class = "col-md-8">
                                <select name = "ent_select" id = "ent_select" class = "form-control selectpicker" data-container = "body" data-live-search = "true" data-size = "5">
                                    <?php echo $ent_select; ?>
                                </select>
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

<link href="<?php echo base_url('vendor/novus/nv.d3.css'); ?>" rel = "stylesheet">  
<script src="<?php echo base_url('vendor/novus/d3.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('vendor/novus/nv.d3.js');?>" type="text/javascript"></script>
    

<script type="text/javascript">

var variance_table = null;

$(document).ready(function()
{
    $('.selectpicker').selectpicker();

    if($('#ent_select').selectpicker('val') == "")
    {
        $('#info_holder').show();
        $('#info_holder').html("<p class = 'text-center text-danger'>Please Select An Event By Clicking the Configuration Icon Above to Generate Report.</p>");
    }

    variance_table = $('#variance_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"><"clear">',
        'bSort': false,
        'iDisplayLength' : -1,
        'responsive' : false,
        'autoWidth' : false,
        'sAjaxSource' : '<?php echo site_url("reports/event_summary_report/fetch_buget_info") ?>',
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
            aoData.push({'name' : 'ent_id', 'value' : $('#ent_select').selectpicker('val')});
        },
        'aoColumns' : [
            { 'mData' : 'ent_code'},
            { 'mData' : 'ini_budget', 'sClass' : 'text-right'},
            { 'mData' : 'act_budget', 'sClass' : 'text-right'},
            { 'mData' : 'var_plus', 'sClass' : 'text-right'},
            { 'mData' : 'var_minus', 'sClass' : 'text-right'}
        ]
    });
});

function fetchData()
{
    if($('#ent_select').selectpicker('val') != "")
    {
        $('#info_holder').hide();
        $('#info_holder').html("");

        fetchBasicInfo();
        fetchEventProgress();
        variance_table.api().ajax.reload();
        loadProgressRate();
        loadActivityBudget();
    }
    else
    {
        $('#info_holder').show();
        $('#info_holder').html("<p class = 'text-center text-danger'>Please Select An Event By Clicking the Configuration Icon Above to Generate Report.</p>");
        $('.holders').html("....");
        $('#event_progress_holder').find('div[data-cap="20"]').attr('style','width:0%; min-width:2em');
        $('#event_progress_holder').find('div[data-cap="40"]').attr('style','width: 0%');
        $('#event_progress_holder').find('div[data-cap="60"]').attr('style','width: 0%');
        $('#event_progress_holder').find('div[data-cap="80"]').attr('style','width: 0%');
        $('#event_progress_holder').find('div[data-cap="100"]').attr('style','width: 0%');
        $('#event_progress_holder').find('div[data-cap="20"]').find('span').html('0%');
        $('#variance_table_body').empty();
        d3.selectAll("svg > *").remove();
    }

    $('#report_config_modal').modal('hide');
}

function loadProgressRate()
{
    nv.addGraph(function() {
    var chart = nv.models.lineChart()
      .margin({bottom: 100, left: 100})  //Adjust chart margins to give the x-axis some breathing room.
      .useInteractiveGuideline(true)  //We want nice looking tooltips and a guideline!
      .duration(500) //how fast do you want the lines to transition?
      .showLegend(true)       //Show the legend, allowing users to turn on/off line series.
      .showYAxis(true)        //Show the y-axis
      .showXAxis(true)        //Show the x-axis
      .x(function(d) {
          var temp_date = new Date(d.label);
          return temp_date;
       })
    ;

    chart.xAxis     //Chart x-axis settings
      .axisLabel('Date')
      .tickFormat(function(d,i) {
              return d3.time.format('%y %m %d')(new Date(d));
          })
       .rotateLabels(-60);

    chart.yAxis     //Chart y-axis settings
      .axisLabel('Checklist Count');


    /* Done setting the chart up? Time to render it!*/
    var myData = fetchProgressRate();   //You need data...

    if(myData != null)
    {
      d3.select('#progress_rate_div svg')    //Select the <svg> element you want to render the chart in.   
          .datum([myData])         //Populate the <svg> element with chart data...
          .call(chart);          //Finally, render the chart!

      //Update the chart when window resizes.
      nv.utils.windowResize(function() { chart.update() });
      return chart;
    }
    else
    {
      d3.select('#progress_rate_div svg')    //Select the <svg> element you want to render the chart in.   
          .datum([])         //Populate the <svg> element with chart data...
          .call(chart);          //Finally, render the chart!

      //Update the chart when window resizes.
      nv.utils.windowResize(function() { chart.update() });
      return chart;
    }
  });
}

function fetchProgressRate() //fetch progress rate from database
{
    result = {}; //empty object

    $.ajax(
    {
        url : '<?php echo site_url("reports/event_summary_report/fetch_progress_rate")?>',
        type : 'POST',
        dataType : 'json',
        data : { 'ent_id' : $('#ent_select').selectpicker('val') }, //event ID is passed
        async : false,
        error : function(){},
        success : function(data)
        {
            if(data != null)
                result = data; //assign data to result object
              else
                result = null;
        }
    }); 

    return result; //return object
}

function loadActivityBudget()
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
          .axisLabel('Activity');

        chart.yAxis     //Chart y-axis settings
          .axisLabel('Budget');

        var myData = fetchActivityBudget();

        if(myData != null)
        {
            d3.select('#activity_budget_breakdown svg')
                .datum([myData])
                .call(chart);
            nv.utils.windowResize(chart.update);
            return chart;
        }
        else
        {
            d3.select('#activity_budget_breakdown svg')
                .datum([])
                .call(chart);
            nv.utils.windowResize(chart.update);
            return chart;   
        }
    });
}

function fetchActivityBudget()
{
    result = {};

    $.ajax(
    {
        url : '<?php echo site_url("reports/event_summary_report/fetch_activity_budget")?>',
        type : 'POST',
        dataType : 'json',
        data : { 'ent_id' : $('#ent_select').selectpicker('val') },
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

function fetchEventProgress()
{
    $.ajax(
    {
        url : '<?php echo site_url("reports/event_summary_report/fetch_event_progress")?>',
        type : 'POST',
        dataType : 'json',
        data : { 'ent_id' : $('#ent_select').selectpicker('val') },
        async : false,
        error : function(){},
        success : function(data)
        {
            setProgressBar(data);
        }
    }); 
}

function setProgressBar(data)
{
    $('#event_progress_holder').find('div').attr('style','width:' + 0 + '%');
    if (data['progress_perc'] == 0) {
        $('#event_progress_holder').find('div[data-cap="20"]').attr('style','width:0%; min-width:2em');
        $('#event_progress_holder').find('div[data-cap="20"]').find('span').html('<strong>' + (data['progress_perc']) + '% </strong>');
    }
    else if(data['progress_perc'] < 20) {
        $('#event_progress_holder').find('div[data-cap="20"]').attr('style','width:' + data['progress_perc'] + '%');
        $('#event_progress_holder').find('div[data-cap="20"]').find('span').html('<strong>' + (data['progress_perc']) + '% </strong>');
    }
    else if(data['progress_perc'] < 40) {
        $('#event_progress_holder').find('div[data-cap="20"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="40"]').attr('style','width:' + (data['progress_perc'] - 20) + '%');
        $('#event_progress_holder').find('div[data-cap="20"]').find('span').html('<strong>' + (data['progress_perc']) + '% </strong>');
    }
    else if(data['progress_perc'] < 60) {
        $('#event_progress_holder').find('div[data-cap="20"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="40"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="60"]').attr('style','width:' + (data['progress_perc'] - 40) + '%');
        $('#event_progress_holder').find('div[data-cap="20"]').find('span').html('<strong>' + (data['progress_perc']) + '% </strong>');
    }
    else if(data['progress_perc'] < 80) {
        $('#event_progress_holder').find('div[data-cap="20"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="40"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="60"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="80"]').attr('style','width:' + (data['progress_perc'] - 60) + '%');
        $('#event_progress_holder').find('div[data-cap="20"]').find('span').html('<strong>' + (data['progress_perc']) + '% </strong>');
    }
    else if(data['progress_perc'] <= 100) {
        $('#event_progress_holder').find('div[data-cap="20"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="40"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="60"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="80"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="100"]').attr('style','width:' + (data['progress_perc'] - 80) + '%');
        $('#event_progress_holder').find('div[data-cap="20"]').find('span').html('<strong>' + (data['progress_perc']) + '% </strong>');
    }
    else {
        $('#event_progress_holder').find('div[data-cap="20"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="40"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="60"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="80"]').attr('style','width:' + 20 + '%');
        $('#event_progress_holder').find('div[data-cap="100"]').attr('style','width:' + data['progress_perc'] + '%');
        $('#event_progress_holder').find('div[data-cap="20"]').find('span').html('<strong>' + (data['progress_perc']) + '% </strong>');
    }
}

function fetchBasicInfo()
{
    $.ajax(
    {
        url : '<?php echo site_url("reports/event_summary_report/fetch_basic_info")?>',
        type : 'POST',
        dataType : 'json',
        data : { 'ent_id' : $('#ent_select').selectpicker('val') },
        async : false,
        error : function(){},
        success : function(data)
        {
            setBasicInfo(data);
        }
    }); 
}

function setBasicInfo(data)
{
    if(!$.isEmptyObject(data))
    {
        $('#status_holder').html(data['status']);
        $('#date_holder').html(data['date']);
        $('#st_holder').html(data['st']);
        $('#et_holder').html(data['et']);
        $('#evt_holder').html(data['type']);
        $('#cus_holder').html(data['customer']);
        $('#venue_holder').html(data['venue']);
        $('#hall_holder').html(data['hall']);
        $('#act_holder').html(data['act_count']);
    }

    return;
}

</script>