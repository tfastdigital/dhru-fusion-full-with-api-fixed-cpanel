$(document).ready(function(){ 
            
    $('.income li').hover(function(){       
       var classes=$(this).attr('id');       
        $('.income li').stop().animate({'opacity':'0.3'}); 
        $(this).stop().animate({'opacity':'1'}); 
       if($('h2').hasClass('view')){            
         $('.view').removeClass('view');   
       }                    
       $('.'+classes).addClass('view'); 
    },function(){        
         $('.income li').stop().animate({'opacity':'1'});             
    });  
    

     $('.quicklink a,.ticket a,.todo a').hover(function(){        
         $(this).append('<span style="position:absolute;right:15px" class="raquo">&raquo;</span>');
         $('.raquo').stop().animate({'right':'5px'});
     },function(){
         $('.raquo').remove();
     });

    
    $('.waitingticket').hover(function(){              
        $('.waitingticket').stop().animate({'opacity':'0.3'}); 
        $(this).stop().animate({'opacity':'1'});        
    },function(){        
         $('.waitingticket').stop().animate({'opacity':'1'});             
    }); 
        
    $('table tr:odd').addClass('odd'); 
    
    //overAnimation('.todo li','slideTop','fast','background-color:#f4f4f4;');
    //overAnimation('.quicklink li','slideLeft','slow','background-color:gray;');
    //overAnimation('.dashboardtab li','slideLeft','fast','background-color:#eee;');              
    
});


function showHid(v){    
    if(v=='today'){        
        document.getElementById('yestered').style.display='none';
        document.getElementById('today').style.display='';
    }else{         
        document.getElementById('yestered').style.display='';
        document.getElementById('today').style.display='none';
    }
} 


 
