<div class = "row">
    <div class = "col-md-4">
        <h1>Event Types</h1>
        <ol class = "breadcrumb"> <!-- Start Breadcrumb - Give Proper Location for each link-->
            <li>
                <a href = "#">Home</a> <!-- Link Home -->
            </li>
            <li>
                <a>Configuration</a>
            </li>
             <li class = "active">
                <strong>Event Types</strong>
            </li>
        </ol>
    </div>
    <!-- /.col-lg-4 -->
    <div class = "col-md-8">
        <div class="title-action">
            <a class="btn btn-primary" type="button" id="save_btn" onclick="preprocessSave('P');"><i class="fa fa-save"></i> Save </a>
            <a class="btn btn-info" onclick="loadModule('cmas/issue_note/issue_note_lookup_view');"><i class="fa fa-eye"></i> Lookup </a>
            <a class="btn btn-default" type="reset" id="reset_btn" onclick="resetForm();"><i class="fa fa-refresh"></i> Reset </a>
        </div>
    </div>
    <!-- /.col-lg-8 -->
</div>
<!-- /.row -->

<div class = "wrapper">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#event_type_collapse">Event Types <small class = "text-white"> Showing options for creation of event types</small></a>
                </h4>
            </div>
            <div id="event_type_collapse" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class = "form-horizontal" id = "event_type_form">
                        <div class = "row">
                            <div class = "col-md-6 col-md-offset-2">
                                <div class="form-group"> 
                                    <label class="col-sm-4 control-label" for  = "event_type_input">Event Type</label>                                      
                                    <div class="col-sm-8">
                                        <input type = "text" placeholder = "Event Type" class = "form-control" id = "event_type_input" name = "event_type_input">
                                    </div>
                                </div>

                                <div class="form-group"> 
                                    <label class="col-sm-4 control-label" for  = "event_short_input">Event Shortname</label>                                      
                                    <div class="col-sm-8">
                                        <input type = "text" placeholder = "Event Shortname" class = "form-control" id = "event_short_input" name = "event_short_input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.wrapper -->