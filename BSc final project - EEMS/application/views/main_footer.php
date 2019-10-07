    </div>
    <!-- /#wrapper -->
    <div class="footer">
        <div>
            <small class = "footer-text"><strong>EEMS - Enhanced Event Management System | Final Project &copy; <?php echo date('Y'); ?></strong></small>
        </div>
    </div>
    <!-- End of Footer -->

<!-- Start of confirmation model -->
<div class="modal inmodal" id="general_confirmation_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div id = "general_confirmation_modal_animation" class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h5 class="font-bold" id = "general_confirmation_modal_title">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h5>
            </div>
            <div class="modal-body" id = "general_confirmation_modal_body">
                <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                    printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged.</p>
            </div>
            <div class="modal-footer">
                <button type="button" id = "general_confirmation_modal_body_yes_btn" class="btn btn-primary">Yes</button>
                <button type="button" id = "general_confirmation_modal_body_no_btn" class="btn btn-warning">No</button>
            </div>
        </div>
    </div>
</div>
<!-- End of confirmation model -->

    <!-- moment -->
    <script src="<?php echo base_url('assets/js/moment.js'); ?>"></script>
    
    <!-- jQuery -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url('vendor/metisMenu/metisMenu.min.js'); ?>"></script>

    <!-- DataTables JavaScript -->
    <script src="<?php echo base_url('vendor/datatables/js/jquery.dataTables.js'); ?>"></script>
    <script src="<?php echo base_url('vendor/datatables-plugins/dataTables.bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('vendor/datatables-responsive/dataTables.responsive.js'); ?>"></script>

    <!-- datetimepicker -->
    <script src="<?php echo base_url('vendor/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>

    <!-- selectpicker -->
    <script src="<?php echo base_url('vendor/bootstrap-select-1.11.0/dist/js/bootstrap-select.js'); ?>"></script>

    <!-- Morris Charts JavaScript -->
    <!-- <script src="<?php //echo base_url('vendor/raphael/raphael.min.js'); ?>"></script>
    <script src="<?php //echo base_url('vendor/morrisjs/morris.min.js'); ?>"></script>
    <script src="<?php //echo base_url('data/morris-data.js'); ?>"></script> -->

    <!-- Flot Charts JavaScript -->
    <!-- <script src="<?php //echo base_url('vendor/flot/excanvas.min.js'); ?>"></script>
    <script src="<?php //echo base_url('vendor/flot/jquery.flot.js'); ?>"></script>
    <script src="<?php //echo base_url('vendor/flot/jquery.flot.pie.js'); ?>"></script>
    <script src="<?php //echo base_url('vendor/flot/jquery.flot.resize.js'); ?>"></script>
    <script src="<?php //echo base_url('vendor/flot/jquery.flot.time.js'); ?>"></script>
    <script src="<?php //echo base_url('vendor/flot-tooltip/jquery.flot.tooltip.min.js'); ?>"></script>
    <script src="<?php //echo base_url('data/flot-data.js'); ?>"></script> -->

    <!-- iCheck -->
    <script src="<?php echo base_url('vendor/iCheck/icheck.min.js') ?>"></script>

    <!-- switchery -->
    <script src="<?php echo base_url('vendor/switchery/switchery.js') ?>"></script>

    <!-- Toastr Notifications -->
    <script src="<?php echo base_url('vendor/toastr-master/build/toastr.min.js') ?>"></script>

    <!-- Slimscroll -->
    <!-- <script src="<?php //echo base_url('vendor/slimscroll/jquery.slimscroll.js') ?>"></script> -->

    <!-- fromt-end Validation -->
    <script src="<?php echo base_url('vendor/jQuery-Form-Validator-master/form-validator/jquery.form-validator.min.js') ?>"></script>

    <!-- Full Calendar -->
    <script src="<?php echo base_url('vendor/fullcalendar-3.0.0/fullcalendar.js') ?>"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('dist/js/sb-admin-2.js'); ?>"></script>

</body>

</html>

<script type="text/javascript">

function loadModule(module_url, e)
{
    if(e !== false)
        $('#page-wrapper').attr('style','');

    $.ajax(
    {
        type : 'GET',
        url : '<?php echo site_url()?>' + module_url,
        dataType : 'html',
        async : false,
        success : function(module_data) 
        {
            $('#page-wrapper').empty().append(module_data); 
            $('html,body').animate({scrollTop: 0}, 'slow');
        },
        error : function(){alert('Requested Page Does Not Exist. Please Try Again.')}
    });
}

function refreshNotifications(alt)
{
    $.getJSON('<?php echo site_url() . "dashboard/fetch_notifications"?>',
    function(data)
    {
        if(!jQuery.isEmptyObject(data))
        {
            toastr.options = {
              "closeButton"      : true,
              "debug"            : false,
              "newestOnTop"      : true,
              "progressBar"      : true,
              "positionClass"    : "toast-top-right",
              "preventDuplicates": true,
              "onclick"          : null,
              "showDuration"     : "300",
              "hideDuration"     : "1000",
              "timeOut"          : "5000",
              "extendedTimeOut"  : "1000",
              "showEasing"       : "swing",
              "hideEasing"       : "linear",
              "showMethod"       : "fadeIn",
              "hideMethod"       : "fadeOut"
            }

            $.each(data,function(i,v)
            {
               toastr[v.t](v.m);
            });

            if(alt == undefined)
                $('html,body').animate({scrollTop: 0}, 'slow');
        }
    });
}

loadModule('widgets/widget/load_widgets',false);

var date = (new Date().toString());
$('#clockbox').html(date.split('GMT')[0]);
</script>