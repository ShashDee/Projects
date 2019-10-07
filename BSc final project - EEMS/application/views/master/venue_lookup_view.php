<div class = "row">
    <div class = "col-md-6">
        <h1>Venue Lookup</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Master</a>
            </li>
             <li class = "active">
                <a><strong>Venue Lookup</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-6">
        <div class="title-action">
            <a class="btn btn-primary" onclick="loadModule('master/venue/venue_view');"><i class="fa fa-plus"></i> Add New Venue </a>
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
                        <a data-toggle="collapse" href="#emp_collapse">Venue Lookup <small class = "text-white"> Showing all existing venues</small></a>
                        <div class="search-form-group has-feedback">
                            <input type="text" class="form-control" name="search_ven_input" id="search_ven_input" placeholder="Search" autocomplete="off">
                            <span class="glyphicon glyphicon-search search-icon"></span>
                        </div>
                    </h4>
                <!-- </div> -->
                <!-- <div class = "col-md-7"> -->
            
                <!-- </div> -->
            </div>
            <div id="emp_collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class = "form-inline" id = "ven_form">

                        <div class = "form-group">
                            <select name = "status_filter" id = "status_filter" class = "form-control selectpicker" data-container = "body">
                                <option value = "">Filter Status</option>
                                <option value = "1">Active</option>
                                <option value = "0">Inactive</option>
                            </select>
                        </div>

                        <div class = "form-group">
                           <button type="button" class="btn btn-info" id = "filter_table" onclick="filterTable();">Filter</button>
                        </div>

                        <div class = "hr-line-dashed"></div>
                        
                        <table id = "ven_lookup_table" class = "table table-bordered table-hover table-striped compact">
                            <thead>
                                <tr>
                                    <th class = "text-center">#</th>
                                    <th class = "text-center">Venue Name</th>
                                    <th class = "text-center">Contact No.</th>
                                    <th class = "text-center">Address</th>
                                    <th class = "text-center">Email</th>
                                    <th class = "text-center">User</th>
                                    <th class = "text-center">Status</th>
                                    <th class = "text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.wrapper -->

<script type="text/javascript">

var ven_lookup_table = null;

$(document).ready(function()
{
    $('.selectpicker').selectpicker();

    ven_lookup_table = $('#ven_lookup_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"p><"clear">',
        'bSort': true,
        'iDisplayLength' : 50,
        'responsive' : true,
        'autoWidth' : false,
        'sAjaxSource': '<?php echo site_url("master/venue/fetch_venues")?>',
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
            aoData.push({'name' : 'status', 'value' : $('#status_filter').selectpicker('val')});
        },
        'aoColumns': [
            { "mData": 'index', "sClass": "text-center"},
            { "mData": "name"},
            { "mData": "contact"},
            { "mData": "address"},
            { "mData": "email", "mRender" : function(data){ return '<a href="mailto:'+data+'" target="_top">'+data+'</a>'; }},
            { "mData": "user"},
            { "mData": "status", "sClass": "text-center"},
            { "mData": "action", "sClass": "text-center"}
        ],
        "createdRow" : function(row, data, rowIndex, colIndex)
        { 
            if(data.status == "Active")
                jQuery('td:eq(6)', row).css('background-color', '#C7FFBC');
            if(data.status == "Inactive")
                jQuery('td:eq(6)', row).css('background-color', '#9EDCF6');
        }
    });

    $('#search_ven_input').keyup(function(){ven_lookup_table.fnFilter($(this).val());});
});

function filterTable()
{
    ven_lookup_table.api().ajax.reload();
}

function editVenue(ven_id)
{
    loadModule('master/venue/venue_view/' + ven_id);
}

function quickToggleVenStatus(ven_id)
{
    if(ven_id == '')
        return false;

    $.ajax(
    {
        url : '<?php echo site_url("master/venue/quick_toggle_ven_status")?>',
        type : 'post',
        dataType : 'json',
        async : false,
        data : {'update_id' : ven_id},
        error : function(){alert('An error occured. Please try again later.')},
        success : function(data)
        {
            refreshNotifications();

            if(data)
                ven_lookup_table.api().ajax.reload();
        }
    });

    return;
}

</script>