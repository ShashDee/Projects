<div class = "row">
    <div class = "col-md-6">
        <h1>Employee Lookup</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Master</a>
            </li>
             <li class = "active">
                <a><strong>Employee Lookup</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-6">
        <div class="title-action">
            <a class="btn btn-primary" onclick="loadModule('master/employee/employee_view');"><i class="fa fa-plus"></i> Add New Employee </a>
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
                        <a data-toggle="collapse" href="#emp_collapse">Employee Lookup <small class = "text-white"> Showing all existing employees</small></a>
                        <div class="search-form-group has-feedback">
                            <input type="text" class="form-control" name="search_emp_input" id="search_emp_input" placeholder="Search" autocomplete="off">
                            <span class="glyphicon glyphicon-search search-icon"></span>
                        </div>
                    </h4>
                <!-- </div> -->
                <!-- <div class = "col-md-7"> -->
            
                <!-- </div> -->
            </div>
            <div id="emp_collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class = "form-inline" id = "emp_form">

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
                            <?php echo form_dropdown('desig_filter', $designation, '', 'id = "desig_filter" class = "form-control selectpicker" data-container = "body" data-live-search = "true"'); ?>
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

                        <div class = "hr-line-dashed"></div>
                        
                        <div class = "table-responsive">
                            <table id = "emp_lookup_table" class = "table table-bordered table-hover table-striped compact">
                                <thead>
                                    <tr>
                                        <th class = "text-center">#</th>
                                        <th class = "text-center">Employee No</th>
                                        <th class = "text-center">Full Name</th>
                                        <th class = "text-center">Address</th>
                                        <th class = "text-center">Joined Date</th>
                                        <th class = "text-center">Designation</th>
                                        <th class = "text-center">Mobile Number</th>
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

var emp_lookup_table = null;

$(document).ready(function()
{
    $('.selectpicker').selectpicker();

    $('.date').datetimepicker(
    {
        format: 'YYYY-MM-DD',
        widgetPositioning: { horizontal: 'auto', vertical: 'bottom'}
    });

    emp_lookup_table = $('#emp_lookup_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"p><"clear">',
        'bSort': true,
        'iDisplayLength' : 50,
        'responsive' : false,
        'autoWidth' : false,
        'sAjaxSource': '<?php echo site_url("master/employee/fetch_employees")?>',
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
            aoData.push({'name' : 'designation', 'value' : $('#desig_filter').selectpicker('val')});
            aoData.push({'name' : 'status', 'value' : $('#status_filter').selectpicker('val')});
        },
        'aoColumns': [
            { "mData": 'index', "sClass": "text-center"},
            { "mData": "epf_no"},
            { "mData": "full_name"},
            { "mData": "address"},
            { "mData": "joined_date"},
            { "mData": "desig"},
            { "mData": "mobile"},
            { "mData": "email", "mRender" : function(data){ return '<a href="mailto:'+data+'" target="_top">'+data+'</a>'; }},
            { "mData": "skype", "mRender" : function(data){ return '<span>Call : <a href="skype:'+data+'?call">'+data+'</a></span><span>  Chat : <a href="skype:'+data+'?chat">'+data+'</a></span>'; }},
            { "mData": "user"},
            { "mData": "status", "sClass": "text-center"},
            { "mData": "action", "sClass": "text-center"}
        ],
        "createdRow" : function(row, data, rowIndex, colIndex)
        { 
            if(data.status == "Active")
                jQuery('td:eq(10)', row).css('background-color', '#C7FFBC');
            if(data.status == "Inactive")
                jQuery('td:eq(10)', row).css('background-color', '#9EDCF6');
        }
    });

    $('#search_emp_input').keyup(function(){emp_lookup_table.fnFilter($(this).val());});
});

function filterTable()
{
    emp_lookup_table.api().ajax.reload();
}

function editEmployee(emp_id)
{
    loadModule('master/employee/employee_view/' + emp_id);
}

function quickToggleEmpStatus(emp_id)
{
    if(emp_id == '')
        return false;

    $.ajax(
    {
        url : '<?php echo site_url("master/employee/quick_toggle_emp_status")?>',
        type : 'post',
        dataType : 'json',
        async : false,
        data : {'update_id' : emp_id},
        error : function(){alert('An error occured. Please try again later.')},
        success : function(data)
        {
            refreshNotifications();

            if(data)
                emp_lookup_table.api().ajax.reload();
        }
    });

    return;
}

</script>