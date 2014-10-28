// Makeup Baurg!art (http://burgarts.ru/)

// Floating menu
$(document).ready(function(){
$(function(){
$(window).scroll(function(){
if ($(this).scrollTop() > 450){
$("#menu_body").addClass("floating");
} else {
$("#menu_body").removeClass("floating");
}
});
});
});

// Social buttons
$(function(){
    $("#vk").on("click",function(){
        window.open("http://vk.com/share.php?url=http://pamani.ru");
    });
    $("#fb").on("click",function(){
        window.open("https://www.facebook.com/sharer/sharer.php?u=http://pamani.ru");
    });
    $("#tw").on("click",function(){
        window.open("https://twitter.com/intent/tweet?original_referer=http://pamani.ru&text=PAMANI%20-%20%D1%8D%D1%84%D1%84%D0%B5%D0%BA%D1%82%D0%B8%D0%B2%D0%BD%D0%BE%D0%B5%20%D0%BF%D1%80%D0%BE%D0%B4%D0%B2%D0%B8%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5%20%D0%B2%20%D0%B8%D0%BD%D1%81%D1%82%D0%B3%D1%80%D0%B0%D0%BC%D0%B5&url=http://pamani.ru");
    });
    $("#gp").on("click",function(){
        window.open("https://plus.google.com/share?url=http://pamani.ru");
    });
});


// Feedback form
$(function(){
   //$("form").on("submit",function(){
       //$(".fname, .fmail, .fmessage").val('');
   //});
});


// Scroll menu
$(document).ready(function(){
$('a[href*=#]').bind("click", function(e){
var anchor = $(this);
var name = anchor.attr('href').replace(new RegExp("#",'gi'), '');
$('html, body').stop().animate({
scrollTop: $('a[name='+name+']').offset().top -140
}, 700);
e.preventDefault();
return false;
});
});


// Slider interface
(function ($){
var hwSlideSpeed = 400;
var hwTimeOut = 7000;
var hwNeedLinks = true;
$(document).ready(function(e) {
$('.slide').css({"position":"absolute", "top":'0', "left":'0'}).hide().eq(0).show();
var slideNum = 0;
var slideTime;
slideCount = $("#slider .slide").size();
var animSlide = function(arrow){
clearTimeout(slideTime);
$('.slide').eq(slideNum).fadeOut(hwSlideSpeed);
if(arrow == "next"){
if(slideNum == (slideCount-1)){slideNum=0;}
else{slideNum++}}
else if(arrow == "prew"){
if(slideNum == 0){slideNum=slideCount-1;}
else{slideNum-=1}}
else{
slideNum = arrow;}
$('.slide').eq(slideNum).fadeIn(hwSlideSpeed, rotator);
$(".control-slide.active").removeClass("active");
$('.control-slide').eq(slideNum).addClass('active');}
if(hwNeedLinks){
var $linkArrow = $('<a id="sprew" href="#"></a><a id="snext" href="#"></a>')
.prependTo('#slider');		
$('#snext').click(function(){
animSlide("next");
return false;})
$('#sprew').click(function(){
animSlide("prew");
return false;})}
var $adderSpan = '';
$('.slide').each(function(index) {
$adderSpan += '<span class = "control-slide">' + index + '</span>';});
$('<div class ="sli-links">' + $adderSpan +'</div>').appendTo('#slider');
$(".control-slide:first").addClass("active");
$('.control-slide').click(function(){
var goToNum = parseFloat($(this).text());
animSlide(goToNum);});
var pause = true;
var rotator = function(){
if(!pause){slideTime = setTimeout(function(){animSlide('next')}, hwTimeOut);}}
$('#slider').hover(	
function(){clearTimeout(slideTime); pause = true;},
function(){pause = false; rotator();});rotator();});
})(jQuery);


// Slider reviews
$(document).ready(function(){
$(".slider2").each(function(){
var obj = $(this);
$(obj).append("<div id='slider-nav'><div id='other'>Другие отзывы</div> <p></p> <div class='nav'></div></div>");
$(obj).find("li").each(function(){
$(obj).find(".nav").append("<span rel='"+$(this).index()+"'></span>");
$(this).addClass("slider2"+$(this).index());
});
$(obj).find("span").first().addClass("on");
});
});
function sliderJS (obj, sl){
var ul = $(sl).find("ul");
var bl = $(sl).find("li.slider2"+obj);
var step = $(bl).width();
$(ul).animate({marginLeft: "-"+step*obj}, 500);}
$(document).on("click", ".slider2 .nav span", function(){
var sl = $(this).closest(".slider2");
$(sl).find("span").removeClass("on");
$(this).addClass("on");
var obj = $(this).attr("rel");
sliderJS(obj, sl);
return false;
});


// Timer
$(document).ready(function(){
function get_timer(){
	
//Дата для обратного отсчета
var date_new = "August 25,2018 00:00";

var date_t = new Date(date_new);
var date = new Date();
var timer = date_t - date;
if(date_t > date) {
var day = parseInt(timer/(60*60*1000*24));
if(day < 10) {
day = '0' + day;
}
day = day.toString();
var hour = parseInt(timer/(60*60*1000))%24;
if(hour < 10) {
hour = '0' + hour;
}
hour = hour.toString();
var min = parseInt(timer/(1000*60))%60;
if(min < 10) {
min = '0' + min;
}
min = min.toString();
var sec = parseInt(timer/1000)%60;
if(sec < 10) {
sec = '0' + sec;
}
sec = sec.toString();
if(day[1] == 9 && 
hour[0] == 2 && 
hour[1] == 3 && 
min[0] == 5 && 
min[1] == 9 && 
sec[0] == 5 && 
sec[1] == 9) {
animation($("#day0"),day[0]);
}
else {
$("#day0").html(day[0]);
}
if(hour[0] == 2 && 
hour[1] == 3 && 
min[0] == 5 && 
min[1] == 9 && 
sec[0] == 5 && 
sec[1] == 9) {
animation($("#day1"),day[1]);
}
else {
$("#day1").html(day[1]);
}
if(hour[1] == 3 && 
min[0] == 5 && 
min[1] == 9 && 
sec[0] == 5 && 
sec[1] == 9) {
animation($("#hour0"),hour[0]);
}
else {
$("#hour0").html(hour[0]);
}
if(min[0] == 5 && 
min[1] == 9 && 
sec[0] == 5 && 
sec[1] == 9) {
animation($("#hour1"),hour[1]);
}
else {
$("#hour1").html(hour[1]);
}
if(min[1] == 9 && 
sec[0] == 5 && 
sec[1] == 9) {
animation($("#min0"),min[0]);
}
else {
$("#min0").html(min[0]);
}
if(sec[0] == 5 && sec[1] == 9) {
animation($("#min1"),min[1]);
}
else {
$("#min1").html(min[1]);
}
if(sec[1] == 9) {
animation($("#sec0"),sec[0]);
}
else {
$("#sec0").html(sec[0]);
}
animation($("#sec1"),sec[1]);	
setTimeout(get_timer,1000);
}
else {
$("#timer_wrap").html("<div id='stop'>Акция закончена!</div>");
}
}
function animation(vibor,param){
vibor.html(param)
.css({'marginTop':'0px','opacity':'0'})
.animate({'marginTop':'0px','opacity':'1'});
}
get_timer();
});