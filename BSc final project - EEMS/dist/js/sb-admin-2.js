/*!
 * Start Bootstrap - SB Admin 2 v3.3.7+1 (http://startbootstrap.com/template-overviews/sb-admin-2)
 * Copyright 2013-2016 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */
$(function() {
    $('#side-menu').metisMenu();
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function() {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});

function showConfirmation(title,body,yes_action,no_action)
{
    $('#general_confirmation_modal_body_yes_btn').show();
    $('#general_confirmation_modal_body_no_btn').show();

    $('#general_confirmation_modal_title').html(title);
    $('#general_confirmation_modal_body').html(body);

    if(yes_action != "")
        $('#general_confirmation_modal_body_yes_btn').attr('onclick',yes_action + '$("#general_confirmation_modal").modal("hide");');
    else
        $('#general_confirmation_modal_body_yes_btn').hide();

    if(no_action != "")
        $('#general_confirmation_modal_body_no_btn').attr('onclick',(no_action == undefined ? '$("#general_confirmation_modal").modal("hide")' : no_action));
    else
        $('#general_confirmation_modal_body_no_btn').hide();

    $("#general_confirmation_modal").modal('show');
    return;
}

$('#general_confirmation_modal').on('shown.bs.modal', function () 
{
    $('#general_confirmation_modal_body_yes_btn').focus();
});