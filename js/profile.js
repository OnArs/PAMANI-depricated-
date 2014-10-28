// Pay
$(function(){
    $("#pay, .pay-link, .getBoxPay").click(function(){
        $("#pay-win").fadeIn("fast");
    });
    $(".close").click(function(){
        $("#pay-win").fadeOut("fast");
    });
});


// Options
$(function(){
    $("#options, .getBoxSettings").click(function(){
        $("#options-win").fadeIn("fast");
    });
    $(".close").click(function(){
        $("#options-win").fadeOut("fast");
    });
});

$(document).mouseup(function(e){
    var container = $("#pay-win, #options-win");
    if (container.has(e.target).length === 0){
        container.fadeOut("fast");
    }});


// Tabs
$(function(){
    $("#tabs .h-tab > a").click( function(){
        $("#tabs .h-tab > a").removeClass("current");
        $(this).addClass("current");
        $(".tabs_content .tb").hide();
        t_content=$(this).attr("href");
        $(t_content).show();
        return false})
    $("#tabs .h-tab > a:first").trigger("click");
});

// Profile indicator
$(function(){

    if ($(".tips").css("display")=="block") {
        $("#login-on").attr("id","login-off");
    }
    if ($(".errors").css("display")=="block") {
        $("#login-on").attr("id","login-off");
    }

});