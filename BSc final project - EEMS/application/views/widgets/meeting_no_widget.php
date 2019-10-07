<div class="col-lg-3 col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-coffee fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge" id = "meeting_count"></div>
                    <div id = "met_count_desc"></div>
                </div>
            </div>
        </div>
        <a onclick = "loadModule('transaction/schedule/schedule_view')">
            <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>

<script type="text/javascript">


$(document).ready(function()
{
    fetchMeetingCount();
});

function fetchMeetingCount()
{
    $.ajax(
    {
        url : '<?php echo site_url("widgets/widget/fetch_meeting_count")?>',
        type : 'post',
        dataType : 'json',
        async : false,
        error : function(){alert('An Error Occured. Please Try Again Later!')},
        success : function(data)
        {
            if(!$.isEmptyObject(data))
            {
                $('#meeting_count').html(data['meeting_count']);

                if(data['meeting_count'] > 0)
                {    
                    $('#met_count_desc').html('Meetings!');
                }
                else
                {
                    $('#met_count_desc').html('No Meetings');
                }
            }
            else
            {
                $('#met_count_desc').html('No Meetings');
            }
        }
    });
}


</script>