var valuechanged=false;
$(document).ready(function(){

    var root = document.getElementsByTagName( 'html' )[0];
    root.setAttribute( 'class', 'js' );

    //$(".chosen").chosen();

    //overAnimation('#tabmenu li','fade','fast','background-image:-o-linear-gradient(#e5e4e4,#f0efef);background-image:-ms-linear-gradient(#e5e4e4,#f0efef);background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#e5e4e4), color-stop(100%,#f0efef));background-image:-moz-linear-gradient(#e5e4e4,#f0efef);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#e5e4e4,endColorstr=#f0efef,GradientType=0);');

     setTimeout(function(){
            reloadstyle();
     });
     $(document).keyup(function (e) {
         if(e.which == 27){
             $('#closesubpage,.close-popup').click();
             $('#closesubpage',parent.document.body).click();
             $('.close-popup',parent.document.body).click();
         }
     })

/*
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
 	});*/
    $("body").click(function () {$("#scr_results",parent.document.body).hide();});
     document.onkeyup=function(ev) {
        if(ev.which==113){
             redirectedit('pos.sales','Sales');
        }
     }
     $("#closesubpage").click(function () {
        closeSubpage();
     });
    //subdivtoggle();
    //setoverflowMenu();
    //$(window).resize(setoverflowMenu);
    //setformstylefortab();
    $(document).mouseup(function (e)
    {
        var container = $(".header-dropdown",window.parent.document);
        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.hide();
        }
    });


    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
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
function showLoader(){
   $('.c-loader', parent.document.body).show();
}
function hideLoader(){
    $('.c-loader', parent.document.body).hide();
}

function SubmitFormNew(buttonId,page,formId,callbackDivId,loader,loaderDivId,link,ids,clearall)
{

    $(buttonId).attr("disabled", true);
    var tmpval=$(buttonId).val();
    $(buttonId).val("Please Wait Loading...");
    if(loader){ parent.showLoader();}
    var ifhold=false;


    var formData = new FormData($(formId)[0]);
    $(formId+' :input').each(function(){
        if($(this).attr('base64encode'))
        {
            var enc=window.btoa(encodeURIComponent($(this).val().trim()));
            formData.set($(this).attr('name'), enc);
        }
    });

    $.ajax({
        url: 'includes/main.save.php?page='+ page +'.save&ids='+ids,
        type: 'POST',
        data: formData,
        success: function (data) {
            //////////SUCCESS PART//////////
            if(data){
                $(callbackDivId).removeClass('successbox');
                $(callbackDivId).removeClass('errorbox');
                $(callbackDivId).removeClass('info');
            }
            var callback_data = data.split(":");
            callback_data[0]=callback_data[0].trim();
            if(callback_data[0]=='redirect'){
                $(callbackDivId).addClass('info');
                $(callbackDivId).html('Redirecting - please wait ... <BR /> *If this appears for more than five seconds, <a href="main.php">click here</a> .');
                $(window.location).attr('href', callback_data[1]);
            }
            if(callback_data[0]=='success'){
                $(callbackDivId).addClass('successbox');
                $(callbackDivId).html(callback_data[1]);
            }
            if(callback_data[0]=='alert' ){
                console.log(callback_data[1]);
                var reply=confirm(callback_data[1]);
                if(reply){
                    SubmitFormNew(buttonId,page,formId,callbackDivId,loader,loaderDivId,link,9999,clearall);
                }
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
            if(callback_data[0]=='callfunction2'){
                redirecteditA(callback_data[1],callback_data[2]);
            }
            if(callback_data[2]){
                var hide_data = callback_data[2].split(",");
                $.each( hide_data , function(index, value) {
                    try {
                        $("#hide_" + value).hide();
                    }catch(e){}
                });
            }
            $('html, body').animate({scrollTop:0}, 'fast');
            $(buttonId).attr("disabled", false);
            if(loader){ parent.hideLoader();}
            $(callbackDivId).show();
            $(buttonId).val(tmpval);
            if(clearall=='1'){
                $(formId)[0].reset();
            }
            if(!isNaN(parseInt(callback_data[3]))){
                ifhold=true;
            }
//////////////END SUCCESS///////////
        },
        complete: function () {

            if(ifhold){
                setTimeout(function () {
                    $(callbackDivId).hide();
                }, 60000);
            }else {
                setTimeout(function () {
                    $(callbackDivId).hide();
                }, 10000);
            }

        },
        cache: false,
        contentType: false,
        processData: false
    });


}

let cleartimeout;

function SubmitForm (buttonId,page,formId,callbackDivId,loader,loaderDivId,link,ids,clearall){
  $(buttonId).attr("disabled", true);
  var tmpval=$(buttonId).val();
  $(buttonId).val("Please Wait Loading...");
  if(loader){ parent.showLoader();}
  var ifhold=false;
//////////////////////////////

    if(cleartimeout){
        clearTimeout(cleartimeout);
    }

 $.ajax({
      type: "POST",
      url: 'includes/main.save.php?page='+ page +'.save&ids='+ids,
      data: $(formId).serialize(),
      contentType: "application/x-www-form-urlencoded",
      dataType: "text",
      success: function (data) {
console.log(data);
            //////////SUCCESS PART//////////
    if(data){
        $(callbackDivId).removeClass('successbox');
        $(callbackDivId).removeClass('errorbox');
        $(callbackDivId).removeClass('info');
    }
    var callback_data = data.split(":");
    callback_data[0]=callback_data[0].trim();
    if(callback_data[0]=='redirect'){
        $(callbackDivId).addClass('info');
        $(callbackDivId).html('Redirecting - please wait ... <BR /> *If this appears for more than five seconds, <a href="main.php">click here</a> .');
        $(window.location).attr('href', callback_data[1]);
    }




    if(callback_data[0]=='success'){
        $(callbackDivId).addClass('successbox');

        let html = `<div class="toast__container">
        <div class="toast__icon">
             <i class="fa fa-check-circle"></i>
        </div>
        <div class="toast__content">
            <p class="toast__type">Success</p>
            <p class="toast__message">${callback_data[1]}</p>
        </div></div>`;
        $(callbackDivId).html(html);
    }

      if(callback_data[0]=='alert' ){

          var reply=confirm(callback_data[1]);
          if(reply){
              SubmitForm (buttonId,page,formId,callbackDivId,loader,loaderDivId,link,9999,clearall);
          }
      }
        //getContect (aId,page,Id,postContent,callbackDivId,loader,loaderDivId,loadconversation){
    if(callback_data[0]=='reload'){
        getContect("",link,ids,'','#tabcontent','','','','success',callback_data[1]);
    }
          if(callback_data[0]=='selfreload'){
              location.reload();
          }
    if(callback_data[0]=='error'){

        let html = `<div class="toast__container">
        <div class="toast__icon">
             <i class="fa fa-exclamation-circle"></i>
        </div>
        <div class="toast__content">
            <p class="toast__type">Error</p>
            <p class="toast__message">${callback_data[1]}</p>
        </div></div>`;
        $(callbackDivId).addClass('errorbox');
        $(callbackDivId).html(html);
    }
    if(callback_data[0]=='debug'){
        $(callbackDivId).addClass('errorbox');
        $(callbackDivId).html(data);
    }
    if(callback_data[0]=='callfunction'){

        redirectedit(callback_data[1],callback_data[2]);
    }
      if(callback_data[0]=='callfunction2'){
          redirecteditA(callback_data[1],callback_data[2]);
      }
          if(callback_data[0]=='success') {
              if (callback_data[2]) {
                  var hide_data = callback_data[2].split(",");
                  $.each(hide_data, function (index, value) {
                      $("#hide_" + value).hide();
                  });
              }
          }
    $('html, body').animate({scrollTop:0}, 'fast');
    $(buttonId).attr("disabled", false);
    if(loader){ parent.hideLoader();}
    $(callbackDivId).show();
    $(buttonId).val(tmpval);
    if(clearall=='1'){
       $(formId)[0].reset();
    }
      if(!isNaN(parseInt(callback_data[3]))){
            ifhold=true;
      }
//////////////END SUCCESS///////////
      },
      error: function () {

      },
      complete: function () {

         if(ifhold){
             cleartimeout = setTimeout(function () {
                  $(callbackDivId).hide();
              }, 60000);
          }else {
             cleartimeout = setTimeout(function () {
                  $(callbackDivId).hide();
              }, 10000);
          }

      }
    });
  //////////////////////////////

  valuechanged=false;
 }


function DeleteItem (deleteItem,page,formId,hideId,callbackDivId,loader,loaderDivId){
  $(callbackDivId).hide();
  if(loader){ parent.showLoader();}
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
    if(loader){ parent.hideLoader();}

  });
}

function RestoreDatabase (Item,page,formId,callbackDivId,loader,loaderDivId){
  $(callbackDivId).hide();
  if(loader){ parent.showLoader();}
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
    if(loader){ parent.hideLoader();}
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

/*
 $('html').scroll(function() {
 	if ($(this).scrollTop() > 0) {
 		$('#tabmenu').addClass('fixed');
 	} else {
 		$('#tabmenu').removeClass('fixed');
 	}
 });
 */

function reloadpage(pagename,id){
     var page='main2.php?page='+ pagename +'&id='+ id;
     $('#subpageiframe2').attr('src',page);
}

function reloadcurrent(pagename,id){
     var page='main2.php?page='+ pagename +'&id='+ id;
     $('#'+$('body',parent.document).find('.tab-pane.active').attr('id'),parent.document).find('iframe').attr('src',page);
}

function reloadsubpageiframe(pagename,id){
     var page='main2.php?page='+ pagename +'&id='+ id;
     $('#subpageiframe',parent.document).attr('src',page);
}

function redirectedit(pagename,id,title)
{
    id=$.trim(id);
    var link = 'main2.php?page=' + pagename + '&id=' +id+ '&style=subpage';
    if ($(window).width() < 768) {
        var random=Math.floor((Math.random() * 10000) + 1000);
        parent.load_page(link,"View","",random);
    }
    else {
        $("#subpageiframe,#subpageiframe2", parent.document.body).attr('src', link).css({
            'z-index': '999',
            'background': 'white'
        });
        $("#subpageheader_txt", parent.document.body).show().html('View');
        if ($(window).width() < 768) {
            $("#subpage", parent.document.body).css({'left': '0'});
        }
        else {
            $("#subpage", parent.document.body).css({'left': '20%'});
        }
    }
}

function tabSelection2(aId){
   $("#tabmenuinner li a").removeClass('tabmenuinner_active');
   $(aId).addClass('tabmenuinner_active');
}


function load_fromsubpage(page,title){
    parent.load_page(page,title);

   /*
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
      var pageId='t_'+str1+str3;



       var parentBody = window.parent.document.body;
       var currentActiveTab=$('#tabs-group > li.active',parentBody);
       $('#tabContent > .tab-pane.active,#tabs-group > li.active',parentBody).removeClass('active');
       var flag=true;
        var twidth=0;
        $('#tabs-group li',parentBody).each(function(){
           if($('a',this).attr('class')==pageId){
               $(this).addClass('active');
               $('#tabContent #'+pageId,parentBody).addClass('active');
               flag=false;
           }
           twidth=twidth+$(this).width();
       });




       if(twidth+300>=$(parentBody).width()){
           $('.tabs-controlar',parentBody).css({'display':'block'});
       }
       else{
           $('.tabs-controlar',parentBody).css({'display':'none'});
       }

       var page='main2.php?page='+page;
       var titleid = pageId;
      if(flag){
           $('#tabContent',parentBody).prepend('<iframe id="'+titleid+'" src="'+page+'" class="tab-pane active"></iframe>');
           var close='<span class="close-tab" onclick="closeTab(\''+titleid+'\')" title="Close">X</span>';
           var refresh='<span class="refresh-tab" onclick="refreshTab(\''+page+'\',\''+titleid+'\')" title="Refresh"> &orarr; </span>';
           $(currentActiveTab).after('<li class="active"><a href="#'+titleid+'" class='+titleid+' data-toggle="tab">'+close + refresh +title+' </a></li>');
           setRightClick($('#tabs-group li.active',parentBody));


          $('#tabs-group li',parentBody).bind('click',function(){
               $('.tab-pane.active').removeClass('active');
               $(this).addClass('active');
          });

       }
       $("#"+titleid).load(function (){
            $(this).contents().find('input[type="text"]:first,select:first').focus();
       });
   */
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


function getContect (aId,page,Id,postContent,callbackDivId,loader,loaderDivId,loadconversation,clas,msgs,iframe){


    $('#notification').hide();
    if(loader){ parent.showLoader(); }

    try{
        if($(aId).length){
            var position=$(aId).position();
            var width=$(aId).width();
            var height=$(aId).height();
            var left=position.left;
            var top=position.top;

            var template='<div class="tabloader" style="width:'+width+'px;height:'+height+'px;left:'+left+'px;top:'+top+'px;">Loading...</div>';
            // $(aId).parent().append(template);
        }
    }catch(s){
        alert(s);
    }

    if(iframe){
        tabSelection(aId);
        $(callbackDivId).addClass('angularjs').html('<iframe src="'+page+'" id="angularjsiframe"></iframe>');
        $('#angularjsiframe').on('load',function(){
            parent.hideLoader();
            $('.angularjs').css({opacity:1});
        });

    }
    else {

        $.post(page, {id: Id, data: postContent, isgetcont: true}, function (data, textStatus) {

            try {
                $(callbackDivId).html(data);
            } catch (e2) {
                try {
                    // $('#tabcontent').html(data);
                } catch (sf) {
                    //     alert(sf+''+callbackDivId);
                }
            }
            if (clas == 'error') {
                $("#notification").addClass('errorbox');
                $("#notification").html(msgs);
                $("#notification").show();
            } else if (clas == 'success') {
                $("#notification").addClass('successbox');
                $("#notification").html(msgs);
                $("#notification").show();
            }
            try {
                $('.tabloader').remove();
                if (loadconversation) {
                    document.getElementById("currenttabid").value = Id;
                    loadConversation(Id, true);
                }
            } catch (srt) {
                alert(srt + 'e2');
            }
            try {
                tabSelection(aId);
                subdivtoggle();
            } catch (sr) {
                alert(sr + 'e3');
            }
            try {
                if (loader) {
                    parent.hideLoader();
                }
               // $(callbackDivId).find('input[type="text"]:first').focus();
            } catch (sr) {
                alert(sr + 'e4');
            }
            setTimeout(function () {
                reloadstyle();
            });

        });
    }
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
    if(loader){parent.showLoader();}
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
        if(loader){ parent.hideLoader();}

        setTimeout(function(){
            reloadstyle();
        });
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

       $('.chosen').chosen();

     $('#printTbl tbody td:nth-child(1)').html('<h4>'+$('#tabmenu .tabmenu_active').text()+'</h4>');

     $('#notification').click(function(){
             $(this).slideUp();
     });

    if($('#tabmenu li').length<=1){
        $('.firstDiv').addClass('no-tab');
    }
     if($('#tabmenu .clear').length==0){
          $('#tabmenu').append('<div class="clear"></div>');
         /* $('#tabmenu').not('.dashboardtab').replaceWith('<div class="outertabdiv"><ul id="tabmenu">'+$('#tabmenu').html()+'</ul></div>');*/
     }

    //$('table').wrap('<div class="responsive-table"></div>');





   // $('#tabcontent').css({height:$(window).height()});


     $('tr .editdata,tr .deletedata,tr .viewdata').html('');

     //$('.default_dg_table tr th:last-child,.default_dg_table tr td:last-child,#main_tbl tr th:last-child,#main_tbl tr td:last-child').addClass('rightalign');
    //$('.responsive-table .default_dg_table').parent().addClass('responsive-grid');

     $('.adddatarow td input[type="text"]').focus(function(){
        $(this).parent().find('small').addClass('showsmalltag');
     });

     $('.adddatarow td input[type="submit"],.adddatarow td input[type="button"],.adddatarow td .btn').parent().addClass('gridaddbtn');

     $('.adddatarow td input[type="text"]').blur(function(){
        $(this).parent().find('small').removeClass('showsmalltag');
     });


    $('input[type="checkbox"]').not(".onoff,.default-checkbox").each(function(){
           var label=$(this).next().html();
           if($(this).parents('.checkbox').length==0){
               $(this).wrap('<div class="checkbox"><label></label></div>');
               if(label){
                    $(this).after('<i class="helper"></i>'+label);
               }
               else{
                    $(this).after('<i class="helper"></i>');
               }
           }
    });


    $('input[type="radio"]').each(function(){
           var label=$(this).next().html();
           if($(this).parents('.radio').length==0){
               $(this).wrap('<div class="form-radio"><div class="radio"><label></label></div></div>');
               if(label){
                    $(this).after('<i class="helper"></i>'+label);
               }
               else{
                    $(this).after('<i class="helper"></i>');
               }
           }
    });


/*

     $('td.fieldlabel').each(function(){
         if($(this).text().length==0){
             $(this).addClass('no-label');
         }
     });
     $('td.fieldarea').each(function(){
         if($(this).find('input[type="text"],input[type="password"],select,textarea').length==0){
             $(this).addClass('no-input');
         }
     });
 */


    $('select').not(".chosen,#category").each(function(){
        if(!$(this).parent().hasClass('.span-select')){
             $(this).wrap( '<span class="span-select"></span>');
        }
    });




     $("input[id='hs'],input[id='hs1'],input[id='hs2'],input[id='hs3']")
      .iButton({
        change: function ($input){
          if($input.is(":checked")){
             $('.'+$input.attr('id')).show();
          }
          else{
             $('.'+$input.attr('id')).hide();
          }
        }
      })
      .trigger("change");


      $("input[id='hsop']")
      .iButton({
        change: function ($input){
          if($input.is(":checked")){
             $('.'+$input.attr('id')).css({'opacity':1});
          }
          else{
             $('.'+$input.attr('id')).css({'opacity':0})
          }
        }
      })
      .trigger("change");



     if($('#hs').is(':checked')){ $('.hs').show(); } else{ $('.hs').hide(); }
     if($('#hs1').is(':checked')){ $('.hs1').show(); } else{ $('.hs1').hide(); }
     if($('#hs2').is(':checked')){ $('.hs2').show(); } else{ $('.hs2').hide(); }
     if($('#hs3').is(':checked')){ $('.hs3').show(); } else{ $('.hs3').hide(); }
     if($('#hsop').is(':checked')){ $('.hsop').css({'opacity':1}); } else{ $('.hsop').css({'opacity':0}); }


      if($(':checkbox.onoff').length!=0){
         $(":checkbox.onoff").iButton();
      }

   // $("table#main_tbl tr:even").addClass("odd");
   // $("table#main_tbl tr:odd").addClass("even");


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

    if($('#tabmenu').length!=0){
        if($('.imenu').length==0){
            //$('#tabmenu').wrap('<div class="imenu"></div>');
           // $('#tabmenu').before('<span class="togglemenu" onClick="javascript:$(\'#tabmenu\').toggle()">::</span>');
         }
         $('.firstDiv').addClass('firstDiv-right');
    }

    var current;
    $('.alert-update').on('focus',function () {
        current = this.value;
    });
    $('.alert-update').on('blur',function () {
        if(current!=this.value){
            $(this).addClass('updated');
            current='';
        }
    });

    $("table.quicksort").tablesorter();

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    });


}


 var popupdiv='<div class="popup-box"><div class="popup-bg"></div><div class="popup-box-content"><div class="boxcontents"></div> <span onclick="closePopupbox()" class="popup-close">X</span> </div> </div>';

function popupDiv(id){
    if($('body').find('.popup-box').length==0){
        $('body').append(popupdiv);
    }
    $('.popup-box-content .boxcontents').html($(id).html());
    $('.popup-box').show();
}

function closePopupbox(){
   $('.popup-box').hide();
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
    if(loader){ parent.showLoader();}
    $.post(page, {id:Id,data:postContent},function (data,  textStatus) {
        $(callbackDivId).text(data);
        if(loader){ parent.hideLoader();}
    });
}

function serverRequest(action,postContent,btnid,loader){
    var page = 'api/v1/'+action;
    if(loader){ parent.showLoader();}
    var btntext = $(btnid).val();
    $(btnid).val('Please wait...');
    $.post(page, '',function (data,  textStatus) {
        $(btnid).val(btntext);
        if(loader){ parent.hideLoader();}
        $('#notification').addClass('successbox').show().text('Successfull');
        setTimeout(function () {
            $('#notification').hide();
        },1000);
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

          try{
    		 if(array[ii].className.indexOf('dontset') === -1)
             {
    		   if(array[ii].type == "checkbox")
    		   {
    				array[ii].checked = true;
    		   }
             }
         }catch(e){
           // alert(e);
         }
		}
	}
	else
	{
		var array = document.getElementsByTagName("input");
		for(var ii = 0; ii < array.length; ii++)
		{
		 try{
		 	if(array[ii].className.indexOf('dontset') === -1)
            {
    		   if(array[ii].type == "checkbox")
    		   {
    				array[ii].checked = false;
    		   }
            }
        }catch(e){
           // alert(e);
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
    if(loader){ parent.showLoader();}
    $.post('includes/pages/getModels.php',{bid: bId,serviceid: serviceId}, function (data, success, textStatus) {
        $("#onloadmodelsdropdown").hide();
        $(callbackDivId).fadeIn();
        $(callbackDivId).html(data);
        if(loader){ parent.hideLoader();}
    });
}
function getProvider(cId,serviceId,callbackDivId,loader,loaderDivId){
    if(loader){ parent.showLoader();}
    $.post('includes/pages/getProvider.php',{cid: cId,serviceid: serviceId}, function (data, success, textStatus) {
        $("#onloadproviderdropdown").hide();
        $(callbackDivId).fadeIn();
        $(callbackDivId).html(data);
        if(loader){ parent.hideLoader();}
    });
}
function getClients(search,callbackDivId,loader,loaderDivId){
    if(loader){ parent.showLoader();}
    $.post('includes/pages/getClients.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlist').show();
        $(callbackDivId).html(data);
        if(loader){ parent.hideLoader();}
    });
}
function MgetOrders(search,callbackDivId,loader,loaderDivId){
    if(loader){ parent.showLoader();}
    $.post('includes/pages/m.getIMEIhistory.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlist').show();
        $(callbackDivId).html(data);
        if(loader){ parent.hideLoader();}
    });
}
function MgetSERVER(search,callbackDivId,loader,loaderDivId){
    if(loader){ parent.showLoader();}
    $.post('includes/pages/m.getServerhistory.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlists').show();
        $(callbackDivId).html(data);
        if(loader){ parent.hideLoader();}
    });
}
function MgetIMEIOrder(search,callbackDivId,loader,loaderDivId){
    if(loader){ parent.showLoader();}
    $.post('includes/pages/m.getIMEIOrder.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();

        $(callbackDivId).html(data);
        if(loader){ parent.hideLoader();}
    });
}

function mgetServerOrder(search,callbackDivId,loader,loaderDivId){
  if(loader){ parent.showLoader();}
    $.post('includes/pages/m.getServerOrder.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlist').show();
        $(callbackDivId).html(data);
        if(loader){ parent.hideLoader();}
    });
}
function MgetWaiting(callbackDivId,loader,loaderDivId){
    if(loader){ parent.showLoader();}
    $.post('includes/pages/m.getWaiting.php', function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlist').show();
        $(callbackDivId).html(data);
        if(loader){ parent.hideLoader();}
    });
}
function MgetInvoices(search,callbackDivId,loader,loaderDivId){
  if(loader){ parent.showLoader(); }
    $.post('includes/pages/m.getInvoice.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlist').show();
        $(callbackDivId).html(data);
        if(loader){ parent.hideLoader();}
   });
}
function MgetOrder(search,callbackDivId,loader,loaderDivId){
  if(loader){ parent.showLoader();}
    $.post('includes/pages/m.getOrders.php',{find: search}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $('#userlist').show();
        $(callbackDivId).html(data);
        if(loader){ parent.hideLoader();}
   });
}
function getapiServices(sId,callbackDivId,loader,loaderDivId,servicetype,serverv){
    if(loader){ parent.showLoader();}

    $.post('includes/pages/getapiServices.php',{sid: sId, servicetype: servicetype,server:serverv}, function (data, success, textStatus) {
        $("#onloadapiservicedropdown").hide();
        $(callbackDivId).fadeIn();
        $(callbackDivId).html(data);
        if(loader){ parent.hideLoader();}
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

    if ($(window).width() < 768) {
        var random=Math.floor((Math.random() * 10000) + 1000);
        parent.load_page(link,pagetitle,"",random);
    }
    else{
        $("#subpageiframe,#subpageiframe2", parent.document.body).attr('src',link).css({'z-index':'999','background':'white'});
        $("#subpageheader_txt", parent.document.body).show().html(pagetitle);

        if ($(window).width() < 768) {
            $("#subpage", parent.document.body).css({'left':'0'});
        }
        else{
            $("#subpage", parent.document.body).css({'left':'30%'});
        }
        $("#subpageiframe", parent.document.body).contents().find("body").addClass('slide-page');
    }
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



var curid='';
function inlinePopup2(id,title)
{
    if($('body').find($('#popupiframe')).length==0){
        $('body').append('<div class="popup"><div class="popup-bg"></div><div class="popup-content"><h1>'+title+'</h1><input type="button" value="X" name="close" class="close-popup" onclick="closePopup()"/><div id="popupiframe"></div></div></div>');
    }
    $('#popupiframe').html($(id).html());
    $('.popup').show();

    curid=id;
    $(id).html('');
}
function inlinePopup(id,title)
{
    if($('body').find($('#popupiframe')).length==0){
        $('body').append('<div class="popup"><div class="popup-bg"></div><div class="popup-content"><h1>'+title+'</h1><input type="button" value="X" name="close" class="close-popup" onclick="closePopup()"/><div id="popupiframe"></div></div></div>');
    }
    $('#popupiframe').html($(id).html());
    $('.popup').show();

    curid=id;
    $(id).html('');
}



function popupPage(pagename,id,title)
{
    var page = 'main2.php?page=' + pagename + '&id=' + id;
    if ($(window).width() < 768) {
        var random=Math.floor((Math.random() * 10000) + 1000);
        parent.load_page(page,title,"",random);
    }
    else {
        if ($('body').find('#iframeforpopup').length == 0) {
            $('body').append('<div id="iframeforpopup"></div>');
        }
        $('#iframeforpopup').html('<div class="popup-bg"></div><div class="popup-content"><h1>' + title + '</h1><input type="button" value="X" name="close" class="close-popup" onclick="closePopup()"/><iframe id="popupiframe" src="' + page + '"></iframe></div>').show();
    }

}




function closePopup(){
    $(curid).html($('#popupiframe').html());
    $('#popupiframe,#iframeforpopup').html('');
    $('.popup').hide();
    $('#iframeforpopup').hide();
    curid='';
}



function AddnewInpopup(obj,id){
    var page=$(obj).attr('data-target');
    var header=$(obj).attr('data-target-header');
    popupPage(page+'&xid='+id,'',header);
}

function openPopupInline(obj){
    $(obj).show();
}
function closeInlinePopup(obj){
    $(obj).hide();
    $(curid).html($('#popupiframe').html());
    curid='';
}


 function magicline(){
    var click=false;

    if($("#tabmenu").find("#magic-line").length==0 && ($("#tabmenu").length==1)){
        $("#tabmenu").append("<li id='magic-line'></li>");

        var $magicLine = $("#magic-line");
        var active=$("#tabmenu li").find("a.tabmenu_active").parent('li');

        $magicLine
            .width(active.width())
            .css("left", 0)
            .data("origLeft", $magicLine.position().left)
            .data("origWidth", $magicLine.width());

         $("#tabmenu li a").click(function(){
            click=true;
         });

        $("#tabmenu li").find("a").hover(function() {
            $el = $(this);
            leftPos = $el.position().left;
            newWidth = $el.parent().width();
            $magicLine.stop().animate({
                left: leftPos,
                width: newWidth
            });
        }, function() {
            if(!click){
                $magicLine.stop().animate({
                    left: $magicLine.data("origLeft"),
                    width: $magicLine.data("origWidth")
                });
            }
        });
    }
 }
