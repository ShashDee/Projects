<div class="panel panel-default">
    <div class="panel-heading text-center">
        <h5><i class="fa fa-gift fa-fw"></i> <strong>Upcoming Event List</strong></h5>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <div class="list-group" id = "list_div">
            
        </div>
        <!-- /.list-group -->
    </div>
    <!-- /.panel-body -->
</div>
<!-- /.panel -->

<script type="text/javascript">

$(document).ready(function()
{
    fetchUpcomingEvents();
});

function fetchUpcomingEvents()
{
    $.ajax(
    {
        url : '<?php echo site_url("widgets/widget/fetch_event_list")?>',
        type : 'post',
        dataType : 'json',
        async : false,
        error : function(){alert('An Error Occured. Please Try Again Later!')},
        success : function(data)
        {
            if(!$.isEmptyObject(data))
            {
                var append_string = "";

                $.each(data, function(i,o)
                {
                    append_string += ('<a style = "cursor:pointer" onclick = "loadModule(\'transaction/event/event_view/'+o['id']+'/e\');" class="list-group-item"><i class="fa fa-gift fa-fw"></i> Event Code: '+o['code']+'<span class="pull-right text-muted small"><em> On '+o['date']+'</em></span></a>');
                });

                $('#list_div').append(append_string);
            }
            else
            {
                $('#list_div').append("<h5 class = 'text-center text-primary'>No Upcoming Events</h5>");
            }
        }
    });
}

</script>