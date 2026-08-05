 $(document).ready(
    function()
    {
      $.fn.jPicker.defaults.images.clientPath='includes/images/';
      
        var bodyBackground = $('.bodyBackground');
        bodyBackgroundButton = $('#bodyBackground'); 
        
        var naviBackground = $('#dolphinnav');
        naviBackgroundButton = $('#naviBackground');
        
        var breadBackground = $('#dolphincontainer,.current');
        breadBackgroundButton = $('#breadBackground');
        
        var contentBackground = $('#main_body');
        contentBackgroundButton = $('#contentBackground');
            
        var footerBackground = $('#foot');
        footerBackgroundButton = $('#footerBackground');  
        
         var cartBackground = $('#shoppingcart');
        cartBackgroundButton = $('#cartBackground');               
             
             
             
                        
        var bodyFont = $('span,a,#logo_right,#logo_left');
        bodyFontButton = $('#bodyFont'); 
        
        var naviFont = $('#dolphinnav a,#dolphinnav span');
        naviFontButton = $('#naviFont');
        
        var breadFont = $('#_nav span,.current span,#_nav a');
        breadFontButton = $('#breadFont');
        
        var contentFont = $('#content_left h1,#content_left a,#content_left p,#content_left span,#right_menu h1,#right_menu a,#right_menu p,#right_menu span');
        contentFontButton = $('#contentFont');
            
        var footerFont = $('#foot span');
        footerFontButton = $('#footerFont'); 
        
        var cartFont = $('#shoppingcart');
        cartFontButton = $('#cartFont'); 
        
        
      $('#bodyBackground').jPicker(
        {window:{expandable: true}},
        function(color, context){},
        function(color, context)
        {
          if (context == bodyBackgroundButton.get(0)) alert('Color set from button');
          var hex = color.val('hex');
          bodyBackground.css(
            {
              backgroundColor: hex && '#' + hex || 'transparent'              
            }); 
            document.getElementById("bb").value = hex;          
        }
        );
        
        $('#naviBackground').jPicker(
        {window:{expandable: true}},
        function(color, context){},
        function(color, context)
        {
          if (context == naviBackgroundButton.get(0)) alert('Color set from button');
          var hex = color.val('hex');
          naviBackground.css(
            {
              backgroundColor: hex && '#' + hex || 'transparent'
            });
            document.getElementById("nb").value = hex;
        }
        );
        
         $('#breadBackground').jPicker(
        {window:{expandable: true}},
        function(color, context){},
        function(color, context)
        {
          if (context == breadBackgroundButton.get(0)) alert('Color set from button');
          var hex = color.val('hex');
          breadBackground.css(
            {
              backgroundColor: hex && '#' + hex || 'transparent'
            });
            document.getElementById("brb").value = hex;
        }
        );
        
        $('#contentBackground').jPicker(
        {window:{expandable: true}},
        function(color, context){},
        function(color, context)
        {
          if (context == contentBackgroundButton.get(0)) alert('Color set from button');
          var hex = color.val('hex');
          contentBackground.css(
            {
              backgroundColor: hex && '#' + hex || 'transparent'
            });
            document.getElementById("cb").value = hex;
        }
        );
                       
        
        $('#footerBackground').jPicker(
        {window:{expandable: true}},
        function(color, context){},
        function(color, context)
        {
          if (context == footerBackgroundButton.get(0)) alert('Color set from button');
          var hex = color.val('hex');
          footerBackground.css(
            {
              backgroundColor: hex && '#' + hex || 'transparent'
            });
            document.getElementById("fb").value = hex;
        }
        );
        
        $('#cartBackground').jPicker(
        {window:{expandable: true}},
        function(color, context){},
        function(color, context)
        {
          if (context == cartBackgroundButton.get(0)) alert('Color set from button');
          var hex = color.val('hex');
          cartBackground.css(
            {
              backgroundColor: hex && '#' + hex || 'transparent'
            });
            document.getElementById("vcb").value = hex;
        }
        );
        
        
        
        
        
        $('#bodyFont').jPicker(
        {window:{expandable: true}},
        function(color, context){},
        function(color, context)
        {
          if (context == bodyFontButton.get(0)) alert('Color set from button');
          var hex = color.val('hex');
          bodyFont.css(
            {
              color: hex && '#' + hex || 'transparent'              
            }); 
            document.getElementById("bf").value = hex;          
        }
        );
        
        $('#naviFont').jPicker(
        {window:{expandable: true}},
        function(color, context){},
        function(color, context)
        {
          if (context == naviFontButton.get(0)) alert('Color set from button');
          var hex = color.val('hex');
          naviFont.css(
            {
              color: hex && '#' + hex || 'transparent'
            });
            document.getElementById("nf").value = hex;
        }
        );
        
         $('#breadFont').jPicker(
        {window:{expandable: true}},
        function(color, context){},
        function(color, context)
        {
          if (context == breadFontButton.get(0)) alert('Color set from button');
          var hex = color.val('hex');
          breadFont.css(
            {
              color: hex && '#' + hex || 'transparent'
            });
            document.getElementById("brf").value = hex;
        }
        );
        
        $('#contentFont').jPicker(
        {window:{expandable: true}},
        function(color, context){},
        function(color, context)
        {
          if (context == contentFontButton.get(0)) alert('Color set from button');
          var hex = color.val('hex');
          contentFont.css(
            {
              color: hex && '#' + hex || 'transparent'
            });
            document.getElementById("cf").value = hex;
        }
        );
                       
        
        $('#footerFont').jPicker(
        {window:{expandable: true}},
        function(color, context){},
        function(color, context)
        {
          if (context == footerFontButton.get(0)) alert('Color set from button');
          var hex = color.val('hex');
          footerFont.css(
            {
              color: hex && '#' + hex || 'transparent'
            });
            document.getElementById("ff").value = hex;
        }
        );
        
        $('#cartFont').jPicker(
        {window:{expandable: true}},
        function(color, context){},
        function(color, context)
        {
          if (context == cartFontButton.get(0)) alert('Color set from button');
          var hex = color.val('hex');
          cartFont.css(
            {
              color: hex && '#' + hex || 'transparent'
            });
            document.getElementById("vcf").value = hex;
        }
        );
 
    });