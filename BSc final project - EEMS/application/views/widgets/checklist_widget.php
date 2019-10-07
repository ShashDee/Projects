<div class="panel panel-danger">
    <div class="panel-heading text-center">
        <h5><i class="fa fa-list fa-fw"></i> <strong>Closing Checklist Items</strong></h5>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <div class="list-group" id = "checklist_div">
            <!-- list will loaded here by using JQuery -->
        </div>
        <!-- /.list-group -->
    </div>
    <!-- /.panel-body -->
</div>
<!-- /.panel -->

<script type="text/javascript">

$(document).ready(function()
{
    fetchChecklist();
});

function fetchChecklist()
{
    $.ajax(
    {
        url : '<?php echo site_url("widgets/widget/fetch_checklist")?>',
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
                    append_string += ('<a style = "cursor:pointer" onclick = "loadModule(\'transaction/checklist/checklist_view/'+o['ent_id']+'\');" class="list-group-item"><i class="fa fa-warning fa-fw"></i> '+o['ent_code']+' > '+o['activity']+' > '+o['item']+'<span class="pull-right text-muted small"><em> '+o['assigned_name']+' - '+o['ckl_deadline']+'</em></span></a>');
                });

                $('#checklist_div').append(append_string);
            }
            else
            {
                $('#checklist_div').append("<h5 class = 'text-center'>No Closing Checklist Items</h5>");
            }
        }
    });
}

</script>