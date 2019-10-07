<div class = "row">
    <div class = "col-md-8">
        <h1>Event Checklist Lookup</h1>
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
            <li>
                <a onclick = "loadModule('transaction/checklist/checklist_lookup_view');">Activity Checklist Lookup</a>
            </li>
             <li class = "active">
                <a><strong>Event Checklist Lookup</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-4">
        <div class="title-action">
            <a class="btn btn-primary" onclick="loadView()" id = "add_new_btn"><i class="fa fa-plus"></i> Add New Checklist Item </a>
            <a class="btn btn-info" onclick="loadModule('transaction/checklist/checklist_lookup_view');" id = "view_btn"><i class="fa fa-eye"></i> View Existing Events </a>
        </div>
    </div>
    <!-- /.col-lg-8 -->
</div>
<!-- /.row -->

<div class = "wrapper animated fadeInRight">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <!-- <div class = "col-md-5"> -->
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#ent_collapse">Event Checklist Lookup <small class = "text-white"> Showing all checklists of selected event</small></a>
                        <div class="search-form-group has-feedback">
                            <input type="text" class="form-control" name="search_ckl_input" id="search_ckl_input" placeholder="Search" autocomplete="off">
                            <span class="glyphicon glyphicon-search search-icon"></span>
                        </div>
                    </h4>
                <!-- </div> -->
                <!-- <div class = "col-md-7"> -->
            
                <!-- </div> -->
            </div>
            <div id="ent_collapse" class="panel-collapse collapse in">
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
                            <?php echo form_dropdown('emp_filter', $emp, '', 'id = "emp_filter" class = "form-control selectpicker" data-container = "body" data-live-search = "true" data-size = "4"'); ?>
                        </div>

                        <div class = "form-group">
                           <button type="button" class="btn btn-info" id = "filter_table" onclick="filterTable();">Filter</button>
                        </div>

                        <div class = "hr-line-dashed"></div>

                        <div class = "table-responsive">
                            <table id = "checklist_table" class = "table table-bordered table-hover table-striped compact">
                                <thead>
                                    <tr>
                                        <th class = "text-center">#</th>
                                        <th class = "text-center">Checklist Item</th>
                                        <th class = "text-center">Deadline</th>
                                        <th class = "text-center">Completed On</th>
                                        <th class = "text-center">Incharge</th>
                                        <th class = "text-center">Status</th>
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

var checklist_table = null;
var uri_ent_id      = "<?php echo $this->uri->segment(4); ?>";
var uri_ent_mode    = "<?php echo $this->uri->segment(5); ?>";

$(document).ready(function()
{
    $('.selectpicker').selectpicker();

    $('.date').datetimepicker(
    {
        format: 'YYYY-MM-DD',
        widgetPositioning: { horizontal: 'auto', vertical: 'bottom'},
    });

    if(uri_ent_mode == "a")
    {
        $('#add_new_btn').show();
        $('#view_btn').hide();
    }
    else if(uri_ent_mode == "v")
    {
        $('#add_new_btn').hide();
        $('#view_btn').show();
    }

    checklist_table = $('#checklist_table').dataTable( //datatable initialization
    {
        'dom': '<"top">rt<"bottom"p><"clear">', //setting up DOM elements. only the table and pagination is included here
        'bSort': false, //soritng turned off
        'iDisplayLength' : 50, //maximum display no. for one page
        'responsive' : false,
         'autoWidth' : false,
        'sAjaxSource': '<?php echo site_url("transaction/checklist/fetch_lp_checklists")?>', //url for fetching data for the table
        'fnServerData': function(sSource, aoData, fnCallback, oSettings){
        $.ajax({
            "dataType": 'json',
            "type": "POST",
            "url": sSource,
            "data": aoData,
            "success": fnCallback
        })},
        'fnServerParams' : function(aoData) //parameters that need to be passed
        {
            aoData.push({'name' : 'id', 'value' : uri_ent_id});
            aoData.push({'name' : 'from', 'value' : $('#from_date_input').val()});
            aoData.push({'name' : 'to', 'value' : $('#to_date_input').val()});
            aoData.push({'name' : 'employee', 'value' : $('#emp_filter').selectpicker('val')});
        },
        'aoColumns': [ //assigned fetched data to columns
            { "mData": 'index', "sClass": "text-center"},
            { "mData": "item"},
            { "mData": "ckl_deadline"},
            { "mData": "completed"},
            { "mData": "assigned_name"},
            { "mData": "status", "sClass": "text-center"},
        ],
        "createdRow" : function(row, data, rowIndex, colIndex) //after rows created
        { 
            if(data.status == "On Progress")
                jQuery('td:eq(5)', row).css('background-color', '#ADF7F8');
            if(data.status == "Completed")
                jQuery('td:eq(5)', row).css('background-color', '#C7FFBC');
        },
        "drawCallback": function ( settings ) //after drawing table
        {
            //grouping is done activity wise
            var api   = this.api(); //getting current instance of datatable
            var group = null;
            var rows  = api.rows( {page:'current', order:'current'} ).nodes();


            api.rows({page:"current", order:'current'}).data().each(function(r,i) //looping through all rows
            {
                if(group !== r['activity']) //if new activity
                {
                    $(rows).eq(i).before('<tr class = "group info"><th colspan="6">Activity : '+r['activity']+' | Deadline : '+r['deadline']+'</th></tr>');

                    group =  r['activity'];
                }

            });

        }
    });

    $('#search_ckl_input').keyup(function(){checklist_table.fnFilter($(this).val());});
});

function filterTable()
{
    checklist_table.api().ajax.reload();
}

function loadView()
{
    loadModule('transaction/checklist/checklist_view/' + uri_ent_id);
}

</script>