<div class = "row">
    <div class = "col-md-6">
        <h1>Activity Checklist Lookup</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Transactions</a>
            </li>
            <li>
                <a>Events</a>
            </li>
             <li class = "active">
                <a><strong>Activity Checklist Lookup</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-6 -->
</div>
<!-- /.row -->

<div class = "wrapper animated fadeInRight">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <!-- <div class = "col-md-5"> -->
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#acl_collapse">Event Lookup <small class = "text-white"> Showing all existing events</small></a>
                        <div class="search-form-group has-feedback">
                            <input type="text" class="form-control" name="search_ent_input" id="search_ent_input" placeholder="Search" autocomplete="off">
                            <span class="glyphicon glyphicon-search search-icon"></span>
                        </div>
                    </h4>
                <!-- </div> -->
                <!-- <div class = "col-md-7"> -->
            
                <!-- </div> -->
            </div>
            <div id="acl_collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class = "form-inline" id = "sup_form">

                        <div class="form-group">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" placeholder="From Date" name="from_date_input" id = "from_date_input" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" placeholder="To Date" name="to_date_input" id = "to_date_input" class="form-control">
                            </div>
                        </div>

                        <div class = "form-group">
                            <?php echo form_dropdown('type_filter', $evt_types, '', 'id = "type_filter" class = "form-control selectpicker" data-container = "body" data-live-search = "true" data-size = "4"'); ?>
                        </div>

                        <div class = "form-group">
                            <?php echo form_dropdown('cus_filter', $customer, '', 'id = "cus_filter" class = "form-control selectpicker" data-container = "body" data-live-search = "true" data-size = "4"'); ?>
                        </div>

                        <div class = "form-group">
                            <?php echo form_dropdown('ven_filter', $venue, '', 'id = "ven_filter" class = "form-control selectpicker" data-container = "body" data-live-search = "true" data-size = "4"'); ?>
                        </div>

                        <div class = "form-group">
                           <button type="button" class="btn btn-info" id = "filter_table" onclick="filterTable();">Filter</button>
                        </div>

                        <div class = "hr-line-dashed"></div>

                        <div class = "table-responsive">
                            <table id = "ent_lookup_table" class = "table table-bordered table-hover table-striped compact">
                                <thead>
                                    <tr>
                                        <th class = "text-center">#</th>
                                        <th class = "text-center">Code</th>
                                        <th class = "text-center">Type</th>
                                        <th class = "text-center">Customer</th>
                                        <th class = "text-center">Date</th>
                                        <th class = "text-center">Venue</th>
                                        <th class = "text-center">Activity Count</th>
                                        <th class = "text-center">Status</th>
                                        <th class = "text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.wrapper -->

<script type="text/javascript">

var ent_lookup_table = null;

$(document).ready(function()
{
    $('.selectpicker').selectpicker();

    $('.date').datetimepicker(
    {
        format: 'YYYY-MM-DD',
        widgetPositioning: { horizontal: 'auto', vertical: 'bottom'},
    });

    ent_lookup_table = $('#ent_lookup_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"p><"clear">',
        'bSort': true,
        'iDisplayLength' : 50,
        'responsive' : false,
         'autoWidth' : false,
        'sAjaxSource': '<?php echo site_url("transaction/checklist/fetch_events")?>',
        'fnServerData': function(sSource, aoData, fnCallback, oSettings){
        $.ajax({
            "dataType": 'json',
            "type": "POST",
            "url": sSource,
            "data": aoData,
            "success": fnCallback
        })},
        'fnServerParams' : function(aoData)
        {
            aoData.push({'name' : 'from', 'value' : $('#from_date_input').val()});
            aoData.push({'name' : 'to', 'value' : $('#to_date_input').val()});
            aoData.push({'name' : 'customer', 'value' : $('#cus_filter').selectpicker('val')});
            aoData.push({'name' : 'type', 'value' : $('#type_filter').selectpicker('val')});
            aoData.push({'name' : 'venue', 'value' : $('#ven_filter').selectpicker('val')});
        },
        'aoColumns': [
            { "mData": 'index', "sClass": "text-center"},
            { "mData": "code"},
            { "mData": "type"},
            { "mData": "customer"},
            { "mData": "date"},
            { "mData": "venue"},
            { "mData": "act_count", 'sClass' : "text-right"},
            { "mData": "status", "sClass": "text-center"},
            { "mData": "action", "sClass": "text-center"}
        ],
        "createdRow" : function(row, data, rowIndex, colIndex)
        { 
            if(data.status == "On Progress")
                jQuery('td:eq(7)', row).css('background-color', '#ADF7F8');
            if(data.status == "Completed")
                jQuery('td:eq(7)', row).css('background-color', '#C7FFBC');
        }
    });

    $('#search_ent_input').keyup(function(){ent_lookup_table.fnFilter($(this).val());});
});

function filterTable()
{
    ent_lookup_table.api().ajax.reload();
}

function addChecklist(ent_id)
{
    loadModule('transaction/checklist/checklist_view/' + ent_id);
}

function viewChecklist(ent_id)
{
    loadModule('transaction/checklist/event_checklist_lookup_view/' + ent_id + '/v');
}

</script>