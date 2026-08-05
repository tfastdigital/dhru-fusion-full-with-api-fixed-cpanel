/***********************************
<!-- (c) Dhru.com @2012 - -->
***********************************/
$(function() {
  $("body").keypress(function(ev) {   
    if (ev.which==13) $("#load").click();
  });
  $("#load").click();
  $("#closesubpage").click(function () { $("#subpage").hide('fast'); });
});
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
function load_page(pagename,pagetitle,accesskey) {
   
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

function load_link(link,pagetitle) {
    $("#status").show().html("Loading " + pagetitle + " ...");
    $("#subheader_txt").show().html("Loading " + pagetitle + " ...");
    $("#subheader2_txt").html('');
    $("#content_").src(link , function(duration){
			$("#status").blink("Loaded in " + Math.round((duration/6000)*100)/100 + " second");
			$("#subheader_txt").blink(pagetitle);
      	},{
			timeout: $("#timeout").val(),
			onTimeout: function() { $("#subheader_txt").blink("Timed out!"); }
      	}
    );
}
function load_directpage(link,pagetitle,accesskey) {
    if(!pagetitle){
        pagetitle='Edit';
    }    
    //$("#status").show().html("Loading " + pagetitle + " ...");
    $("#subpage", parent.document.body).show('fast');
    $("#subpageheader_txt", parent.document.body).show().html("Loading " + pagetitle + " ...");
    $("#subpageiframe", parent.document.body).src(link,function(duration){		
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