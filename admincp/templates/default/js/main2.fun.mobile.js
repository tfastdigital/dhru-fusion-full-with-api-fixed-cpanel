var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearInterval(timer); 
    timer = setTimeout(callback, ms);
  };
})();


var valuechanged=false;
$(document).ready(function(){    

    
    reloadstyle();           

    $("body").click(function () {$("#scr_results",parent.document.body).hide();}); 
    document.onkeyup=function(ev) {
       if(ev.which==113){
         redirectedit('pos.sales','Sales');
       } 
    }
      
    $("#closesubpage").click(function () {       
        closeSubpage();
    });

});


 function setoverflowMenu(){    
    var menuWidth=$('#tabmenu').width(); 
    $('#tabmenu').not('#tabmenu.dashboardtab').after('<div id="viewmorelink" class="down">More</div> <div id="overflow"></div>');   
    var fixedWidth=0;
    var overflowDiv='';    
    $('#tabmenu > li').each(function(){       
       fixedWidth = $(this).width() + fixedWidth;       
       
       if(parseInt(fixedWidth) > parseInt(menuWidth)-100){                      
           $('#overflow').append('<li>'+$(this).html()+'</li>');
           $(this).remove();                    
       }             
    }); 
    
    if($('#overflow').find('li').length==0){
        $('#viewmorelink').hide();
    }
    
    $('#overflow li a').click(function(){
      $('#overflow').hide();  
    });
    
    $('#viewmorelink').click(function(){       
       $('#overflow').slideToggle('slow'); 
    }); 
                    
 }


function subdivtoggle(){
    $(".groupstabes h2").click(function () { 
        //$(this).next().slideToggle('fast');
    }); 
}

function SubmitForm (buttonId,page,formId,callbackDivId,loader,loaderDivId,link,ids){
  $(buttonId).attr("disabled", true);
  var tmpval=$(buttonId).val();     
  $(buttonId).val("Please Wait Loading...");
  if(loader){ $(loaderDivId).fadeIn();}  
  $.post('includes/main.save.php?page='+ page +'.save',$(formId).serialize() , function (data, textStatus) {

    if(data){
        $(callbackDivId).removeClass('successbox');
        $(callbackDivId).removeClass('errorbox');
        $(callbackDivId).removeClass('info');        
    }
    var callback_data = data.split(":"); 
  
    if(callback_data[0]=='redirect'){
        $(callbackDivId).addClass('info');
        $(callbackDivId).html('Redirecting - please wait ... <BR /> *If this appears for more than five seconds, <a href="main.php">click here</a> .');
        $(window.location).attr('href', callback_data[1]);
    }
    if(callback_data[0]=='success'){
        $(callbackDivId).addClass('successbox');
        $(callbackDivId).html(callback_data[1]);
    }
//getContect (aId,page,Id,postContent,callbackDivId,loader,loaderDivId,loadconversation){
    
    if(callback_data[0]=='reload'){
        getContect("",link,ids,'','#tabcontent','','','','success',callback_data[1]);
    }   
    if(callback_data[0]=='error'){
        $(callbackDivId).addClass('errorbox');
        $(callbackDivId).html(callback_data[1]);
    } 
    if(callback_data[0]=='debug'){        
        $(callbackDivId).addClass('errorbox');
        $(callbackDivId).html(data);        
    } 
    if(callback_data[0]=='callfunction'){
        redirectedit(callback_data[1],callback_data[2]);
    }     
    if(callback_data[2]){
        var hide_data = callback_data[2].split(","); 
        $.each( hide_data , function(index, value) { 
            $("#hide_"+value).hide(); 
        });
    }
    $('html, body').animate({scrollTop:0}, 'fast');
    $(buttonId).attr("disabled", false); 
    if(loader){ $(loaderDivId).fadeOut();} 
    $(callbackDivId).css({'display':'block'}); 
    $(buttonId).val(tmpval);
  });
  valuechanged=false;  
}

function DeleteItem (deleteItem,page,formId,hideId,callbackDivId,loader,loaderDivId){
  $(callbackDivId).hide();
  if(loader){ $(loaderDivId).fadeIn();}  
  $.post('includes/main.save.php?deleteItem='+ deleteItem +'&page='+ page +'.save',$(formId).serialize() , function (data, textStatus) {
    $(callbackDivId).fadeIn();
    var callback_data = data.split(":");     
    if(callback_data[0]=='redirect'){
        $(callbackDivId).addClass('info');
        $(callbackDivId).html('Redirecting - please wait ... <BR /> *If this appears for more than five seconds, <a href="main.php">click here</a> .');
        $(window.location).attr('href', callback_data[1]);
    }
    if(callback_data[0]=='success'){
        $(callbackDivId).addClass('successbox');
        $(callbackDivId).html(callback_data[1]);
    } 
    if(callback_data[0]=='error'){
        $(callbackDivId).addClass('errorbox');
        $(callbackDivId).html(callback_data[1]);
    }
    if(hideId){$(hideId).fadeOut();}
    if(loader){ $(loaderDivId).fadeOut();} 
     
  });
}

function RestoreDatabase (Item,page,formId,callbackDivId,loader,loaderDivId){
  $(callbackDivId).hide();
  if(loader){ $(loaderDivId).fadeIn();}  
  $.post('includes/main.save.php?Item='+ Item +'&page='+ page +'.save',$(formId).serialize() , function (data, textStatus) {
    $(callbackDivId).fadeIn();


    if(callback_data[0]=='redirect'){
        $(callbackDivId).addClass('info');
        $(callbackDivId).html('Redirecting - please wait ... <BR /> *If this appears for more than five seconds, <a href="main.php">click here</a> .');
        $(window.location).attr('href', callback_data[1]);
    }
    if(callback_data[0]=='success'){
        $(callbackDivId).addClass('successbox');
        $(callbackDivId).html(callback_data[1]);
    } 
    if(callback_data[0]=='error'){
        $(callbackDivId).addClass('errorbox');
        $(callbackDivId).html(callback_data[1]);
    }
    if(loader){ $(loaderDivId).fadeOut();}      
  });
}

function ajaxFileUpload(orderId,fileId,page,callbackDivId,loader,loaderDivId)
	{		   
       $(loaderDivId).ajaxStart(function(){$(this).show();}).ajaxComplete(function(){$(this).hide();});
	   $.ajaxFileUpload({url:'includes/main.save.php?fileId='+ fileId +'&orderId='+ orderId +'&page='+ page +'.save',secureuri:false,dataType: 'json',fileElementId:fileId,success: function (data, status){
	               if(typeof(data.error) != 'undefined')
					{
					    $(callbackDivId).show();
                        $(callbackDivId).addClass('successbox');
                        $(callbackDivId).html(data.msg);					
					}
                    else{
                        $(callbackDivId).show();
                        $(callbackDivId).addClass('errorbox');
                        $(callbackDivId).html(data.error);
                    }
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)           
      }

function scrollToTop(){
    $('html').animate(
    {
        scrollTop: 0
    },300);
    return false;
}

 

function reloadpage(pagename,id){   
     var page='main2.php?page='+ pagename +'&id='+ id;               
     setTimeout(function(){
        $('#subpageiframe2').attr('src',page);        
     });                                                  
}

function reloadcurrent(pagename,id){     
     var page='main2.php?page='+ pagename +'&id='+ id;   
      $('#content_',parent.document).attr('src',page);                                                             
}

function reloadsubpageiframe(pagename,id){         
     var page='main2.php?page='+ pagename +'&id='+ id;                  
     setTimeout(function(){
        $('#subpageiframe',parent.document).attr('src',page);             
     });                                                  
}
            
function redirectedit(pagename,id,tabId)
{   
     
    load_fromsubpage(pagename+id,'');
                           
}

function tabSelection2(aId){          
    $("#tabmenuinner li a").removeClass('tabmenuinner_active');   
   $(aId).addClass('tabmenuinner_active');
}


function load_fromsubpage(page,title){     
    location.href='main2.php?page='+ page;                                                    
}

function inlinePopup(id,title)
{             
    if($('body').find($('#popupiframe')).length==0){
        $('body').append('<div class="popup"><div class="popup-bg"></div><div class="popup-content"><h1>'+title+'</h1> <div id="popupiframe"></div></div></div>');                      
    }
    $('#popupiframe').html($(id).html());
    $('.popup').show(); 
        
    curid=id;
    $(id).html('');                                                  
}
   

function closeEditpage(){
    $('#iframeforedit').html('').css({'display':'none'});
    $('.main2').css({'overflow':'auto'});
}



function redirecteditA(pagename,id,tabId)
{   
     if(tabId){
        tabSelection(tabId);
     }
     location.href='main2.php?page='+ pagename +'&id='+ id;
}
function tabSelection(aId){     
   $("#tabmenu li a,#tabmenuinner li a").removeClass('tabmenu_active');
   $(aId).addClass('tabmenu_active');
}


function getContect (aId,page,Id,postContent,callbackDivId,loader,loaderDivId,loadconversation,clas,msgs){
    
    $('#notification').hide();    
    if(loader){ $(loaderDivId).show(); }
    
    if($(aId).length){
        var position=$(aId).position();
        var width=$(aId).width();
        var height=$(aId).height();
        var left=position.left;
        var top=position.top;        
    }    
 
    $.post(page, {id:Id,data:postContent,isgetcont:true},function (data,  textStatus) {  
       
        $(callbackDivId).html(data);
         if(clas=='error'){
                $("#notification").addClass('errorbox');
                $("#notification").html(msgs);
                $("#notification").show();
            }else if(clas=='success'){
                $("#notification").addClass('successbox');
                $("#notification").html(msgs);
                $("#notification").show();
            } 
        $('.tabloader').remove();        
        if(loadconversation){
            document.getElementById("currenttabid").value = Id;
            loadConversation(Id,true);
        } 
        tabSelection(aId);
        subdivtoggle();                
        if(loader){ $(loaderDivId).hide();}             
        $(callbackDivId).find('input[type="text"]:first').focus();   
        
        //reloadstyle();            
                                         
    }); 
    closeEditpage();    
}


    
function funcKey(e) {
  var code = e.keyCode || e.which;
  if(code==27){
    closeSubpage();
    setTimeout(function(){           
        $("#iframeforedit").hide('fast');
    });
  }
  return false;
}

function closeSubpage(){           
    $("#subpage").css({'left':'130%'});    
}


function get_Contect(aId,page,Id,postContent,callbackDivId,loader,loaderDivId,loadconversation,clas,msgs){
    $('#notification').fadeOut('fast');         
    if(loader){$(loaderDivId).fadeIn();}
    $.post(page, {id:Id,data:postContent,isgetcont:true},function (data,  textStatus) {
        $(callbackDivId).html(data);
        ///////////////////////////        
            if(clas=='error'){
                $("#notification").addClass('errorbox');
                $("#notification").html(msgs);
                $("#notification").show();
            }else if(clas=='success'){
                $("#notification").addClass('successbox');
                $("#notification").html(msgs);
                $("#notification").show();
            } 
        ///////////////////////////        
        if(loadconversation){
            document.getElementById("currenttabid").value = Id;
            loadConversation(Id,true);
        }         
        if(loader){ $(loaderDivId).fadeOut();}
                        
               
            //reloadstyle();
       
    }); 
       
    if($(aId).parent().parent().attr('id')=='tabmenuinner'){
        tabSelection2(aId);
    }
    else if($(aId).parent().parent().attr('id')=='tabmenu'){
        tabSelection(aId);
    }
    subdivtoggle();    
}


function reloadstyle(){ 
          
     callSubmenu();
         
     $('#notification').click(function(){
             $(this).slideUp();
     });        

     if($('#tabmenu .clear').length==0){ 
          $('#tabmenu').append('<div class="clear"></div>');        
     }
    
     $('.adddatarow td input[type="text"]').focus(function(){
        $(this).parent().find('small').addClass('showsmalltag');
     });
     
    
  
    $("table#main_tbl tr:even").addClass("odd");
    $("table#main_tbl tr:odd").addClass("even"); 
                        
     
    $('table#main_tbl th input[type="checkbox"]').click(function(){                 
      if($(this).attr('class')=='check-all'){                                 
          SetAllCheckBoxes(this);                                   
      }                                                        
    });
    
}
 
 
 function SelectChildren(element){
    
    if($("#"+element).is(':checked')){
            $("."+element).attr('checked',true);
       }else{
            $("."+element).attr('checked',false);
       }
       return false; 
}

function apiSync(page,Id,postContent,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).fadeIn();}
    $.post(page, {id:Id,data:postContent},function (data,  textStatus) {
        $(callbackDivId).text(data);
        if(loader){ $(loaderDivId).fadeOut();}  
    });    
}
function zCheckAll(oForm) {
	var oElems = oForm.elements;
	for (var i=0;oElems.length>i;i++) {
  		if (oElems[i].type == "checkbox")
			oElems[i].checked = true;
	}
}
function zUncheckAll(oForm) {
	var oElems = oForm.elements;
	for (var i=0;oElems.length>i;i++) {
  		if (oElems[i].type == "checkbox")
			oElems[i].checked = false;
	}
}

function SetAllCheckBoxes(val)
{       
	if($(val).is(':checked'))
	{
		var array = document.getElementsByTagName("input");
		for(var ii = 0; ii < array.length; ii++)
		{
		   if(array[ii].type == "checkbox")
		   {
				array[ii].checked = true;
		   }
		}
	}
	else
	{
		var array = document.getElementsByTagName("input");
		for(var ii = 0; ii < array.length; ii++)
		{
		   if(array[ii].type == "checkbox")
		   {
				array[ii].checked = false;
		   }
		}
	}
    return false;	
}

function removeIP()
{
	 $('#loading_bg').show();
	$.post("CustomSave.php", $('#removeip').serialize(),
	function(data){
		$("#editedip").html(data);
		$('#loading_bg').hide(); 
			 $('html, body').animate({ scrollTop: 0 }, 'slow');
	});
}

function TranslationText(t,c,l_or,l_res){ 
   $.get("includes/translate_google.php",
         {text:t,
		  lang_orig:l_or,
		  lang_res:l_res},
         function(data){
            if(data == "err"){
                c.attr("value", "error");
               	c.css("color", "red");
               	return false;
            }
            else{
               c.attr("value", data);
               return false;
            }
         }
        );
};


/* IMEI Get Model */
function getModels(bId,serviceId,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).fadeIn();}
    $.post('includes/pages/getModels.php',{bid: bId,serviceid: serviceId}, function (data, success, textStatus) {
        $("#onloadmodelsdropdown").hide();        
        $(callbackDivId).fadeIn();
        $(callbackDivId).html(data);           
        if(loader){ $(loaderDivId).fadeOut();} 
    });
}
function getProvider(cId,serviceId,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).fadeIn();}
    $.post('includes/pages/getProvider.php',{cid: cId,serviceid: serviceId}, function (data, success, textStatus) {
        $("#onloadproviderdropdown").hide();
        $(callbackDivId).fadeIn();
        $(callbackDivId).html(data);           
        if(loader){ $(loaderDivId).fadeOut();} 
    });      
}
function getClients(search,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).fadeIn();}
    $.post('includes/pages/getClients.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlist').show();
        $(callbackDivId).html(data);        
        if(loader){ $(loaderDivId).fadeOut();} 
    });      
}
function MgetOrders(search,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).fadeIn();}
    $.post('includes/pages/m.getIMEIhistory.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlist').show();
        $(callbackDivId).html(data);        
        if(loader){ $(loaderDivId).fadeOut();} 
    });      
}
function MgetSERVER(search,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).fadeIn();}
    $.post('includes/pages/m.getServerhistory.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlists').show();
        $(callbackDivId).html(data);        
        if(loader){ $(loaderDivId).fadeOut();} 
    });      
}
function MgetIMEIOrder(search,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).fadeIn();}
    $.post('includes/pages/m.getIMEIOrder.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
       
        $(callbackDivId).html(data);        
        if(loader){ $(loaderDivId).fadeOut();} 
    });      
}

function mgetServerOrder(search,callbackDivId,loader,loaderDivId){
  if(loader){ $(loaderDivId).fadeIn();}
    $.post('includes/pages/m.getServerOrder.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlist').show();
        $(callbackDivId).html(data);        
        if(loader){ $(loaderDivId).fadeOut();} 
    });           
}
function MgetWaiting(callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).fadeIn();}
    $.post('includes/pages/m.getWaiting.php', function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlist').show();
        $(callbackDivId).html(data);        
        if(loader){ $(loaderDivId).fadeOut();} 
    });      
}
function MgetInvoices(search,callbackDivId,loader,loaderDivId){
  if(loader){ $(loaderDivId).fadeIn(); }
    $.post('includes/pages/m.getInvoice.php',{find: search}, function (data, success, textStatus) { 
        $(callbackDivId).fadeIn();
        $('#userlist').show(); 
        $(callbackDivId).html(data);        
        if(loader){ $(loaderDivId).fadeOut();} 
   });        
}
function MgetOrder(search,callbackDivId,loader,loaderDivId){
  if(loader){ $(loaderDivId).fadeIn();}
    $.post('includes/pages/m.getOrders.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlist').show();
        $(callbackDivId).html(data);        
        if(loader){ $(loaderDivId).fadeOut();} 
   });        
}
function getapiServices(sId,callbackDivId,loader,loaderDivId,servicetype,serverv){

    if(loader){ $(loaderDivId).fadeIn();}
    $.post('includes/pages/getapiServices.php',{sid: sId, servicetype: servicetype,server: serverv}, function (data, success, textStatus) {
        $("#onloadapiservicedropdown").hide();
        $(callbackDivId).fadeIn();
        $(callbackDivId).html(data);           
        if(loader){ $(loaderDivId).fadeOut();} 
    });  
} 

function subheader2_txt(text){ 
    if(text.length>=20){
        text=text.replace(text.substring(20),' ...');
    }

    $("#subheader2_txt", parent.document.body).html(text);
}

$.fn.blink = function(message) {
  $(this).animate({opacity: 0.01}, 200, function() {
    $(this).html(message).show(); $(this).animate({opacity:1}, 200, function() {
      $(this).animate({opacity: 0.1}, 200, function() {
        $(this).animate({opacity: 1}, 200);
      })
    })
  });
}

function load_subpage(link,pagetitle,accesskey) {
    
    var link = link.replace("main2.php?page=", "");  
    load_fromsubpage(link,pagetitle);
    
    /*
    $("#subpage", parent.document.body).fadeIn('fast');        
    $("#subpageheader_txt", parent.document.body).show().html(pagetitle);
    $("#subpageiframe", parent.document.body).attr('src',link);
    */       
}

function load_subpage2(link,pagetitle,accesskey) {    
    $("#subpage2", parent.document.body).show('fast');      
    $("#subpageheader_txt2", parent.document.body).show().html(pagetitle);
    $("#subpageiframe2", parent.document.body).attr('src',link);
}
    
function overAnimation(element,effect,speed,prop){    
    $(element).css({position:'relative',zIndex:'1'});
    $(element).prepend('<span class="animate" style="position:absolute;left:0;right:0;bottom:0;z-index:-9;float:none;'+prop+'"></span>');   
    
    if(effect=='fade'){
       $('.animate').css({'opacity':'0','height':'100%','width':'100%'});
       $(element).hover(function() {        
            $(this).find('.animate').stop().animate({opacity:'1'},speed); 
        }, function() {
            $(this).find('.animate').stop().animate({opacity: "0"},speed);
        });    
    }  
    
    if(effect=='slideLeft'){
       $('.animate').css({'opacity':'0','height':'100%'});
       $(element).hover(function() {        
            $(this).find('.animate').stop().animate({opacity:'1','width':'100%'},speed);
        }, function() {
            $(this).find('.animate').stop().animate({opacity: "0",'width':'0'},speed);
        });    
    } 
    
    if(effect=='slideTop'){
       $('.animate').css({'opacity':'0','width':'100%'});
       $(element).hover(function() {        
            $(this).find('.animate').stop().animate({opacity:'1','height':'100%'},speed);
        }, function() {
            $(this).find('.animate').stop().animate({opacity: "0",'height':'0'},speed);
        });    
    }
    return false;
 }    
 



function popupPage(pagename,id,title)
{          
     var page='main2.php?page='+ pagename +'&id='+ id; 
     if($('body').find('#iframeforpopup').length==0){
        $('body').append('<div id="iframeforpopup"></div>');
     }                       
     $('#iframeforpopup').html('<div class="popup-bg"></div><div class="popup-content"><h1>'+title+'</h1><input type="button" value="X" name="close" class="close-popup" onclick="closePopup()"/><iframe id="popupiframe" src="'+page+'"></iframe></div>').show();
     
     $('#popupiframe').load(function(){        
        $('#popupiframe').contents().find('#tabmenu').addClass('hide-sidebar').hide();
        $('#popupiframe').contents().find('.firstDiv').addClass('hide-sidebar');
    });
                                                  
}

function closePopup(){    
    if($('#tabmenu').find('.tabmenu_active').length==1){
        $('#tabmenu').find('.tabmenu_active').click();            
    }    
    $('#iframeforpopup').html('').hide();
}



function AddnewInpopup(obj){       
    var link=$(obj).attr('data-target');
    var header=$(obj).attr('data-target-header');
   
    $("#subpage", parent.document.body).fadeIn('fast');        
    $("#subpageheader_txt", parent.document.body).show().html(header);
    $("#subpageiframe", parent.document.body).attr('src','main2.php?p=sub&page='+link);
}


function callSubmenu(){
    if($('body').find('#tabmenu').length!=0){            
        $('#tabmenu li').each(function(){                            
            var link=$(this).find('a:first').attr('onclick');
            $(this).find('a').removeAttr('onclick');
            if(link=='undefined'){
                var link=$(this).find('a:first').attr('href');
            }           
            $(this).find('a').attr('href','javascript:'+link);          
        });        
        $('#menu1 ul').append($('#tabmenu').html());                                 
        $('#menu1').mmenu({			 
			counters: true
		});
   }
   else{            
        $('#header').css({'display':'none'});
   }
}