/***********************************
<!-- (c) Dhru.com @2012 - -->
***********************************/
$(function() {
  $("body").keypress(function(ev) {
    if (ev.which==13) $("#load").click();
  });
   $("#load").click();
   if(!getUrlVars()["pageurl"]){
        load_page('home', 'Dashboard','','1010',`<i   class="fa fa-tachometer" style="font-size: 24px"></i>`,true);
   }
   $("#closesubpage").click(function () {
        closeSubpage();
   });
   $('body').bind("keypress", function(e) {
      window.parent.funcKey(e);
   });
   //$('#intellisearchval').focus();


    $(document).mouseup(function (e)
    {
        var container = $(".header-dropdown");
        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.hide();
        }
    });

    $('.back-title').click(function () {
        console.log(this)

    });




});

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}


function funcKey(e) {
  var code = e.keyCode || e.which;
  if(code==27){
    closeSubpage();
    setTimeout(function(){
        $("#iframeforedit").hide();
    });
  }



  return false;
}


function closeSubpage(){
    $("#subpage").css({'left':'130%'});
    $('#subpageiframe').attr('src','');

}

////////////////////////////////////

$.fn.blink = function(message) {
  $(this).animate({opacity: 0.01}, 200, function() {
    $(this).html(message).show(); $(this).animate({opacity:1}, 200, function() {
      $(this).animate({opacity: 0.1}, 200, function() {
        $(this).animate({opacity: 1}, 200);
      })
    })
  });
}
function load_page1(pagename,pagetitle,accesskey) {
    $("#status").show().html("Loading " + pagetitle + " ...");
    $("#subheader_txt").show().html("Loading " + pagetitle + " ...");
    $("#subheader2_txt").html('');
    $("#content_").src("main2.php?page=" + pagename + "&accesskey=" + accesskey + "&pagetitle="  ,
		function(duration)
		{
			$("#status").blink("Loaded in " + Math.round((duration/6000)*100)/100 + " second");
			$("#subheader_txt").blink(pagetitle);
      	},{
			timeout: $("#timeout").val(),
			onTimeout: function() { $("#subheader_txt").blink("Timed out!"); }
      	}
    );
}

function load_page(page,title,tokan,randamId,icon,showicon=false) {

    if (!randamId) {
        var str;
        str = page.replace(".", '-');
        str = str.replace(".", '-');
        str = str.replace(".php", '');
        str = str.split("&");
        var str1 = str[0];
        var str3 = '';
        if (str[1]) {
            var str2 = str[1].split("=");
            str3 = str2[1]
        }
        var randamId = 't_' + str1 + str3;
    }

    if (randamId == "67895432") {
        $('.t_67895432 .tab-title').html('<span class="tab-search-icon"> &telrec; </span>' + $("#intellisearchval").val());
    }


    var $tabactive = $('#tabs-group > li a.active');
    $('#tabContent > .tab-pane.active,#tabs-group > li a.active').removeClass('active');
    var flag = true;
    var twidth = 0;
    $('#tabs-group li').each(function () {
        if ($('a', this).hasClass('t_' + randamId)) {
            $('a', this).addClass('active');
            $('#tabContent #t_' + randamId).addClass('active show');
            flag = false;
        }
        twidth = twidth + $(this).width();
    });

    if ((twidth + 300 >= $(window).width())) {
        $('.tab-ctrl').css({'opacity': '1'});
    }
    else {
        $('.tab-ctrl').css({'opacity': '0'});
    }







    if(page.indexOf('main2.php?page=') == -1){
        if(page.indexOf("dist/#/")==-1){
            var page = 'main2.php?page=' + page;
        }
    }

    var titleid = 't_' + randamId;

    showLoader();

    if (flag) {
        $('#tabContent').prepend('<div class="tab-pane h-100 fade show active" id="' + titleid + '" role="tabpanel" aria-labelledby="profile-tab"> <iframe ></iframe></div>');
        $('iframe', "#" + titleid).attr("src", page);
        var close = '<span class="close-tab" onclick="closeTab(\'' + titleid + '\')" title="Close"><span>&times;</span></span>';
        var refresh = '<span class="refresh-tab" onclick="refreshTab(\'' + page + '\',\'' + titleid + '\')" title="Refresh"> <i class="flaticon-reload"></i> </span>';
        $('#tabs-group').append('<li class="nav-items"><a  class="nav-link active pl-4 pr-4 pt-3 pb-3 text-white ' + titleid + '"  title="Double click to refresh" ondblclick="refreshTab(\'' + page + '\',\'' + titleid + '\')" href="#' + titleid + '"  data-toggle="tab"  >' + close + refresh + '<span class="tab-title">' + (showicon?icon:title) + '</span> </a></li>');
        $('#tabs-group  .close').css({'display': 'block'});
        setRightClick('#tabs-group li a.active');
    }
    else {
        hideLoader();
        if ($('a', $tabactive).hasClass('t_' + randamId) || randamId == "67895432") {
            refreshTab(page, titleid);
        }
    }

    $('iframe', "#" + titleid).on('load', function () {
        $(this).contents().find('input[type="text"]:first').focus();
        hideLoader();
    });

    if ($(window).width() < 768) {
        $('.mobile-screen.open-sidebar').removeClass('open-sidebar');
    }


    $('#tabs-group').animate({
        scrollLeft: $(".tabs-container .nav-items .active").offset().left
    }, 'slow');
}

function refreshTab(pagename,titleid){
    showLoader()
    $('iframe','#'+titleid).attr('src',pagename);
    //hideLoader();
}

function closeCurrent(){
    $('.nav.tabs-container  li a.active .close-tab').click();
}

function showLoader(){
   $('.c-loader').show();
}

function hideLoader(){
    $('.c-loader').hide();
}

function closeTab(tabtitle){
    if($('#tabs-group li').length==1){
        return false;
    }


    var current=$('#tabs-group li a[href="#'+tabtitle+'"]').parent().next();
    if($('#tabs-group li:last a').hasClass(tabtitle)){
      current=$('#tabs-group li a[href="#'+tabtitle+'"]').parent().prev();
    }

    $('#tabContent #'+tabtitle).remove();
    $('#tabs-group li a[href="#'+tabtitle+'"]').parent().remove();

    $('a',current).click();

    if($('#tabs-group li').length==1){
      $('.tab-ctrl,.tab-close').css({'display':'none'});
    }
}


function load_link(page,title) {
    $('#tabContent > .tab-pane.active,#tabs-group > li a.active').removeClass('active');
    var flag=true;
    $('#tabs-group li').each(function(){
        if($('a',this).text().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '')==title.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '')){
            $(this).addClass('active');
            $('#tabContent #'+title.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '')).addClass('active');
            flag=false;
        }
    });
   if(flag){
        var titleid = title.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
        $('#tabContent').prepend('<iframe id="'+titleid+'" src="'+page+'" class="tab-pane active"></iframe>');
         var close='<span class="close-tab" onclick="closeTab(\''+titleid+'\')" title="Close">X</span>';
        var refresh='<span class="refresh-tab" onclick="refreshTab(\''+page+'\',\''+titleid+'\')" title="Refresh"> <i class="flaticon-reload"></i>  </span>';
        $('#tabs-group').append('<li class="active"><a title="Double click to refresh" class="nav-link active pl-4 pr-4 pt-3 pb-3 text-white" ondblclick="refreshTab(\''+page+'\',\''+titleid+'\')" href="#'+titleid+'" data-toggle="tab">'+close + refresh +title+' </a></li>');
        $('#tabs-group  .close').css({'display':'block'});
    }
}


function load_directpage(link,pagetitle,accesskey) {
    //$("#status").show().html("Loading " + pagetitle + " ...");
    $("#subpage", parent.document.body).show('fast');
    $("#subpageheader_txt", parent.document.body).show().html("Loading " + pagetitle + " ...");
    $("#subpageiframe", parent.document.body).src(link,function(duration){
			//$("#status").blink("Loaded in " + Math.round((duration/6000)*100)/100 + " second");
			$("#subpageheader_txt", parent.document.body).blink(pagetitle);
      	},{
			timeout: $("#timeout").val(),
			onTimeout: function() { $("#subpageheader_txt", parent.document.body).blink("Timed out!"); }
      	}
    );
}

function load_recent_menu (){
    $.post('includes/pages/recentmenu.php',function (data,  textStatus) {
        $('#recentmenu').html(data);
        //$("#recentmenu").slideToggle();//
    });
    //$('#recentmenu').slideUp();
}


function slideleftin(element,width){
    if(width=='fullwidth'){
        width=$('#tabs-group').width()-200;
    }
    $(element).blindLeftIn(width);
}

function slideleftout(element,width){
    if(width=='fullwidth'){
        width=$('#tabs-group').width()-200;
    }
    $(element).blindLeftOut(width);
}
function sliderightin(element,width){
    if(width=='fullwidth'){
        width=$('#tabs-group').width()-200;
    }
    $(element).blindRightIn(width);
}

function sliderightout(element,width){
    if(width=='fullwidth'){
        width=$('#tabs-group').width()-200;
    }
    $(element).blindRightOut(width);
}




function scrolltoLeft(obj){
    event.preventDefault();
    $(obj).animate({
        scrollLeft: "-=200px"
    }, "fast");
}
function scrolltoRight(obj){
    event.preventDefault();
    $(obj).animate({
        scrollLeft: "+=200px"
    }, "fast");
}



