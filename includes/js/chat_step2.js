$(document).ready(function(){
           
    $('[data-toggle="tooltip"]').tooltip();  
    
     
    setInterval(function(){
        var id=$("#chatid").val();
        $.post('includes/loadchat.php?id='+id, function (data, textStatus) {
            $("#conversation").append(data);
            if(data!=''){                                     
                $('.box-cell').scrollTop($('.box-cell').prop("scrollHeight"));          
            }
        });
    },1000); 
    $('#message').keypress(function(event) {
        if (event.which == '13') {
             SubmitForm();
             event.preventDefault();   
             $('#message').focus();          
        }        
    });    
    window.onbeforeunload = closeIt;
});

function closeIt()
{     
    return "This page is asking you to confirm that you want to leave - data you have entered may not be saved.";
}

function SubmitForm (){
  $("#message").val( ((($.trim(document.getElementById("message").value)).replace(/%/g,'%25')).replace(/\+/g,'%2b')) );
  if(document.getElementById("message").value!=""){
      $("#send").attr("disabled", true);
      $.post( "includes/sendChat.php" , $("#frmchat").serialize(), function (data, textStatus) {
           $("#message").val("");
           $("#send").attr("disabled", false);
      });
  }
}
