<div class="col-lg-3 col-md-6">
    <div class="panel panel-green"> <!-- green panel -->
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-gift fa-5x"></i> <!-- gift icon -->
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge" id = "event_count"></div> <!-- Will hold the number of events -->
                    <div id = "count_description"></div> <!-- Description will be shown here -->
                </div>
            </div>
        </div>
        <a onclick = "loadModule('transaction/event/event_lookup_view')"><!-- view details link section  -->
            <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>

<script type="text/javascript">


$(document).ready(function() //on load of page
{
    fetchEventCount(); //calling function
});

function fetchEventCount() //fetch event count
{
    $.ajax( //ajax call
    {
        url : '<?php echo site_url("widgets/widget/fetch_event_count")?>', //url for controller function
        type : 'post', //type POST or GET
        dataType : 'json',
        async : false,
        error : function(){alert('An Error Occured. Please Try Again Later!')},
        success : function(data) //success event
        {
            if(!$.isEmptyObject(data)) //if result is not empty
            {
                $('#event_count').html(data['event_count']); //setting event count in <div> with ID "event_count"

                if(data['event_count'] > 0) 
                {    
                    $('#count_description').html('Events Upcoming!'); //setting description in <div> with ID "count_description"
                }
                else
                {
                    $('#count_description').html('No Events');
                }
            }
            else
            {
                $('#count_description').html('No Events');
            }
        }
    });
}


</script>