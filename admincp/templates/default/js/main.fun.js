/***********************************
<!-- (c) Dhru.com @2012 - -->
***********************************/
$(function() {
  $("body").keypress(function(ev) {       
    if (ev.which==13) $("#load").click();
  });
   $("#load").click();
   if(!getUrlVars()["pageurl"]){
        load_page('home','Dashboard','','1010');  
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


   
});

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

$(window).load(function(){            
    jQuery.fn.blindLeftOut = function (width,duration, easing, complete) {        
        return this.animate({
            marginLeft: -width
        }, jQuery.speed(duration, easing, complete));
    };
    
    jQuery.fn.blindRightIn = function (width,duration, easing, complete) {
        return this.animate({
            marginLeft: 0
        }, jQuery.speed(duration, easing, complete));
    };
    
    jQuery.fn.blindLeftIn = function (width,duration, easing, complete) {        
        return this.animate({
            marginLeft: 0
        }, jQuery.speed(duration, easing, complete));
    };
    jQuery.fn.blindRightOut = function (width,duration, easing, complete) {
        return this.animate({
            marginLeft: width
        }, jQuery.speed(duration, easing, complete));
    };
    
});


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

function load_page(page,title,tokan,randamId){

    if(!randamId){
         var str;   
       str= page.replace(".",'-');     
       str= str.replace(".php",'');
       str= str.split("&");
       var str1=str[0];
       var str3='';
       if(str[1]){
        var str2=str[1].split("=");
        str3=str2[1]
       }
       var randamId='t_'+str1+str3;
    }
    
    if(randamId=="67895432"){
        $('.t_67895432 .tab-title').html('<span class="tab-search-icon"> &telrec; </span>'+$("#intellisearchval").val());
    }
     
    
    var $tabactive=$('#tabs-group > li.active');        
    $('#tabContent > .tab-pane.active,#tabs-group > li.active').removeClass('active');
    var flag=true;    
    var twidth=0;
    $('#tabs-group li').each(function(){         
        if($('a',this).attr('class')=='t_'+randamId){              
            $(this).addClass('active');
            $('#tabContent #t_'+randamId).addClass('active');      
            flag=false;                                 
        }               
        twidth=twidth+$(this).width();  
    });   
    
    if((twidth+300>=$(window).width())){        
        $('.tab-ctrl').css({'display':'block'});
    }
    else{
        $('.tab-ctrl').css({'display':'none'});
    }
        
     
    
    var page='main2.php?page='+page;        
      
    var titleid = 't_'+randamId;
    
  showLoader();
   if(flag){

        $('#tabContent').prepend('<iframe id="'+titleid+'" class="tab-pane active"></iframe>');                  
        $("#"+titleid).attr("src",page);                                                                                                               
        var close='<span class="close-tab" onclick="closeTab(\''+titleid+'\')" title="Close">X</span>';
        var refresh='<span class="refresh-tab" onclick="refreshTab(\''+page+'\',\''+titleid+'\')" title="Refresh"> <i class="flaticon-reload"></i> </span>';           
        $('#tabs-group').append('<li class="active"><a title="Double click to refresh" ondblclick="refreshTab(\''+page+'\',\''+titleid+'\')" class='+titleid+' href="#'+titleid+'" data-toggle="tab">'+close + refresh +'<span class="tab-title">'+title+'</span> </a></li>');                                                                   
        $('#tabs-group  .close').css({'display':'block'});  
        setRightClick('#tabs-group li.active');      
    }
    else{
        hideLoader();
        if($('a',$tabactive).attr('class')=='t_'+randamId || randamId=="67895432"){            
            refreshTab(page,titleid);             
        }                                   
    }
    
      
    $("#"+titleid).load(function (){        
         $(this).contents().find('input[type="text"]:first').focus();         
         hideLoader(); 
    });
                                        
}

function refreshTab(pagename,titleid){
    $('#'+titleid).attr('src',pagename); 
    hideLoader();   
}

function closeCurrent(){
    $('.nav.nav-tabs li.active a .close-tab').click();
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
    if($('#tabs-group li:last a').attr('class')==tabtitle){      
      current=$('#tabs-group li a[href="#'+tabtitle+'"]').parent().prev();
    }
                                            
    $('#tabContent #'+tabtitle).remove();
    $('#tabs-group li a[href="#'+tabtitle+'"]').parent().remove();
        
    if(!$('#tabs-group li').hasClass('active')){        
        $(current).addClass('active');        
        $('#tabContent #'+$('a',current).attr('class')).addClass('active');    
    }
                                   
    if($('#tabs-group li').length==1){        
        $('.tab-ctrl,.tab-close').css({'display':'none'});
    }           
}


function load_link(page,title) {        
    $('#tabContent > .tab-pane.active,#tabs-group > li.active').removeClass('active');
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
        $('#tabs-group').append('<li class="active"><a title="Double click to refresh" ondblclick="refreshTab(\''+page+'\',\''+titleid+'\')" href="#'+titleid+'" data-toggle="tab">'+close + refresh +title+' </a></li>');                                                                 
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