 $(document).ready(function(){                      
              
      $.fn.jPicker.defaults.images.clientPath='../includes/js/colorpicker/images/';               
                                    
        $('*','.editor').click(function(){
            
           var type='background';                    
           var currentcolor='#ffffff';
           var id= Math.floor((Math.random()*100)+1);
           object = $(this);                     
           
           $('span.jPicker').remove();
           $('*','.editor').removeClass('selectedDiv');
           $(this).addClass('selectedDiv');
                                                      
           rgb=$(this).css('backgroundColor');                    
           if(rgb!='transparent'){
            currentcolor=rgb2hex(rgb);
           }
           
           onselectobject(object,currentcolor,type,id);          
           return false;                                                                                          
        });                                                          
    }); 
    
    function addElement(inside,id){        
        $(inside).prepend('<input type="hidden" name="backgroundColor['+id+']" id="backgroundColor['+id+']"> <input type="hidden" name="fontColor['+id+']" id="fontColor['+id+']"> <input type="hidden" name="cssElements['+id+']" id="cssElements['+id+']">');
        return false;
    }
    
    function getParent(object){        
        var parentEls = object.parents().map(function (){ if(this.className) { return '.'+this.className; } else{ return this.tagName; } }).get().join(",");
        var childEls = '';
        var cssElements; 
        if($(object).attr("id")){ 
            childEls='#'+$(object).attr("id");             
        }
        else if($(object).attr("class")){ 
            var tmp = '[. ]selectedDiv';
            childEls=$(object)[0].tagName+'.'+$(object).attr("class");            
            childEls=childEls.replace('.selectedDiv','');
            childEls=childEls.replace(' selectedDiv','');                        
        }
        else{
            childEls=$(object)[0].tagName;
        }   
                        
        parentEls=childEls+','+parentEls;                           
        var elements=parentEls.split(',');
                      
        for($i=elements.length-1;$i>=0;$i--){        
            elements[$i]=elements[$i].replace(' ','.');             
            cssElements+=elements[$i]+' ';                                   
        }
        cssElements=cssElements.replace('undefinedHTML BODY FORM .editor','');
        return cssElements;                                
    }
    
    function onselectobject(object,currentcolor,type,id){
              
       if(!$(object).find('input[id*="backgroundColor"]').length){
            addElement(object,id);                       
       }
       else{
          var pattern = /[0-9]+/g;
          tmp=$(object).children(":first").attr('id'); 
          var matches = tmp.match(pattern); 
          id= matches;                           
       }  
       var cssElements=getParent(object);                       
                    
        $('.colorpicker').jPicker({window:{expandable: true},color:{alphaSupport: true,active: new $.jPicker.Color({ ahex:currentcolor})}},
        function(color, context,object){},
            function(color, context)
            {               
                if (context == $('.colorpicker').get(0)) alert('Color set from button');
                var hex = color.val('hex');
                if(type=='background'){        
                    $(cssElements).css({backgroundColor: hex && '#' + hex || 'transparent'});
                    document.getElementById('backgroundColor['+id+']').value = hex;                     
                }
                else{
                    object.css({color: hex && '#' + hex || 'transparent'});
                    document.getElementById('fontColor['+id+']').value = hex;                                                             
                }
                document.getElementById('cssElements['+id+']').value = cssElements;                                                                     
            });             
            return false;                                                                
    }
    
    
   
    function rgb2hex(rgbString) {
                
        var parts = rgbString.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);                
        delete (parts[0]);
        for (var i = 1; i <= 3; ++i) {
            parts[i] = parseInt(parts[i]).toString(16);
            if (parts[i].length == 1) parts[i] = '0' + parts[i];
        } 
        var hexString ='#'+parts.join('').toUpperCase();
        return hexString;
    }