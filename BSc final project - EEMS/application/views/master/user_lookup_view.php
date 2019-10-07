<div class = "row">
    <div class = "col-md-6">
        <h1>User Lookup</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Master</a>
            </li>
             <li class = "active">
                <a><strong>User Lookup</strong></a>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-6">
        <div class="title-action">
            <a class="btn btn-primary" onclick="loadModule('master/user/user_view');"><i class="fa fa-plus"></i> Add New User </a>
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
                        <a data-toggle="collapse" href="#user_collapse">User Lookup <small class = "text-white"> Showing all existing users</small></a>
                        <div class="search-form-group has-feedback">
                            <input type="text" class="form-control" name="search_user_input" id="search_user_input" placeholder="Search" autocomplete="off">
                            <span class="glyphicon glyphicon-search search-icon"></span>
                        </div>
                    </h4>
                <!-- </div> -->
                <!-- <div class = "col-md-7"> -->
            
                <!-- </div> -->
            </div>
            <div id="user_collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class = "form-inline" id = "user_form">

                        <div class = "form-group">
                            <select name = "group_filter" id = "group_filter" class = "form-control selectpicker" data-container = "body">
                                <option value = "">Filter User Group</option>
                                <option value = "admin">Admin</option>
                                <option value = "user">User</option>
                            </select>
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
                        
                        <table id = "user_lookup_table" class = "table table-bordered table-hover table-striped compact">
                            <thead>
                                <tr>
                                    <th class = "text-center">#</th>
                                    <th class = "text-center">User NIC</th>
                                    <th class = "text-center">Full Name</th>
                                    <th class = "text-center">User Group</th>
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

var user_lookup_table = null;

$(document).ready(function()
{
    $('.selectpicker').selectpicker();

    user_lookup_table = $('#user_lookup_table').dataTable(
    {
        'dom': '<"top">rt<"bottom"p><"clear">',
        'bSort': true,
        'iDisplayLength' : 50,
        'responsive' : true,
        'autoWidth' : false,
        'sAjaxSource': '<?php echo site_url("master/user/fetch_users")?>',
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
            aoData.push({'name' : 'group', 'value' : $('#group_filter').selectpicker('val')});
            aoData.push({'name' : 'status', 'value' : $('#status_filter').selectpicker('val')});
        },
        'aoColumns': [
            { "mData": 'index', "sClass": "text-center"},
            { "mData": "nic"},
            { "mData": "full_name"},
            { "mData": "group"},
            { "mData": "user"},
            { "mData": "status", "sClass": "text-center"},
            { "mData": "action", "sClass": "text-center"}
        ],
        "createdRow" : function(row, data, rowIndex, colIndex)
        { 
            if(data.status == "Active")
                jQuery('td:eq(5)', row).css('background-color', '#C7FFBC');
            if(data.status == "Inactive")
                jQuery('td:eq(5)', row).css('background-color', '#9EDCF6');
        }
    });

    $('#search_user_input').keyup(function(){user_lookup_table.fnFilter($(this).val());});
});

function filterTable()
{
    user_lookup_table.api().ajax.reload();
}

function editUser(user_id)
{
    loadModule('master/user/user_view/' + user_id);
}

function quickToggleUserStatus(user_id)
{
    if(user_id == '')
        return false;

    $.ajax(
    {
        url : '<?php echo site_url("master/user/quick_toggle_user_status")?>',
        type : 'post',
        dataType : 'json',
        async : false,
        data : {'update_id' : user_id},
        error : function(){alert('An error occured. Please try again later.')},
        success : function(data)
        {
            refreshNotifications();

            if(data)
                user_lookup_table.api().ajax.reload();
        }
    });

    return;
}

</script>