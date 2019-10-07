<div class = "row">
    <div class = "col-md-6">
        <h1>Supplier Lookup</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Master</a>
            </li>
             <li class = "active">
                <a><strong>Supplier Lookup</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-6 -->
    <div class = "col-md-6">
        <div class="title-action">
            <a class="btn btn-primary" onclick="loadModule('master/supplier/supplier_view');"><i class="fa fa-plus"></i> Add New Supplier </a>
        </div>
    </div>
    <!-- /.col-lg-6 -->
</div>
<!-- /.row -->

<div class = "wrapper animated fadeInRight">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#emp_collapse">Supplier Lookup <small class = "text-white"> Showing all existing suppliers</small></a>
                    <div class="search-form-group has-feedback">
                        <input type="text" class="form-control" name="search_sup_input" id="search_sup_input" placeholder="Search" autocomplete="off">
                        <span class="glyphicon glyphicon-search search-icon"></span><!-- table search  -->
                    </div>
                </h4>
            </div>
            <div id="emp_collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class = "form-inline" id = "sup_form">
                        <!-- Filters -->
                        <div class = "form-group">
                            <input class = "form-control" type = "text" id = "min_from_input" name = "min_from_input" placeholder = "Minimum Rate From" onkeypress='return isNumber(event);'>
                        </div>

                        <div class = "form-group">
                            <input class = "form-control" type = "text" id = "min_to_input" name = "min_to_input" placeholder = "Minimum Rate To" onkeypress='return isNumber(event);'>
                        </div>

                        <div class = "form-group">
                            <?php echo form_dropdown('type_filter', $types, '', 'id = "type_filter" class = "form-control selectpicker" data-container = "body" data-live-search = "true" data-size = "4"'); ?>
                        </div>

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
                        <!-- End of Filters -->
                        <div class = "hr-line-dashed"></div>

                        <div class = "table-responsive">
                            <table id = "sup_lookup_table" class = "table table-bordered table-hover table-striped compact">
                                <thead>
                                    <tr>
                                        <th class = "text-center">#</th>
                                        <th class = "text-center">Name</th>
                                        <th class = "text-center">Type</th>
                                        <th class = "text-center">Minimum Rate</th>
                                        <th class = "text-center">Email</th>
                                        <th class = "text-center">Skype</th>
                                        <th class = "text-center">User</th>
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

var sup_lookup_table = null; //datatable variable initialization

$(document).ready(function()
{
    $('.selectpicker').selectpicker(); //selectpicker initialization

    //datatable initialization
    sup_lookup_table = $('#sup_lookup_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"p><"clear">',
        'bSort': true,
        'iDisplayLength' : 50,
        'responsive' : false,
        'autoWidth' : false,
        'sAjaxSource': '<?php echo site_url("master/supplier/fetch_suppliers")?>', //controller function for fetching table data
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
            //parameters to be passed. Filters
            aoData.push({'name' : 'min_from', 'value' : $('#min_from_input').val()});
            aoData.push({'name' : 'min_to', 'value' : $('#min_to_input').val()});
            aoData.push({'name' : 'type', 'value' : $('#type_filter').selectpicker('val')});
            aoData.push({'name' : 'status', 'value' : $('#status_filter').selectpicker('val')});
        },
        'aoColumns': [ //assigning data to fields
            { "mData": 'index', "sClass": "text-center"},
            { "mData": "name"},
            { "mData": "sup_type_string"},
            { "mData": "min_rate", "sClass" : "text-right", "mRender" : function(data){ return "Rs."+data; }},
            { "mData": "email", "mRender" : function(data){ return '<a href="mailto:'+data+'" target="_top">'+data+'</a>'; }},
            { "mData": "skype", "mRender" : function(data){ return '<span>Call : <a href="skype:'+data+'?call">'+data+'</a></span><span>  Chat : <a href="skype:'+data+'?chat">'+data+'</a></span>'; }},
            { "mData": "user"},
            { "mData": "status", "sClass": "text-center"},
            { "mData": "action", "sClass": "text-center"}
        ],
        "createdRow" : function(row, data, rowIndex, colIndex)
        { 
            //color assigning of status field based on current status
            if(data.status == "Active")
                jQuery('td:eq(7)', row).css('background-color', '#C7FFBC');
            if(data.status == "Inactive")
                jQuery('td:eq(7)', row).css('background-color', '#9EDCF6');
        }
    });

    $('#search_sup_input').keyup(function(){sup_lookup_table.fnFilter($(this).val());}); //searching of table
});

function filterTable() //filtering table data. Table data reload
{
    sup_lookup_table.api().ajax.reload();
}

function editSupplier(sup_id) //edit option
{
    loadModule('master/supplier/supplier_view/' + sup_id); //redirecting to add supplier page with supplier id
}

function quickToggleSupStatus(sup_id) //quick activate and deactivate of supplier
{
    if(sup_id == '')
        return false;

    $.ajax(
    {
        url : '<?php echo site_url("master/supplier/quick_toggle_sup_status")?>',
        type : 'post',
        dataType : 'json',
        async : false,
        data : {'update_id' : sup_id},
        error : function(){alert('An error occured. Please try again later.')},
        success : function(data)
        {
            refreshNotifications();

            if(data)
                sup_lookup_table.api().ajax.reload(); //reload table
        }
    });

    return;
}

function isNumber(event) //allow only numbers to be typed
{
    var charCode = (event.which) ? event.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && !(charCode >= 35 && charCode <= 39))
        return false;

    return true;
}

</script>