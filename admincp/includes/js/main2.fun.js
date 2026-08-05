/***********************************
<!-- (c) Dhru.com @2012 - -->
***********************************/

var valuechanged=false;
$(document).ready(function(){

    overAnimation('#tabmenu li','fade','fast','background-image:-o-linear-gradient(#e5e4e4,#f0efef);background-image:-ms-linear-gradient(#e5e4e4,#f0efef);background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#e5e4e4), color-stop(100%,#f0efef));background-image:-moz-linear-gradient(#e5e4e4,#f0efef);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#e5e4e4,endColorstr=#f0efef,GradientType=0);');

    reloadstyle();
   	$('#getgoogle').live("click",function(){
		var t = $(this).closest('td').prev("td").prev("td").find("input").attr("value");
		var c = $(this).closest('td').prev("td").find("input");
		var l_or = $("input[name='lang']").attr("orig");
		var l_res = $("input[name='lang']").attr("trans");
		TranslationText(t,c,l_or,l_res);
		return false;
	});

   	$('#tall').live("click",function(){
   	    $("#main_loader").show();
        $("#main_tbl tbody").children().nextAll('tr').each( function() {

            var t = $(this).find("input").attr("value");
            var c = $(this).children('td').next().find("input");
            var l_or = $("input[name='lang']").attr("orig");
            var l_res = $("input[name='lang']").attr("trans");
            //alert(c);
            TranslationText(t,c,l_or,l_res);
        });
        $("#main_loader").hide();

	});
    $("body").click(function () {$("#scr_results",parent.document.body).hide();});
    document.onkeyup=function(ev) {
       if(ev.which==113){
         redirectedit('pos.sales','Sales [F2]');
       }
    }

    //subdivtoggle();
    //setoverflowMenu();

    //$(window).resize(setoverflowMenu);
    //setformstylefortab();
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

function setformstylefortab(){

    $(".form tr td").each(function()
    {
        var t = $(this);
        var n = t.next();
        if(n.html()!='Null' && n.html()!='null'){
            t.html('<div class="fieldlabel">'+ t.html() + '</div><div class="fieldarea">'+ n.html()+'</div>');
        }
        n.remove();
    });
}

function subdivtoggle(){
    $(".groupstabes h2").click(function () {
        //$(this).next().slideToggle('fast');
    });
}
function SubmitForm (buttonId,page,formId,callbackDivId,loader,loaderDivId,link,ids){
  $(buttonId).attr("disabled", true);
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
    callback_data[0]=callback_data[0].trim();


    if(callback_data[0]=='reload'){

        getContect("",link,ids,'','#tabcontent','','','','success',callback_data[1]);
    }
      if(callback_data[0]=='selfreload'){
          location.reload();
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
  });
  valuechanged=false;
}





function DeleteItem (deleteItem,page,formId,hideId,callbackDivId,loader,loaderDivId){
  $(callbackDivId).hide();
  if(loader){ $(loaderDivId).fadeIn();}
  $.post('includes/main.save.php?deleteItem='+ deleteItem +'&page='+ page +'.save',$(formId).serialize() , function (data, textStatus) {
    $(callbackDivId).fadeIn();
    var callback_data = data.split(":");
    //alert(callback_data);
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

function redirectedit(pagename,id,tabId)
{
    if(tabId){
        tabSelection(tabId);
    }

     location.href='main2.php?page='+ pagename +'&id='+ id;
}

function tabSelection(aId){
    $("#tabmenu li a").removeClass('tabmenu_active');
   $(aId).addClass('tabmenu_active');
}

function tabSelection2(aId){
    $("#tabmenuinner li a").removeClass('tabmenuinner_active');
   $(aId).addClass('tabmenuinner_active');
}

function getContect (aId,page,Id,postContent,callbackDivId,loader,loaderDivId,loadconversation,clas,msgs){

    var flager=1;
    if(valuechanged==true){
        valuechanged=false;
        var cnt=0;
        var flags=0;
 $("input:button").each(function(){
    var input = $(this).attr('onclick');
    if(input.indexOf('SubmitForm') != -1){
        cnt++;
    }
});
if(cnt>1){
     new Messi('Some changes you made but forgot to save, please click "Ok" and save your settings.', {title: 'Forgot to save changes?', buttons: [{id: 0, label: 'Ok', val: 'Save' , btnClass: 'btnSave'}, {id: 1, label: 'Do not save', val: 'No', btnClass: 'btnCancel'}],
            callback: function(val) {
                if(val=='No'){
                    get_Contect(aId,page,Id,postContent,callbackDivId,loader,loaderDivId,loadconversation,clas,msgs);
                }
                if(val=='Save'){
                }
            }});

}   else {
      if(cnt!=0){
        new Messi('Some changes you made but forgot to save, you want to save now ?', {title: 'Forgot to save changes?', buttons: [{id: 0, label: 'Save', val: 'Save' , btnClass: 'btnSave'}, {id: 1, label: 'Do not save', val: 'No', btnClass: 'btnCancel'}],
            callback: function(val) {
                if(val=='No'){
                    get_Contect(aId,page,Id,postContent,callbackDivId,loader,loaderDivId,loadconversation,clas,msgs);
                }
                if(val=='Save'){
                    if(flags==0){
                        $("input:button").each(function(){
                            var input = $(this).attr('onclick');
                            if(input.indexOf('SubmitForm') != -1){
                                input = $(this).attr('id');
                                $('#'+input).trigger('click');
                                val='';
                                flags=1;
                                return false;
                            }
                        });
                   }

                }
            }});
     }
}
    }else{
         get_Contect(aId,page,Id,postContent,callbackDivId,loader,loaderDivId,loadconversation,clas,msgs);
    }
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

        if($('.flexcroll').length!=0){
            fleXenv.initByClass("flexcroll");
            fleXenv.updateScrollBars();
        }
        reloadstyle();
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

     $('#notification').click(function(){
             $(this).slideUp();
     });

    $('[data-toggle="tooltip"]').tooltip()

     if($('#tabmenu .clear').length==0){
          $('#tabmenu').append('<div class="clear"></div>');
         /* $('#tabmenu').not('.dashboardtab').replaceWith('<div class="outertabdiv"><ul id="tabmenu">'+$('#tabmenu').html()+'</ul></div>');*/
     }


      overAnimation('.quicklink li','fade','fast','background-color:#f4f4f4;border-bottom:#ccc solid 1px');

    $('.quicklink li a').hover(function(){
        $(this).append('<span style="position:absolute;right:15px" class="raquo">&raquo;</span>');
        $('.raquo').stop().animate({'right':'5px'});
    },function(){
        $('.raquo').remove();
    });

    $('tr .editdata,tr .deletedata,tr .viewdata').html('');

     $('.default_dg_table th:last-child,.default_dg_table tr td:last-child,#main_tbl th:last-child,#main_tbl tr td:last-child').addClass('rightalign');

     $('.adddatarow td input[type="text"]').focus(function(){
        $(this).parent().find('small').addClass('showsmalltag');
     });

     $('.adddatarow td input[type="submit"],.adddatarow td input[type="button"],.adddatarow td .btn').parent().addClass('gridaddbtn');

     $('.adddatarow td input[type="text"]').blur(function(){
        $(this).parent().find('small').removeClass('showsmalltag');
     });

   if($(':checkbox.onoff').length!=0){
        $(":checkbox.onoff").iButton();
   }

    $("table#main_tbl tr:even").addClass("odd");
     $("table#main_tbl tr:odd").addClass("even");


  //   setCheckbox();

      $('table#main_tbl th input[type="checkbox"]').click(function(){
                  if($(this).attr('class')=='check-all'){
                      SetAllCheckBoxes(this);
                  }
           });


    $("input[type='text'],textarea").not("#frmFiltering input[type='text']").keyup(function() {
          valuechanged=true;
    });
    $("input[type='checkbox'],input[type='radio'],.ibutton-container").click(function() {
          valuechanged=true;
    });
     $("select").not("#frmFiltering select").change(function() {
          valuechanged=true;
    });


    $(".toggle_container").hide();
	$(".triggertab").click(function(){
		$(this).parent().find('.toggle_container').slideToggle();
	});

    $('select.customfield').change(function(){

        $(this).parent().parent().find('.encfun').hide();
       if($(this).val()=='dropdown' || $(this).val()=='radio'){
            $(this).parent().parent().find('.fieldoptions').removeAttr("disabled");
            $(this).parent().parent().find('.regexpr').attr('disabled','disabled');
            $(this).parent().parent().find('.fieldoptionimg').show();

       }
       else if($(this).val()=='text' || $(this).val()=='textarea'){
            $(this).parent().parent().find('.fieldoptions').attr('disabled','disabled');
            $(this).parent().parent().find('.regexpr').removeAttr("disabled");
            $(this).parent().parent().find('.fieldoptionimg').hide();
            $(this).parent().parent().find('.encfun').show();
       }
       else{
           $(this).parent().parent().find('.fieldoptions').attr('disabled','disabled');
           $(this).parent().parent().find('.regexpr').attr('disabled','disabled');
           $(this).parent().parent().find('.fieldoptionimg').hide();
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
function getapiServices(sId,callbackDivId,loader,loaderDivId,servicetype){

    if(loader){ $(loaderDivId).fadeIn();}
    $.post('includes/pages/getapiServices.php',{sid: sId, servicetype: servicetype}, function (data, success, textStatus) {
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

function load_pageinContent(link,divid)
{
    $(divid).src(link,function(duration){

    });
}

function load_subpage(link,pagetitle,accesskey) {
    //$("#status").show().html("Loading " + pagetitle + " ...");
    $("#subpage", parent.document.body).fadeIn('fast');
    try{
    $("#subpageheader_txt", parent.document.body).show().html("Loading " + pagetitle + " ...");
    }catch(e)
    { }
    $("#subpageiframe", parent.document.body).src(link,function(duration){
			//$("#status").blink("Loaded in " + Math.round((duration/6000)*100)/100 + " second");
			$("#subpageheader_txt", parent.document.body).blink(pagetitle);
      	},{
			timeout: $("#timeout").val(),
			onTimeout: function() { $("#subpageheader_txt", parent.document.body).blink("Timed out!"); }
      	}
    );
}

function load_subpage2(link,pagetitle,accesskey) {
    //$("#status").show().html("Loading " + pagetitle + " ...");
    $("#subpage2", parent.document.body).show('fast');
    $("#subpageheader_txt2", parent.document.body).show().html("Loading " + pagetitle + " ...");
    $("#subpageiframe2", parent.document.body).src(link,function(duration){
			//$("#status").blink("Loaded in " + Math.round((duration/6000)*100)/100 + " second");
			$("#subpageheader_txt2", parent.document.body).blink(pagetitle);
      	},{
			timeout: $("#timeout").val(),
			onTimeout: function() { $("#subpageheader_txt2", parent.document.body).blink("Timed out!"); }
      	}
    );
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

