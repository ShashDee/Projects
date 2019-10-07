<div class = "row">
    <div class="col-md-12">
        <div id="top_column_widget">
        </div>
    </div>
    <div class="col-md-12">
        <div class = "col-md-6">
            <div id="left_column_widget">
            </div>
        </div>
        <div class = "col-md-6">
            <div id="right_column_widget">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function()
{
    call_widgets();
});

function call_widgets()
{
    $.ajax({
        url : '<?php echo site_url("widgets/widget/load_left_column")?>',
        type : 'get',
        dataType : 'html',
        async : false,
        success : function (data) {
            $('#left_column_widget').empty().append(data); 
        }
    });

    $.ajax({
        url : '<?php echo site_url("widgets/widget/load_right_column")?>',
        type : 'get',
        dataType : 'html',
        async : false,
        success : function (data) {
            $('#right_column_widget').empty().append(data); 
        }
    });

    $.ajax({
        url : '<?php echo site_url("widgets/widget/load_top_column")?>',
        type : 'get',
        dataType : 'html',
        async : false,
        success : function (data) {
            $('#top_column_widget').empty().append(data); 
        }
    });
}


</script>