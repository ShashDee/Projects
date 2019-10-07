var del_module = null; // used for storing module name in delete mode
var del_id = null; // used to store the id if the record to be deleted
var checklist_event_id = null; // used to store the id of the event selected for adding/editing the checklist
var agenda_event_id = null; // used to store the id of the event selected for adding/editing the agenda
var halls_array = new Array(); // array used to store halls added in interface
var checklist_array = new Array(); // array used to store the checklist items added in interface
var agenda_array = new Array(); // array used to store the agenda items added in interface
var server_url = "192.168.1.11:3009/Events/"; // server URL

document.ontouchmove = function(e){ e.preventDefault(); }

// on page show event for home page
$(document).delegate("#home_page", "pageshow", function(ev)
{
	// fetching all ongoing events to display in home page
    var get_url = "http://" + server_url + "home_events/fetch";

    // calling get function to get logs from database
    http_get(get_url, function(data)
    {
        if(data.list.length > 0)
        {
        	// appedning events to listview
            $('#quick_access_checklists li:not("#title_li")').remove();

            $.each(data.list, function(i,o)
            {
                $('#quick_access_checklists').append('<li><a onclick="loadEditPage(\'event_checklist\', \'' + o._id + '\', \'' + o.event_complete +'\');">' + o.event_code + " - " + o.event_name + '</a></li>').listview("refresh");
            });
        }
        else
        {
            $('#quick_access_checklists li:not("#title_li")').remove();
            $('#quick_access_checklists').append('<li id="no_chklist_li">No Ongoing Events At The Moment.</li>').listview("refresh");

        }
    });
});

// on event type page initialisation
$(document).delegate("#event_type", "pageinit", function(ev) 
{
	ev.preventDefault();

	// adding tap event to save entry button
	$('#add_evt_btn').tap(function()
	{
		// validating data
	    var valid = true;

	    if($("#evt_type_code_input").val() == "")
	    {
	        valid = false;
	        alert("Event Type Code is Required!");
	    }

	    if($("#evt_type_input").val() == "")
        {
            valid = false;
            alert("Event Type is Required!");
        }

        if(!valid)
            return;

		var new_type = 
		{
			type_code: $("#evt_type_code_input").val(),
			type_name: $("#evt_type_input").val()
		};

		// saving event type
		var save_url = "http://" + server_url + "event_type/save";

	    http_post(save_url, new_type, function(data)
	    {
            // alert event type saved successfully.
			alert("Event Type Added.");
	    });

		// reset data entry section
		resetEventTypeForm();
	});
});

// on venues page initialisation
$(document).delegate("#venue", "pageinit", function(ev)
{
	ev.preventDefault();

	// adding tap event for add hall button
	$('#add_hall_btn').tap(function()
	{
	    if($('#hall_input').val() != "")
	    {
	        if($('#no_li').length > 0)
	            $('#no_li').remove();

            var new_hall = {hall_name: $('#hall_input').val()};

            halls_array.push(new_hall); // adding hall to array

            // appending hall to listt
	        $('#halls_list').append("<li>" + $('#hall_input').val() + "</li>").listview('refresh');

	        $('#hall_input').val("");
	    }
	    else
	    {
	        alert('Enter Hall Name!');
	    }
	});

	// adding tap event to save entry button
	$('#add_venue_btn').tap(function()
	{
	    var valid = true;

	     // validating data
	    if($("#venue_name_input").val() == "")
	    {
	        valid = false;
	        alert("Venue Name is Required!");
	    }

	    if($("#venue_contact_input").val() == "")
        {
            valid = false;
            alert("Contact No. is Required!");
        }

        if($("#venue_address_input").val() == "")
        {
            valid = false;
            alert("Address is Required!");
        }

        if($("#venue_email_input").val() == "")
        {
            valid = false;
            alert("Email is Required!");
        }

        if(halls_array.length == 0)
        {
            valid = false;
            alert("At least One Hall is Required!");
        }

        if(!valid)
            return;

		var new_venue =
		{
			venue_name: $("#venue_name_input").val(),
			contact_no: $("#venue_contact_input").val(),
			address: $("#venue_address_input").val(),
			email: $("#venue_email_input").val(),
			halls: halls_array
		};

		// saving venue
		var save_url = "http://" + server_url + "venue/save";

	    http_post(save_url, new_venue, function(data)
	    {
            // alert venue saved successfully.
			alert("Venue Added.");
	    });

		// reset data entry section
		resetVenueForm();
	});
});

// on supplier page initialisation
$(document).delegate("#supplier", "pageinit", function(ev)
{
	ev.preventDefault();

	// adding tap even to save entry button
	$('#add_supplier_btn').tap(function()
	{
	    var valid = true;

	    // validating data
	    if($("#supplier_name_input").val() == "")
        {
            valid = false;
            alert("Supplier Name is Required!");
        }

        if($("#sup_contact_name_input").val() == "")
        {
            valid = false;
            alert("Contact Person is Required!");
        }

        if($("#sup_contact_desig_input").val() == "")
        {
            valid = false;
            alert("Contact Person Designation is Required!");
        }

        if($("#supplier_contact_input").val() == "")
        {
            valid = false;
            alert("Contact No. is Required!");
        }

        if($("#supplier_address_input").val() == "")
        {
            valid = false;
            alert("Address is Required!");
        }

        if($("#supplier_email_input").val() == "")
        {
            valid = false;
            alert("Email is Required!");
        }

        if(!valid)
            return;

		var new_supplier =
		{
			supplier_name: $("#supplier_name_input").val(),
			supplier_contact_name: $("#sup_contact_name_input").val(),
			supplier_contact_designation: $("#sup_contact_desig_input").val(),
			supplier_contact_no: $("#supplier_contact_input").val(),
			supplier_address: $("#supplier_address_input").val(),
			supplier_email: $("#supplier_email_input").val()
		};

		// saving supplier
		var save_url = "http://" + server_url + "supplier/save";

	    http_post(save_url, new_supplier, function(data)
	    {
            // alert supplier saved successfully.
			alert("Supplier Added.");
	    });

		// reset data entry section
		resetSupplierForm();
	});
});


// on customer page initialisation
$(document).delegate("#customer", "pageinit", function(ev)
{
	ev.preventDefault();

	var currentDateTime = new Date(); // fetching current date and time
    var date = currentDateTime.getFullYear() + "-" + (currentDateTime.getMonth() + 1) + "-" + currentDateTime.getDate();
    var time = currentDateTime.getHours() + ":" + currentDateTime.getMinutes() + ":" + currentDateTime.getSeconds();
    var timestamp = date + " " + time; // creating a string with date and time

    // setting current date time for registered date input in customer form
    $('#customer_reg_date_input').val(timestamp);

	// adding tap even to save customer button
	$('#add_customer_btn').tap(function()
	{
	    var valid = true;

	    // validating data
	    if($('#title_select option:selected').val() == "")
	    {
	        valid = false;
	        alert("Customer Title is Required!");
	    }

	    if($("#customer_name_input").val() == "")
        {
            valid = false;
            alert("Customer Name is Required!");
        }

        if($("#customer_contact_input").val() == "")
        {
            valid = false;
            alert("Contact No. is Required!");
        }

        if($("#customer_address_input").val() == "")
        {
            valid = false;
            alert("Address is Required!");
        }

        if($("#customer_email_input").val() == "")
        {
            valid = false;
            alert("Email is Required!");
        }

        if($("#customer_reg_date_input").val() == "")
        {
            valid = false;
            alert("Registered is Required!");
        }

        if(!valid)
            return;

		var new_customer =
		{
		    customer_title: $('#title_select option:selected').val(),
			customer_name: $("#customer_name_input").val(),
			customer_contact_no: $("#customer_contact_input").val(),
			customer_address: $("#customer_address_input").val(),
			customer_email: $("#customer_email_input").val(),
			registered_date: $("#customer_reg_date_input").val()
		};

		// saving customer to database
		var save_url = "http://" + server_url + "customer/save";

	    http_post(save_url, new_customer, function(data)
	    {
            // alert customer saved successfully.
			alert("Customer Added.");
	    });

		// reset data entry section
		resetCustomerForm();
	});
});

// on events page initialisation
$(document).delegate("#event", "pageinit", function(ev)
{
	ev.preventDefault();

	// fetching data for populating the selects
	//fetching event types and creating select
	var get_event_types_url = "http://" + server_url + "evt_types/fetch";

    http_get(get_event_types_url, function(data)
    {
        var _select = $('<select>');

        $.each(data.list, function(i,o)
        {
            _select.append(
                $('<option></option>').val(o._id).html(o.type_code + " - " + o.type_name)
            );
        });

        $('#event_type_select').append(_select.html());
    });

    //fetching venues and halls and creating select
    var get_venue_halls_url = "http://" + server_url + "venues/fetch";

    http_get(get_venue_halls_url, function(data)
    {
        var _select = $('<select>');

        $.each(data.list, function(i,o)
        {
            $.each(o.halls, function(k,l)
            {
                _select.append(
                    $('<option></option>').val(o._id + "-" + l.hall_name).html(o.venue_name + " - " + l.hall_name)
                );
            });
        });

        $('#venue_select').append(_select.html());
    });

    //fetching customers and creating select
    var get_customers_url = "http://" + server_url + "customers/fetch";

    http_get(get_customers_url, function(data)
    {
        var _select = $('<select>');

        $.each(data.list, function(i,o)
        {
            _select.append(
                $('<option></option>').val(o._id).html(o.customer_title + " " + o.customer_name)
            );
        });

        $('#customer_select').append(_select.html());
    });

    // adding tap even to save entry button
    $('#add_event_btn').tap(function()
    {
        var valid = true;

        // validating data
        if($('#event_code_input').val() == "")
        {
            valid = false;
            alert("Event Code is Required!");
        }

        if($('#event_name_input').val() == "")
        {
            valid = false;
            alert("Event Name is Required!");
        }

        if($('#event_date_input').val() == "")
        {
            valid = false;
            alert("Event Date is Required!");
        }

        if($('#start_time_input').val() == "")
        {
            valid = false;
            alert("Start Time is Required!");
        }

        if($('#end_time_input').val() == "")
        {
            valid = false;
            alert("End Time is Required!");
        }

        if($('#event_type_select option:selected').val() == "")
        {
            valid = false;
            alert("Event Type is Required!");
        }

        if($('#venue_select option:selected').val() == "")
        {
            valid = false;
            alert("Event Venue is Required!");
        }

        if($('#customer_select option:selected').val() == "")
        {
            valid = false;
            alert("Customer is Required!");
        }

        if($('#budget_input').val() == "")
        {
            valid = false;
            alert("Budget is Required!");
        }

        if($('#remarks_input').val() == "")
        {
            valid = false;
            alert("Remarks is Required!");
        }

        if(!valid)
            return;

        var new_event =
        {
            event_code: $("#event_code_input").val(),
            event_name: $("#event_name_input").val(),
            event_date: $("#event_date_input").val(),
            start_time: $("#start_time_input").val(),
            end_time: $("#end_time_input").val(),
            event_type: $('#event_type_select option:selected').val(),
            venue_hall: $("#venue_select option:selected").val(),
            venue_id: $("#venue_select option:selected").val().split("-")[0],
            hall_name: $("#venue_select option:selected").val().split("-")[1],
            customer: $("#customer_select option:selected").val(),
            event_budget: $("#budget_input").val(),
            remarks: $("#remarks_input").val(),
            event_complete: $("#event_complete_flip").val()
        };

        // save event to database
        var save_url = "http://" + server_url + "event/save";

        http_post(save_url, new_event, function(data)
        {
            // alert event saved successfully.
            alert("Event Added.");
        });

        // reset data entry section
        resetEventForm();
    });
});

// on page show event for events lookup in checklist module
$(document).delegate("#events_lookup_checklist", "pageshow", function(ev)
{
	ev.preventDefault();

	// populating table with all events 
	$('#events_checklist_tbody').empty();

    var get_url = "http://" + server_url + "events/fetch";

    // calling get function to get events from database
    http_get(get_url, function(data)
    {
        // calling method to add returned events to the table
        addToList("events_lookup_checklist", data.list)
    });
});

// on checklist page initialisation
$(document).delegate("#event_checklist", "pageinit", function(ev)
{
	ev.preventDefault();

	// adding tap event to add item button
	$('#add_item_btn').tap(function()
	{
	    var valid = true;

	    if($('#item_input').val() == "")
	    {
	        valid = false;
	        alert("Enter Checklist Item!")
	    }

	    if($('#deadline_input').val() == "")
        {
            valid = false;
            alert("Enter Item Deadline!")
        }

        if(!valid)
            return;

        // removing default tr added when no items are added
        if($('#no_items_tr').length > 0)
            $('#no_items_tr').remove();

        var new_item = {item: $('#item_input').val(), deadline: $('#deadline_input').val(), status: "0"};

        // adding row to item list table
        $('#checklist_tbody').append("<tr><td data-label='Item'>" + $('#item_input').val() + "</td><td data-label='Deadline'>" + $('#deadline_input').val() + "</td><td data-label='Status'><input type='checkbox' name='itm_chk' id='itm_ch_"+checklist_array.length+"' data-mini='true' data-index='"+checklist_array.length+"'></td></tr>");

        //adding item to checklist array
        checklist_array.push(new_item);

        resetChecklistForm();
	});

	// tap event for save button
	$('#save_checklist_btn').tap(function()
    {
        var new_checklist =
        {
            event_id: checklist_event_id,
            items: checklist_array
        };

        var save_url = "http://" + server_url + "checklist/save";

        http_post(save_url, new_checklist, function(data)
        {
            // alert saved successfully.
            alert("Checklist Saved.");
        });

        $.mobile.changePage("index.html#events_lookup_checklist");
        checklist_event_id = null;
    });
});

// on page show event for agenda events lookup page
$(document).delegate("#events_lookup_agenda", "pageshow", function(ev)
{
	ev.preventDefault();

	$('#events_agenda_tbody').empty();

    var get_url = "http://" + server_url + "events/fetch";

    // calling get function to get events from database
    http_get(get_url, function(data)
    {
        // calling method to add returned event types to the table
        addToList("events_lookup_agenda", data.list)
    });
});

// on agenda page initialisation
$(document).delegate("#event_agenda", "pageinit", function(ev)
{
	ev.preventDefault();

	$('#add_agenda_item_btn').tap(function()
	{
	    var valid = true;

	    if($('#agenda_input').val() == "")
	    {
	        valid = false;
	        alert("Enter Agenda Item!")
	    }

	    if($('#agenda_start_time_input').val() == "")
        {
            valid = false;
            alert("Enter Agenda Start Time!")
        }

        if($('#agenda_end_time_input').val() == "")
        {
            valid = false;
            alert("Enter Agenda End Time!")
        }

        if(!valid)
            return;

        if($('#no_agenda_tr').length > 0)
            $('#no_agenda_tr').remove();

        var new_item = {agenda_item: $('#agenda_input').val(), start_time: $('#agenda_start_time_input').val(), end_time: $('#agenda_end_time_input').val()};

        // adding agenda item to agenda items list table
        $('#agenda_tbody').append("<tr><td data-label='Item'>" + $('#agenda_input').val() + "</td><td data-label='Duration'>" + $('#agenda_end_time_input').val() + " - " + $('#agenda_start_time_input').val() + "</td><td data-label='Action'><a class='text-danger' onclick='removeAgendaItem(this, " + agenda_array.length + ");'>Remove</a></td></tr>");

        agenda_array.push(new_item); // adding agenda item to array

        resetAgendaForm();
	});

	// adding tap event for save button
	$('#save_agenda_btn').tap(function()
    {
        var new_agenda =
        {
            event_id: agenda_event_id,
            agenda: agenda_array
        };

        var save_url = "http://" + server_url + "agenda/save";

        http_post(save_url, new_agenda, function(data)
        {
            // alert saved successfully.
            alert("Agenda Saved.");
        });

        $.mobile.changePage("index.html#events_lookup_agenda");
        agenda_event_id = null;
    });
});

// on change event for checkboxes in checklist
$(document).on('change', '[type=checkbox]', function(event)
{
	// updating array
    if($(this).prop('checked'))
    {
        checklist_array[$(this).data('index')].status = "1";
    }
    else
    {
        checklist_array[$(this).data('index')].status = "0";
    }
});

// method to remove agenda item from agenda
function removeAgendaItem(e, index)
{
	// removing from array
    if(index != null)
    {
        agenda_array.splice(index, 1);
    }

    // removing table row
    $(e).parent().parent().remove();
}

// method to determine which button the user clicked on
function loadPage(menuOption)
{
	// switch case gets the pressed button's id and determines the module
	switch(menuOption.id)
	{
		case "evt_type_btn":
			$.mobile.changePage("index.html#event_type");
			break;
		case "venues_btn":
			$.mobile.changePage("index.html#venue");
			break;
		case "suppliers_btn":
			$.mobile.changePage("index.html#supplier");
			break;
		case "customers_btn":
			$.mobile.changePage("index.html#customer");
			break;
		case "events_btn":
			$.mobile.changePage("index.html#event");
			break;
        case "checklist_btn":
            $.mobile.changePage("index.html#events_lookup_checklist");
            break;
        case "agenda_btn":
            $.mobile.changePage("index.html#events_lookup_agenda");
            break;
		default:
			break;
	}
}

// method to load selected record to data entry page in edit mode
function loadEditPage(module, id, status)
{
    if(module == "event_types")
    {
        var get_url = "http://" + server_url + "search/event_type/" + id;

        $.mobile.changePage("index.html#event_type");

        // calling get function to get event type from database
        http_get(get_url, function(data)
        {
            if(data.list.length > 0)
            {
                var record = data.list[0];

                $('#evt_type_code_input').val(record.type_code);
                $('#evt_type_input').val(record.type_name);

                $('#add_evt_btn').addClass("hidden");
                $('#edit_evt_btn').removeClass('hidden');
                $('#edit_evt_btn').attr('onclick', 'editRecord("event_type", "'+record._id+'");');
            }
            else
            {
                alert("No Record Found!");
            }

        });
    }
    else if(module == "venues")
    {
        var get_url = "http://" + server_url + "search/venue/" + id;

        $.mobile.changePage("index.html#venue");

        // calling get function to get venue from database
        http_get(get_url, function(data)
        {
            if(data.list.length > 0)
            {
                var record = data.list[0];

                $('#venue_name_input').val(record.venue_name);
                $('#venue_contact_input').val(record.contact_no);
                $('#venue_address_input').val(record.address);
                $('#venue_email_input').val(record.email);

                $('#halls_list').empty().listview("refresh");
                halls_array = record.halls;

                $.each(record.halls, function(i,o)
                {
                    $('#halls_list').append("<li>" + o.hall_name.toString() + "</li>").listview('refresh');
                });

                $('#add_venue_btn').addClass("hidden");
                $('#edit_venue_btn').removeClass('hidden');
                $('#edit_venue_btn').attr('onclick', 'editRecord("venue", "'+record._id+'");');
            }
            else
            {
                alert("No Record Found!");
            }

        });
    }
    else if(module == "suppliers")
    {
        var get_url = "http://" + server_url + "search/supplier/" + id;

        $.mobile.changePage("index.html#supplier");

        // calling get function to get supplier from database
        http_get(get_url, function(data)
        {
            if(data.list.length > 0)
            {
                var record = data.list[0];

                $('#supplier_name_input').val(record.supplier_name);
                $('#sup_contact_name_input').val(record.supplier_contact_name);
                $('#sup_contact_desig_input').val(record.supplier_contact_designation);
                $('#supplier_contact_input').val(record.supplier_contact_no);
                $('#supplier_address_input').val(record.supplier_address);
                $('#supplier_email_input').val(record.supplier_email);

                $('#add_supplier_btn').addClass("hidden");
                $('#edit_supplier_btn').removeClass('hidden');
                $('#edit_supplier_btn').attr('onclick', 'editRecord("supplier", "'+record._id+'");');
            }
            else
            {
                alert("No Record Found!");
            }

        });
    }
    else if(module == "customers")
    {
        var get_url = "http://" + server_url + "search/customer/" + id;

        $.mobile.changePage("index.html#customer");

        // calling get function to get customer from database
        http_get(get_url, function(data)
        {
            if(data.list.length > 0)
            {
                var record = data.list[0];

                $('#title_select').val(record.customer_title);
                $('#title_select').selectmenu();
                $('#title_select').selectmenu('refresh');

                $('#customer_name_input').val(record.customer_name);
                $('#customer_contact_input').val(record.customer_contact_no);
                $('#customer_address_input').val(record.customer_address);
                $('#customer_email_input').val(record.customer_email);
                $('#customer_reg_date_input').val(record.registered_date);

                $('#add_customer_btn').addClass("hidden");
                $('#edit_customer_btn').removeClass('hidden');
                $('#edit_customer_btn').attr('onclick', 'editRecord("customer", "'+record._id+'");');
            }
            else
            {
                alert("No Record Found!");
            }

        });
    }
    else if(module == "events")
    {
        var get_url = "http://" + server_url + "search/event/" + id;

        $.mobile.changePage("index.html#event");

        // calling get function to get event from database
        http_get(get_url, function(data)
        {
            if(data.list.length > 0)
            {
                var record = data.list[0];
                $('#event_code_input').val(record.event_code);
                $('#event_name_input').val(record.event_name);
                $('#event_date_input').val(record.event_date);
                $('#start_time_input').val(record.start_time);
                $('#end_time_input').val(record.end_time);

                $('#event_type_select').val(record.event_type);
                $('#venue_select').val(record.venue_hall);
                $('#customer_select').val(record.customer);
                $('#event_type_select, #venue_select, #customer_select').selectmenu();
                $('#event_type_select, #venue_select, #customer_select').selectmenu('refresh');

                $('#budget_input').val(record.event_budget);
                $('#remarks_input').val(record.remarks);
                $('#event_complete_flip').val(record.event_complete).slider("refresh");

                $('#add_event_btn').addClass("hidden");

                if(record.event_complete == "0")
                {
                    $('#edit_event_btn').removeClass('hidden');
                    $('#edit_event_btn').attr('onclick', 'editRecord("event", "'+record._id+'");');
                }
            }
            else
            {
                alert("No Record Found!");
            }

        });
    }
    else if(module == "event_checklist")
    {
        checklist_event_id = id;
        var get_url = "http://" + server_url + "search/checklist/" + id;

        $.mobile.changePage("index.html#event_checklist");

        // calling get function to get checklist from database
        http_get(get_url, function(data)
        {
            $('#checklist_tbody').empty();
            checklist_array = new Array();

            if(data.list.length > 0)
            {
                var record = data.list[0];

                if(status != null && status != undefined)
                {
                	// checking event status before loading checklist to interface. 
                	// If event is complete the checklist will be not editable
                    if(status == "0")
                    {
                        $.each(record.items, function(i,o)
                        {
                            if($('#no_items_tr').length > 0)
                                $('#no_items_tr').remove();

                            var new_item = {item: o.item, deadline: o.deadline, status: o.status};

                            $('#checklist_tbody').append("<tr><td data-label='Item'>" + o.item + "</td><td data-label='Deadline'>" + o.deadline + "</td><td data-label='Status'><input type='checkbox' name='itm_chk' id='itm_ch_"+checklist_array.length+"' data-mini='true' data-index='"+checklist_array.length+"' " + (o.status == "1" ? "checked": "") + "></td></tr>");

                            checklist_array.push(new_item);
                        });

                        $('#save_checklist_btn').addClass("hidden");
                        $('#add_item_btn').prop('disabled', false);

                        $('#edit_checklist_btn').removeClass('hidden');
                        $('#edit_checklist_btn').attr('onclick', 'editRecord("checklist", "'+record._id+'");');
                    }
                    else if(status == "1")
                    {
                        $.each(record.items, function(i,o)
                        {
                            if($('#no_items_tr').length > 0)
                                $('#no_items_tr').remove();

                            var new_item = {item: o.item, deadline: o.deadline, status: o.status};

                            $('#checklist_tbody').append("<tr><td data-label='Item'>" + o.item + "</td><td data-label='Deadline'>" + o.deadline + "</td><td data-label='Status'>" + (o.status == "1" ? "Done": "Not Done") + "</td></tr>");

                            checklist_array.push(new_item);
                        });

                        $('#save_checklist_btn').addClass("hidden");
                        $('#edit_checklist_btn').addClass("hidden");
                        $('#add_item_btn').prop('disabled', true);
                    }
                }
            }
            else // if no previuosly added items for checklist found
            {
                $('#checklist_tbody').append('<tr id="no_items_tr"><td colspan="3">No Items Added</td></tr>');

                if(status == "0")
                {
                    $('#save_checklist_btn').removeClass("hidden");
                    $('#add_item_btn').prop('disabled', false);
                    $('#edit_checklist_btn').addClass('hidden');
                }
                else
                {
                    $('#save_checklist_btn').addClass("hidden");
                    $('#add_item_btn').prop('disabled', true);
                }

                alert("No Record Found!");
            }

        });
    }
    else if(module == "event_agenda")
    {
        agenda_event_id = id;
        var get_url = "http://" + server_url + "search/agenda/" + id;

        $.mobile.changePage("index.html#event_agenda");

        // calling get function to get agenda from database
        http_get(get_url, function(data)
        {
            $('#agenda_tbody').empty();
            agenda_array = new Array();

            if(data.list.length > 0)
            {
                var record = data.list[0];

                if(status != null && status != undefined)
                {
                	// checking event status before loading agenda to interface. 
                	// If event is complete the agenda will be not editable
                    if(status == "0")
                    {
                        $.each(record.agenda, function(i,o)
                        {
                            if($('#no_agenda_tr').length > 0)
                                $('#no_agenda_tr').remove();

                            var new_item = {agenda_item: o.agenda_item, start_time: o.start_time, end_time: o.end_time};

                            $('#agenda_tbody').append("<tr><td data-label='Item'>" + o.agenda_item + "</td><td data-label='Duration'>" + o.start_time + " - " + o.end_time + "</td><td data-label='Action'><a class='text-danger' onclick='removeAgendaItem(this, " + agenda_array.length + ");'>Remove</a></td></tr>");

                            agenda_array.push(new_item);
                        });

                        $('#save_agenda_btn').addClass("hidden");
                        $('#add_agenda_item_btn').prop('disabled', false);

                        $('#edit_agenda_btn').removeClass('hidden');
                        $('#edit_agenda_btn').attr('onclick', 'editRecord("agenda", "'+record._id+'");');
                    }
                    else if(status == "1")
                    {
                        $.each(record.agenda, function(i,o)
                        {
                            if($('#no_agenda_tr').length > 0)
                                $('#no_agenda_tr').remove();

                            var new_item = {agenda_item: o.agenda_item, start_time: o.start_time, end_time: o.end_time};

                            $('#agenda_tbody').append("<tr><td data-label='Item'>" + o.agenda_item + "</td><td data-label='Duration'>" + o.start_time + " - " + o.end_time + "</td><td data-label='Action'>Event Complete</td></tr>");

                            agenda_array.push(new_item);
                        });

                        $('#save_agenda_btn').addClass("hidden");
                        $('#edit_agenda_btn').addClass("hidden");
                        $('#add_agenda_item_btn').prop('disabled', true);
                    }
                }
            }
            else // if no previously added agenda items were found
            {
                $('#agenda_tbody').append('<tr id="no_agenda_tr"><td colspan="3">No Items Added</td></tr>');

                if(status == "0")
                {
                    $('#save_agenda_btn').removeClass("hidden");
                    $('#add_agenda_item_btn').prop('disabled', false);
                    $('#edit_agenda_btn').addClass('hidden');
                }
                else
                {
                    $('#save_agenda_btn').addClass("hidden");
                    $('#add_agenda_item_btn').prop('disabled', true);
                }

                alert("No Record Found!");
            }
        });
    }
}

// method to update selected record
function editRecord(module, recordID)
{
    if(module == "event_type")
    {
    	// edit url
        var update_url = "http://" + server_url + "event_type/edit";

        var updated_record =
        {
            id: recordID,
            type_code: $("#evt_type_code_input").val(),
            type_name: $("#evt_type_input").val()
        };

        http_post(update_url, updated_record, function(data)
        {
            // alert event type updated successfully.
            alert("Event Type Updated.");

            resetEventTypeForm();
        });
    }
    else if(module == "venue")
    {
        var update_url = "http://" + server_url + "venue/edit";

        var updated_record =
        {
            id: recordID,
            venue_name: $("#venue_name_input").val(),
            contact_no: $("#venue_contact_input").val(),
            address: $("#venue_address_input").val(),
            email: $("#venue_email_input").val(),
            halls: halls_array
        };

        http_post(update_url, updated_record, function(data)
        {
            // alert venue updated successfully.
            alert("Venue Updated.");

            resetVenueForm();
        });
    }
    else if(module == "supplier")
    {
        var update_url = "http://" + server_url + "supplier/edit";

        var updated_record =
        {
            id: recordID,
            supplier_name: $("#supplier_name_input").val(),
            supplier_contact_name: $("#sup_contact_name_input").val(),
            supplier_contact_designation: $("#sup_contact_desig_input").val(),
            supplier_contact_no: $("#supplier_contact_input").val(),
            supplier_address: $("#supplier_address_input").val(),
            supplier_email: $("#supplier_email_input").val()
        };

        http_post(update_url, updated_record, function(data)
        {
            // alert supplier updated successfully.
            alert("Supplier Updated.");

            resetSupplierForm();
        });
    }
    else if(module == "customer")
    {
        var update_url = "http://" + server_url + "customer/edit";

        var updated_record =
        {
            id: recordID,
            customer_title: $('#title_select option:selected').val(),
            customer_name: $("#customer_name_input").val(),
            customer_contact_no: $("#customer_contact_input").val(),
            customer_address: $("#customer_address_input").val(),
            customer_email: $("#customer_email_input").val(),
            registered_date: $("#customer_reg_date_input").val()
        };

        http_post(update_url, updated_record, function(data)
        {
            // alert customer updated successfully.
            alert("Customer Updated.");

            resetCustomerForm();
        });
    }
    else if(module == "event")
    {
        var update_url = "http://" + server_url + "event/edit";

        var updated_record =
        {
            id: recordID,
            event_code: $("#event_code_input").val(),
            event_name: $("#event_name_input").val(),
            event_date: $("#event_date_input").val(),
            start_time: $("#start_time_input").val(),
            end_time: $("#end_time_input").val(),
            event_type: $('#event_type_select option:selected').val(),
            venue_hall: $("#venue_select option:selected").val(),
            venue_id: $("#venue_select option:selected").val().split("-")[0],
            hall_name: $("#venue_select option:selected").val().split("-")[1],
            customer: $("#customer_select option:selected").val(),
            event_budget: $("#budget_input").val(),
            remarks: $("#remarks_input").val(),
            event_complete: $("#event_complete_flip").val()
        };

        http_post(update_url, updated_record, function(data)
        {
            // alert event updated successfully.
            alert("Event Updated.");

            resetEventForm();
        });
    }
    else if(module == "checklist")
    {
        var update_url = "http://" + server_url + "checklist/edit";

        var updated_record =
        {
            id: recordID,
            event_id: checklist_event_id,
            items: checklist_array
        };

        http_post(update_url, updated_record, function(data)
        {
            // alert checklist updated successfully.
            alert("Checklist Updated.");

            $.mobile.changePage("index.html#events_lookup_checklist");
            checklist_event_id = null;
        });
    }
    else if(module == "agenda")
    {
        var update_url = "http://" + server_url + "agenda/edit";

        var updated_record =
        {
            id: recordID,
            event_id: agenda_event_id,
            agenda: agenda_array
        };

        http_post(update_url, updated_record, function(data)
        {
            // alert agenda updated successfully.
            alert("Agenda Updated.");

            $.mobile.changePage("index.html#events_lookup_agenda");
            agenda_event_id = null;
        });
    }
}

// method to load all records to "view all" page 
function loadViewPage(module)
{
    if(module == "event_types")
    {
        $('#evt_types_tbody').empty();

    	var get_url = "http://" + server_url + "evt_types/fetch";

        $.mobile.changePage("index.html#view_event_types");

        // calling get function to get event types from database
        http_get(get_url, function(data)
        {
            // calling method to add returned event types to the table
            addToList(module, data.list)
        });
    }
    else if(module == "venues")
    {
        $('#venues_tbody').empty();

        var get_url = "http://" + server_url + "venues/fetch";

        $.mobile.changePage("index.html#view_venues");

        // calling get function to get venues from database
        http_get(get_url, function(data)
        {
            // calling method to add returned venues to the table
            addToList(module, data.list)
        });
    }
    else if(module == "suppliers")
    {
        $('#suppliers_tbody').empty();

        var get_url = "http://" + server_url + "suppliers/fetch";

        $.mobile.changePage("index.html#view_suppliers");

        // calling get function to get supplier from database
        http_get(get_url, function(data)
        {
            // calling method to add returned supplier to the table
            addToList(module, data.list)
        });
    }
    else if(module == "customers")
    {
        $('#customers_tbody').empty();

        var get_url = "http://" + server_url + "customers/fetch";

        $.mobile.changePage("index.html#view_customers");

        // calling get function to get customers from database
        http_get(get_url, function(data)
        {
            // calling method to add returned customers to the table
            addToList(module, data.list)
        });
    }
    else if(module == "events")
    {
        $('#events_tbody').empty();

        var get_url = "http://" + server_url + "events/fetch";

        $.mobile.changePage("index.html#view_events");

        // calling get function to get events from database
        http_get(get_url, function(data)
        {
            // calling method to add returned events to the table
            addToList(module, data.list)
        });
    }
}

// method to populate the table in "view all" pages and checklist and agenda event lookups
function addToList(module, data)
{
    if(module == "event_types")
    {
        if(data.length > 0)
        {
        	// looping through records and appending rows to table
            $.each(data, function(i,o)
            {
                var row = "<tr>" +
                            "<td data-label='Event Type Code'>" + o.type_code.toString() + "</td>" +
                            "<td data-label='Event Type'>" + o.type_name.toString() + "</td>" +
                            "<td data-label='Actions'><a class='text-success' onclick='loadEditPage(\"event_types\", \"" + o._id + "\");'>Edit</a> | " +
                            "<a id='" + o._id + "' data-type='event_type' onclick='getDeleteData(this);' class='text-danger' href='#deleteConfirmationDialog' data-rel='dialog'>Delete</a></td>" +
                            "</tr>";

                $('#evt_types_tbody').append(row);
            });
        }
        else
        {
            var row = "<tr><td colspan='3'>No Event Types Found.</td></tr>";

            $('#evt_types_tbody').append(row);
        }
    }
    else if(module == "venues")
    {
        if(data.length > 0)
        {
            $.each(data, function(i,o)
            {
                var row = "<tr>" +
                         "<td data-label='Venue Name'>" + o.venue_name.toString() + "</td>" +
                         "<td data-label='Contact No.'>" + o.contact_no.toString() + "</td>" +
                         "<td data-label='Email'>" + o.email.toString() + "</td>" +
                         "<td data-label='Actions'><a class='text-success' onclick='loadEditPage(\"venues\", \"" + o._id + "\");'>Edit</a> | " +
                         "<a id='" + o._id + "' data-type='venue' onclick='getDeleteData(this);' class='text-danger' href='#deleteConfirmationDialog' data-rel='dialog'>Delete</a></td>" +
                         "</tr>";

                $('#venues_tbody').append(row);
            });
        }
        else
        {
            var row = "<tr><td colspan='4'>No Venues Found.</td></tr>";

            $('#venues_tbody').append(row);
        }
    }
    else if(module == "suppliers")
    {
        if(data.length > 0)
        {
            $.each(data, function(i,o)
            {
                var row = "<tr>" +
                         "<td data-label='Supplier Name'>" + o.supplier_name.toString() + "</td>" +
                         "<td data-label='Address'>" + o.supplier_address.toString() + "</td>" +
                         "<td data-label='Contact Person'>" + o.supplier_contact_name.toString() + "</td>" +
                         "<td data-label='Contact No.'>" + o.supplier_contact_no.toString() + "</td>" +
                         "<td data-label='Actions'><a class='text-success' onclick='loadEditPage(\"suppliers\", \"" + o._id + "\");'>Edit</a> | " +
                         "<a id='" + o._id + "' data-type='supplier' onclick='getDeleteData(this);' class='text-danger' href='#deleteConfirmationDialog' data-rel='dialog'>Delete</a></td>" +
                         "</tr>";

                $('#suppliers_tbody').append(row);
            });
        }
        else
        {
            var row = "<tr><td colspan='5'>No Suppliers Found.</td></tr>";

            $('#suppliers_tbody').append(row);
        }
    }
    else if(module == "customers")
    {
        if(data.length > 0)
        {
            $.each(data, function(i,o)
            {
                var row = "<tr>" +
                         "<td data-label='Customer Name'>" + o.customer_title + " " + o.customer_name.toString() + "</td>" +
                         "<td data-label='Contact No.'>" + o.customer_contact_no.toString() + "</td>" +
                         "<td data-label='Email'>" + o.customer_email.toString() + "</td>" +
                         "<td data-label='Actions'><a class='text-success' onclick='loadEditPage(\"customers\", \"" + o._id + "\");'>Edit</a> | " +
                         "<a id='" + o._id + "' data-type='customer' onclick='getDeleteData(this);' class='text-danger' href='#deleteConfirmationDialog' data-rel='dialog'>Delete</a></td>" +
                         "</tr>";

                $('#customers_tbody').append(row);
            });
        }
        else
        {
            var row = "<tr><td colspan='4'>No Customers Found.</td></tr>";

            $('#customers_tbody').append(row);
        }
    }
    else if(module == "events")
    {
        if(data.length > 0)
        {
            $.each(data, function(i,o)
            {
                var row = "<tr>" +
                         "<td data-label='Event Code & Name'>" + o.event_code + " " + o.event_name + "</td>" +
                         "<td data-label='Event Date & Time'>" + o.event_date + " " + o.start_time + " - " + o.end_time + "</td>" +
                         "<td data-label='Event Type'>" + o.event_type + "</td>" +
                         "<td data-label='Venue'>" + o.venue_name + " - " + o.hall_name + "</td>" +
                         "<td data-label='Customer'>" + o.customer_title + " " + o.customer_name + "</td>" +
                         "<td data-label='Actions'><a class='text-success' onclick='loadEditPage(\"events\", \"" + o._id + "\");'>" + (o.event_complete == "0" ? 'Edit' : 'View') + "</a> | " +
                         "<a id='" + o._id + "' data-type='event' onclick='getDeleteData(this);' class='text-danger' href='#deleteConfirmationDialog' data-rel='dialog'>Delete</a></td>" +
                         "</tr>";

                $('#events_tbody').append(row);
            });
        }
        else
        {
            var row = "<tr><td colspan='6'>No Events Found.</td></tr>";

            $('#events_tbody').append(row);
        }
    }
    else if(module == "events_lookup_checklist")
    {
        if(data.length > 0)
        {
            $.each(data, function(i,o)
            {
                var row = "<tr>" +
                         "<td data-label='Event Code & Name'>" + o.event_code + " " + o.event_name + "</td>" +
                         "<td data-label='Event Date & Time'>" + o.event_date + " " + o.start_time + " - " + o.end_time + "</td>" +
                         "<td data-label='Event Type'>" + o.event_type + "</td>" +
                         "<td data-label='Venue'>" + o.venue_name + " - " + o.hall_name + "</td>" +
                         "<td data-label='Customer'>" + o.customer_title + " " + o.customer_name + "</td>" +
                         "<td data-label='Actions'>" + (o.event_complete == "0" ? "<a class='text-primary' onclick='loadEditPage(\"event_checklist\", \"" + o._id + "\", \"" + o.event_complete +"\");'>Add Checklist</a>" : "<a class='text-success' onclick='loadEditPage(\"event_checklist\", \"" + o._id + "\", \"" + o.event_complete +"\");'>View Checklist</a>") + "</td>" +
                         "</tr>";

                $('#events_checklist_tbody').append(row);
            });
        }
        else
        {
            var row = "<tr><td colspan='6'>No Events Found.</td></tr>";

            $('#events_checklist_tbody').append(row);
        }
    }
    else if(module == "events_lookup_agenda")
    {
        if(data.length > 0)
        {
            $.each(data, function(i,o)
            {
                var row = "<tr>" +
                         "<td data-label='Event Code & Name'>" + o.event_code + " " + o.event_name + "</td>" +
                         "<td data-label='Event Date & Time'>" + o.event_date + " " + o.start_time + " - " + o.end_time + "</td>" +
                         "<td data-label='Event Type'>" + o.event_type + "</td>" +
                         "<td data-label='Venue'>" + o.venue_name + " - " + o.hall_name + "</td>" +
                         "<td data-label='Customer'>" + o.customer_title + " " + o.customer_name + "</td>" +
                         "<td data-label='Actions'>" + (o.event_complete == "0" ? "<a class='text-primary' onclick='loadEditPage(\"event_agenda\", \"" + o._id + "\", \"" + o.event_complete +"\");'>Add Agenda</a>" : "<a class='text-success' onclick='loadEditPage(\"event_agenda\", \"" + o._id + "\", \"" + o.event_complete +"\");'>View Agenda</a>") + "</td>" +
                         "</tr>";

                $('#events_agenda_tbody').append(row);
            });
        }
        else
        {
            var row = "<tr><td colspan='6'>No Events Found.</td></tr>";

            $('#events_agenda_tbody').append(row);
        }
    }
}

// method to store information about record to be deleted
function getDeleteData(e)
{
    del_module = $(e).data('type');
    del_id = e.id;
}

// clearing delete data once it is deleted
function clearDeleteData()
{
    del_module = null;
    del_id = null;
}

// method to delete a record
function deleteRecord()
{
    if(del_module != null && del_id != null)
    {
    	// delete URL
        var delete_url = "http://" + server_url + del_module + "/delete";

        var delete_record =
        {
            id: del_id
        };

        http_post(delete_url, delete_record, function(data)
        {
            // alert deleted successfully.
            alert("Record Deleted.");
        });

        // loading module data entry page after deleting successfully
        if(del_module == "event_type")
        {
            del_module = null;
            del_id = null;

            $.mobile.changePage("index.html#event_type");
        }
        else if(del_module == "venue")
        {
            del_module = null;
            del_id = null;

            $.mobile.changePage("index.html#venue");
        }
        else if(del_module == "supplier")
        {
            del_module = null;
            del_id = null;

            $.mobile.changePage("index.html#supplier");
        }
        else if(del_module == "customer")
        {
            del_module = null;
            del_id = null;

            $.mobile.changePage("index.html#customer");
        }
        else if(del_module == "event")
        {
            del_module = null;
            del_id = null;

            $.mobile.changePage("index.html#event");
        }
    }
}

// get method to make an ajax call with url passed
function http_get(url, win)
{
    $.ajax(
    {
        url:url,
        dataType:'json',
        success:win,
        error:function(err)
        {
            // show an alert if an error occurs
            showAlert('Network','Unable to contact server.')
        }
    });
}

// post method to make an ajax call with passed url
function http_post(url, data, win)
{
    console.log(url + JSON.stringify(data))
    $.ajax(
    {
        url: url,
        crossDomain: true,
        type:'POST',
        headers: {
        	"Access-Control-Allow-Origin": "*", 
        	"Access-Control-Allow-Methods": "POST GET OPTIONS",
        	"Access-Control-Allow-Headers": "Origin, X-Requested-With, Content-Type, Accept",
        	"Access-Control-Allow-Credentials": "true" },
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: 'json',
        xhrFields: {
            withCredentials: true
        },
        success: win,
        error:function(err)
        {
            // show an alert if an error occurs
            showAlert('Network','Unable to contact server.')
        }
    });
}

// method to alert messages
function showAlert(title, msg)
{
    alert(msg);
}

// method called when back button in show logs page is pressed
function goBack(module)
{
    if(module == "event_types")
    {
        // load data entry page
        $.mobile.changePage("index.html#event_type");

        // reset data entry form
        resetEventTypeForm();
    }
    else if(module == "venues")
    {
        // load data entry page
        $.mobile.changePage("index.html#venue");

        // reset data entry form
        resetVenueForm();
    }
    else if(module == "suppliers")
    {
        // load data entry page
        $.mobile.changePage("index.html#supplier");

        // reset data entry form
        resetSupplierForm();
    }
    else if(module == "customers")
    {
        // load data entry page
        $.mobile.changePage("index.html#customer");

        // reset data entry form
        resetCustomerForm();
    }
    else if(module == "events")
    {
        // load data entry page
        $.mobile.changePage("index.html#event");

        // reset data entry form
        resetEventForm();
    }
    else if(module == "event_checklist")
    {
        // load data entry page
        $.mobile.changePage("index.html#events_lookup_checklist");

        // reset data entry form
        resetChecklistForm();
    }
    else if(module == "event_agenda")
    {
        // load data entry page
        $.mobile.changePage("index.html#events_lookup_agenda");

        // reset data entry form
        resetAgendaForm();
    }
}

// method to reset event type creation page
function resetEventTypeForm()
{
	$('.evt_type_inputs').val("");
	$('#add_evt_btn').removeClass("hidden");
    $('#edit_evt_btn').addClass('hidden');
    $('#edit_evt_btn').removeAttr('onclick');
}

// method to reset venue creation page
function resetVenueForm()
{
    halls_array = new Array();

    $('.venue_inputs').val("");
    $('#halls_list').empty();
    $('#halls_list').listview();
    $('#halls_list').listview("refresh");
    $('#add_venue_btn').removeClass("hidden");
    $('#edit_venue_btn').addClass('hidden');
    $('#edit_venue_btn').removeAttr('onclick');
}

// method to reset supplier creation page
function resetSupplierForm()
{
    $('.supplier_inputs').val("");
    $('#add_supplier_btn').removeClass("hidden");
    $('#edit_supplier_btn').addClass('hidden');
    $('#edit_supplier_btn').removeAttr('onclick');
}

// method to reset customer creation page
function resetCustomerForm()
{
    $('.customer_inputs').val("");
    $('#title_select').val("");
    $('#title_select').selectmenu();
    $('#title_select').selectmenu('refresh');
    $('#add_customer_btn').removeClass("hidden");
    $('#edit_customer_btn').addClass('hidden');
    $('#edit_customer_btn').removeAttr('onclick');
}

// method to reset event creation page
function resetEventForm()
{
    $('.event_inputs').val("");
    $('#event_complete_flip').val("0")
    $('#event_complete_flip').slider();
    $('#event_complete_flip').slider("refresh");
    $('#event_type_select, #venue_select, #customer_select').val("");
    $('#event_type_select, #venue_select, #customer_select').selectmenu();
    $('#event_type_select, #venue_select, #customer_select').selectmenu('refresh');
    $('#add_event_btn').removeClass("hidden");
    $('#edit_event_btn').addClass('hidden');
    $('#edit_event_btn').removeAttr('onclick');
}

// method to reset item entry section in checklist page
function resetChecklistForm()
{
    $('.checklist_inputs').val("");
}
// method to reset item entry section in agenda page
function resetAgendaForm()
{
    $('.agenda_inputs').val("");
}

// method called when home button is clicked. resetting current page to home page
function resetHome()
{
    del_id = null;
    del_module = null;

	resetEventTypeForm();
	resetVenueForm();
	resetSupplierForm();
	resetCustomerForm();
	resetEventForm();
	resetChecklistForm();
	resetAgendaForm();
}
