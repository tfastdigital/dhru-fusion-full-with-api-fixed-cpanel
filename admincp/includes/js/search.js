$(document).ready(function(){

    var timerID= null;
    var fl=1;



	$("#intellisearchval").keyup(function (e) {
        if((e.which>=65 && e.which<=90) || (e.which>=48 && e.which<=57) || (e.which>=96 && e.which<=105) || e.which==32 || e.which==8){
    	    $("#scr_results").hide();
        }

       if((e.which>=65 && e.which<=90) || (e.which>=48 && e.which<=57) || (e.which>=96 && e.which<=105) || e.which==32 || e.which==8){
           var intellisearchlength = $("#intellisearchval").val().length;

    		if (intellisearchlength>2) {
    		   if (timerID) {
                    clearTimeout(timerID);
                }
    		   timerID = setTimeout(function(){
              if(fl==1){
                  fl=1;
                   load_page('search2&value='+$("#intellisearchval").val(),' &telrec; '+$("#intellisearchval").val(),'','67895432');
                   }
               },400);
    		}
        }



         if(e.which==40 || e.which==38 || e.which==13){
             switch (e.which)
             {
                 case 40: { keyEvents($('.resultcontent'),'next');break; }
                 case 38: { keyEvents($('.resultcontent'),'prev');break; }
                 case 13: {
                       $('.resultcontent').find("div.scr_result").each(function(){
                            var val=$(this).attr("class");
                            val=val.trim();
                            console.log('asdf');
                            if(val == "scr_result selected"){
                                   var vls=$(this).find("a").attr("href");
                                   vls=vls.replace("javascript:load_page('","");
                                   vls=vls.split("','");
                                   load_page(vls[0],vls[1],'');

                                   $("#scr_results").hide();
                            }
                       });
                 }
             }
        }

	});


	$("#intellisearchvaltab_btn").click(function (e) {
           var intellisearchlength = $("#intellisearchvaltab").val().length;
    		if (intellisearchlength>2) {
    		  if (timerID) {
                    clearTimeout(timerID);
                }
        	   timerID = setTimeout(function(){
            		$.post("includes/autosuggest/search.php", { intellisearch: "true", value: $("#intellisearchvaltab").val() },
            		  function(data){
                			$("#scr_results").html(data);
                			$("#scr_results").slideDown("slow");
        		  });
                },500);
    		}
	});

	$("#scr_cancel").click(function () {
		$("#intellisearchval,#intellisearchvaltab").val("");
		$("#scr_results").slideToggle();
	});


   $("body").click(function (event) {
		//$("#intellisearchval").val("");
        if($(event.target).attr('class')!='quickreply')
        {
		  $("#scr_results").hide();
        }
	});

  });

function searchdata(){
    if($("#intellisearchval").val()){
        load_page('search2&value='+$("#intellisearchval").val(),' &telrec; '+$("#intellisearchval").val(),'','67895432');
    }
}

function ReplyIMEI(oid,mid){
    var reply=$("#fastreply").val();
    var savetoken=$("#save_token").val();

    if(reply){
          $.post('includes/main.save.php?page=edituser.editimeiordersuccess.save',
          {save_token: savetoken,id:oid,md5id:mid,replycode:reply},
    		  function(data){
var callback_data = data.split(":");
if(callback_data[0]=='success'){
    $("#intellisearchval").val("");
   alert('Order replied');
}else{
   alert(callback_data[1]);
}
    	      });
    }else{
        alert('Reply field should not blank');
    }
}
function keyEvents (fieldChild,action)
{
            yx = 0;
            fieldChild.find("div.scr_result").each(function(){
                var val=$(this).attr("class");
                val=val.trim();
                if(val == "scr_result selected")
                yx = 1;
            });
            if(yx == 1)
            {
                var sel = fieldChild.find("div[class='scr_result selected']");
                if(action=='next'){
                    if(sel.next().attr("class")=="scr_resultheader"){
                        sel.next().next().addClass("selected");
                    }else{
                        sel.next().addClass("selected");
                    }
                }else{
                    if(sel.prev().attr("class")=="scr_resultheader"){
                       if(sel.prev().prev().attr("class")==undefined){
                            sel.prev().prev().prev().addClass("selected");
                       }else{
                            sel.prev().prev().addClass("selected");
                       }
                    }else{
                        sel.prev().addClass("selected");
                    }
                }
                //(action=='next') ? sel.next().addClass("selected") : sel.prev().addClass("selected");
                sel.removeClass("selected");
            }
            else{
                (action=='next') ? fieldChild.find("div.scr_result:first").addClass("selected") : fieldChild.find("div.scr_result:last").addClass("selected");
            }
}
function toggleadvsearch() {
	if (document.getElementById('searchbox').style.visibility=="hidden") {
		document.getElementById('searchbox').style.visibility="";
	} else {
		document.getElementById('searchbox').style.visibility="hidden";
	}
}
