<div class="col-lg-3 col-md-6">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-list fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge" id = "checklist_count"></div>
                    <div id = "ckl_count_desc"></div>
                </div>
            </div>
        </div>
        <a onclick = "loadModule('transaction/checklist/checklist_lookup_view')">
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
    fetchChecklistCount();
});

function fetchChecklistCount()
{
    $.ajax(
    {
        url : '<?php echo site_url("widgets/widget/fetch_checklist_count")?>',
        type : 'post',
        dataType : 'json',
        async : false,
        error : function(){alert('An Error Occured. Please Try Again Later!')},
        success : function(data)
        {
            if(!$.isEmptyObject(data))
            {
                $('#checklist_count').html(data['checklist_count']);

                if(data['checklist_count'] > 0)
                {    
                    $('#ckl_count_desc').html('Checklist Item(s)!');
                }
                else
                {
                    $('#ckl_count_desc').html('No Checklist Items');
                }
            }
            else
            {
                $('#ckl_count_desc').html('No Checklist Items');
            }
        }
    });
}


</script>