<div class="col-lg-3 col-md-6">
    <div class="panel panel-red">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-warning fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge" id = "exp_checklist_count"></div>
                    <div id = "exp_ckl_count_desc"></div>
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
    fetchExpChecklistCount();
});

function fetchExpChecklistCount()
{
    $.ajax(
    {
        url : '<?php echo site_url("widgets/widget/fetch_exp_checklist_count")?>',
        type : 'post',
        dataType : 'json',
        async : false,
        error : function(){alert('An Error Occured. Please Try Again Later!')},
        success : function(data)
        {
            if(!$.isEmptyObject(data))
            {
                $('#exp_checklist_count').html(data['exp_checklist_count']);

                if(data['exp_checklist_count'] > 0)
                {    
                    $('#exp_ckl_count_desc').html('Expired<br>Checklist Item(s)!');
                }
                else
                {
                    $('#exp_ckl_count_desc').html('No Expired<br>Checklist Item(s)');
                }
            }
            else
            {
                $('#exp_ckl_count_desc').html('No Expired<br>Checklist Item(s)');
            }
        }
    });
}


</script>