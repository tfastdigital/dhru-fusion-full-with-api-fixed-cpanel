ready();
function ready(){
    alert('ready');
    $("body").find("script").remove().end().wrapInner('<form method="post" name="frmaddadmin" id="frmaddadmin"></form>');
    $('body').css({marginTop:'35px'});
    $('.editor').slideDown('slow');

    $('.editorcontent h2').append("<span class=arrow style=float:right;font-size:12px>+</span>");
    $('.editorcontent h2:first span').addClass('minus').text('-');
    $('.editorcontent h2:first').addClass('h2open');

    $('.listtemplate').click(function(){
       $(this).toggleClass('open');
       $('ul',this).slideToggle('fast');
    });


    $('.closeall').click(function(){
        if(!$('.elementSelect').is(':hidden')){
            $('.elementSelect,.horizontaltap,.verticaltap').css({display:'none'});
        }
        if(!$('.tagname').is(':hidden')){
            $('.tagname').css({display:'none'});
        }
        document.getElementById('seteditor').value = '0';
        $('.editorcontent,.horizontaltap,.verticaltap').fadeOut('fast');
        return false;

    });

    $('.activeeditor').click(function(){
        activeElements();
        document.getElementById('seteditor').value = '1';
        $('.editorcontent').fadeIn('fast');
        return false;
    });

    return false;
}

function getParent(object){
        var parentEls = object.parents().map(function (){
                var ids='';
                var cls='';

                if($(this).attr('id')){ ids='#'+$(this).attr('id'); }
                if(this.className) {
                    var classes = $(this).attr("class");
                    classes=classes.replace(/\s/g,'.');
                    classes=classes.replace('..','.');
                    classes=classes.replace('..','.');
                    classes=classes.replace('.selectedDiv','');
                    classes=classes.replace('.hover','');
                    cls='.'+classes;
                }

                tag=this.tagName;
                if(tag!='BODY' && tag!='FORM'){
                    tag+=ids+cls;
                }
                return tag;

            }).get().join(",");

        var childEls = '';
        var cssElements;

        tag=$(object)[0].tagName;
        if($(object).attr("id")){
            childEls="#"+$(object).attr("id");

            tag+=childEls;
        }
         if($(object).attr("class")){
            var classes = $(object).attr("class");
            classes=classes.replace(/\s/g,'.');
            classes=classes.replace('..','.');
            classes=classes.replace('..','.');
            childEls='.'+classes;
            childEls=childEls.replace('.selectedDiv','');
            tag+=childEls;
        }
        tag=tag.replace('.hover','');

        parentEls=tag+','+parentEls;
        var elements=parentEls.split(',');

        for($i=elements.length-1;$i>=0;$i--){
            elements[$i]=elements[$i].replace(' ','.');
            cssElements+=elements[$i]+' ';
        }
        cssElements=cssElements.split('undefinedHTML BODY FORM');
        return $.trim(cssElements[1]);
    }


function addElements(inside,prop,value){
        var pattern = /[0-9]+/g;
        var id='';

        if(prop=='textShadow'){
            document.getElementById(prop).value=document.getElementById('colorShadow').value+' '+document.getElementById('hShadow').value+' '+document.getElementById('vShadow').value+' '+document.getElementById('blurShadow').value;
        }
        else if(prop=='boxShadow'){
            document.getElementById(prop).value=document.getElementById('bcolorShadow').value+' '+document.getElementById('bhShadow').value+' '+document.getElementById('bvShadow').value+' '+document.getElementById('bblurShadow').value;
        }

        $('input[id*="cssElements"]').each(function(){
            if($(this).val().search(inside)>=0){
                var tmp=$(this).attr('id');
                var id = tmp.match(pattern);
                if($('input[id*="_'+prop+'['+id+']"]').length<=0){
                    if(value=='undefined'){
                       $('#frmaddadmin').prepend('<input type="hidden" name="_'+prop+'['+id+']" id="_'+prop+'['+id+']" value="'+document.getElementById(prop).value+'"/>');
                    }
                    else{
                        $('#frmaddadmin').prepend('<input type="hidden" name="_'+prop+'['+id+']" id="_'+prop+'['+id+']" value="'+document.getElementById(value).value+'"/>');
                    }
                }
                else{
                    if(value=='undefined'){
                       document.getElementById('_'+prop+'['+id+']').value=document.getElementById(prop).value;
                    }
                    else{
                        document.getElementById('_'+prop+'['+id+']').value=document.getElementById(value).value;
                    }
                }
                if($('#hover').is(':checked')){
                    inside=inside+':hover';
                    document.getElementById('cssElements['+id+']').value=inside;
                }
                return false;
            }
        });

      return false;
}

function applypx(object){
    if($(object).attr('class').search('textShadow')>=0 || $(object).attr('class').search('boxShadow')>=0 || $(object).attr('class').search('px')>=0){
        if($(object).val()=='auto' || $(object).val()==''){
            return;
        }
        if($(object).val().search(/px/i)=='-1'){
            var pattern = /[0-9]+/g;
            var matches = $(object).val().match(pattern);
            $(object).val(matches+'px');
        }
    }
    return;
}

function selectElement(){
    var width=$('.selectedDiv').outerWidth()+40;
    var height=$('.selectedDiv').outerHeight()+40;

    var position=$('.selectedDiv').offset();
    if($(window).width()<=$('.selectedDiv').outerWidth() && $(window).height()<=$('.selectedDiv').outerHeight()){
        return false;
    }
    $('.elementSelect').css({width:width+'px',height:height+'px',left:position.left+'px',top:position.top+'px',display:'block'});

    var object=$('.selectedDiv');
    tag=$(object)[0].tagName;
        if($(object).attr("id")){
            childEls="#"+$(object).attr("id");
            tag+=childEls;
        }
        if($(object).attr("class")){
            var classes = $(object).attr("class");
            classes=classes.replace(/\s/g,'.');
            classes=classes.replace('..','.');
            classes=classes.replace('..','.');
            childEls='.'+classes;
            childEls=childEls.replace('.selectedDiv','');
            tag+=childEls;
        }
        tag=tag.replace('.hover','');
        $('#tag').text(tag);
}

(function($){
    $.fn.getStyleObject = function(){
        var dom = this.get(0);
        var style='';
        var returns = {};
        if(window.getComputedStyle){
            var camelize = function(a,b){
                return b.toUpperCase();
            };
            style = window.getComputedStyle(dom,null);
            for(var i = 0, l = style.length; i < l; i++){
                var prop = style[i];
                var camel = prop.replace(/\-([a-z])/g, camelize);
                var val = style.getPropertyValue(prop);
                returns[camel] = val;
            };
            return returns;
        };
        if(style = dom.currentStyle){
            for(var prop in style){
                returns[prop] = style[prop];
            };
            return returns;
        };
        return this.css();
    }
})(jQuery);


$.fn.copyCSS = function(source){
  var styles = $(source).getStyleObject();
  for(var key in styles){
        if ($('#'+key).length ) {
             var domEl = $('#'+key).get(0);
            if(domEl.tagName=='INPUT'){
                document.getElementById(key).value=styles[key];
            }
            else{
                $('#'+key).val(styles[key]);
            }
        }
  }

  $('#backgroundColor').css('backgroundColor',styles['backgroundColor']);
  $('#color').css('backgroundColor',styles['color']);
  $('.editorcontent').css('backgroundColor','#3C97FF');

  if(styles['borderTopWidth']!='0px'){ $('#borderTopColor').css('backgroundColor',styles['borderTopColor']); } else{ $('#borderTopColor').css('backgroundColor','none');}
  if(styles['borderRightWidth']!='0px'){ $('#borderRightColor').css('backgroundColor',styles['borderRightColor']);} else{ $('#borderRightColor').css('backgroundColor','none');}
  if(styles['borderBottomWidth']!='0px'){ $('#borderBottomColor').css('backgroundColor',styles['borderBottomColor']);} else{ $('#borderBottomColor').css('backgroundColor','none');}
  if(styles['borderLeftWidth']!='0px'){ $('#borderLeftColor').css('backgroundColor',styles['borderLeftColor']);} else{ $('#borderLeftColor').css('backgroundColor','none');}

  $('#gradientFrom').css('backgroundColor',styles['backgroundColor']);
  $('#gradientTo').css('backgroundColor',styles['backgroundColor']);


  if(styles['textShadow']){
      var textshadow=styles['textShadow'].replace(/, /g,',').split(/\s/);
      if(textshadow[1]){$('#hShadow').val(textshadow[1]);}else{$('#hShadow').val('0px');}
      if(textshadow[2]){$('#vShadow').val(textshadow[2]);}else{$('#vShadow').val('0px');}
      if(textshadow[3]){$('#blurShadow').val(textshadow[3]);}else{$('#blurShadow').val('0px');}
      if(textshadow[0]){$('#colorShadow').val(textshadow[0]);}else{$('#colorShadow').val('transparent');}
  }
  if(styles['boxShadow']){
      var boxshadow=styles['boxShadow'].replace(/, /g,',').split(/\s/);
      if(boxshadow[1]){$('#bhShadow').val(boxshadow[1]);}else{$('#bhShadow').val('0px');}
      if(boxshadow[2]){$('#bvShadow').val(boxshadow[2]);}else{$('#bvShadow').val('0px');}
      if(boxshadow[3]){$('#bblurShadow').val(boxshadow[3]);}else{$('#bblurShadow').val('0px');}
      if(boxshadow[0]){$('#boxShadow').val(boxshadow[0]);}else{$('#boxShadow').val('transparent');}
  }
  return false;
}


function gradientEffect(object,from,to){
    var css='-webkit-gradient(linear,left top,left bottom,color-stop(0%,'+from+'), color-stop(100%,'+to+'));filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='+from+',endColorstr='+to+',GradientType=0);background-image:-ms-linear-gradient('+from+','+to+');background-image:-moz-linear-gradient('+from+','+to+');background-image:-o-linear-gradient('+from+','+to+')';
    $(object).css({backgroundImage:'-moz-linear-gradient(center top ,'+from+','+to+')'});
    $(object).css({backgroundImage:'-webkit-gradient(linear, left top, left bottom, from('+from+'), to('+to+'));'});
    $(object).css({filter:'progid:DXImageTransform.Microsoft.gradient(startColorstr='+from+', endColorstr='+to+');'});
    document.getElementById('backgroundImage').value=css;
}

function conformation(action){
    if(action=='reset'){
        var r=confirm("Are You sure to reset template design?");
        if (r==true)
        {
            SubmitForm('#reset','includes/getdata/editor.reset.php','#frmaddadmin','#notification10','true','#loader');
        }
    }
    if(action=='undo'){
        var r=confirm("Undo Previous Save changes not Current changes, Are You sure to undo template design?");
        if (r==true)
        {
            SubmitForm('#undo','includes/getdata/editor.undo.php','#frmaddadmin','#notification10','true','#loader');
        }
    }
}



function getEditor(){
   var active=(document.getElementById('seteditor').value=='1')? '1':'0';
    if(active=='0'){
        return false;
    }
    else{
        return true;
    }
}


function getBorderColor(){
    var element=$('.borders div#active').get(0).className;
    if(element=='borderTop'){ element='borderTopColor';}
    else if(element=='borderRight'){ element='borderRightColor';}
    else if(element=='borderBottom'){ element='borderBottomColor';}
    else if(element=='borderLeft'){ element='borderLeftColor';}
    else{element='borderColor';}
    return element;
}
function getBorderWidth(){
    var element=$('.borders div#active').get(0).className;
    if(element=='borderTop'){ element='borderTopWidth';}
    else if(element=='borderRight'){ element='borderRightWidth';}
    else if(element=='borderBottom'){ element='borderBottomWidth';}
    else if(element=='borderLeft'){ element='borderLeftWidth';}
    else{element='borderWidth';}
    return element;
}
function getBorderStyle(){
    var element=$('.borders div#active').get(0).className;
    if(element=='borderTop'){ element='borderTopStyle';}
    else if(element=='borderRight'){ element='borderRightStyle';}
    else if(element=='borderBottom'){ element='borderBottomStyle';}
    else if(element=='borderLeft'){ element='borderLeftStyle';}
    else{element='borderStyle';}
    return element;
}
function getBorderRadius(){
    var element=$('.borderrds div#active').get(0).className;
    if(element=='borderTopLeftRadius'){ element='borderTopLeftRadius';}
    else if(element=='borderTopRightRadius'){ element='borderTopRightRadius';}
    else if(element=='borderBottomRightRadius'){ element='borderBottomRightRadius';}
    else if(element=='borderBottomLeftRadius'){ element='borderBottomLeftRadius';}
    else{element='borderRadius';}
    return element;
}
function dragElement(object){
    $(object).draggable(
    {
        handle:'.mainpanel',
        accept:'',
        revert: 'valid',
        snap:true,
        distance:10,
        scroll: false,
        drag: function(){
            var position=$(this).position();
            var left=position.left;
            var top=position.top;
            if(left<0 || left==10){
                $(this).css({left:'0px'});
                return false;
            }
            if(top<0 || top==10){
                $(this).css({top:'0px'});
                return false;
            }
        }
    });
    closeTap();
}

function closeTap(){
    $('.tapclose').click(function(){
        $(this).parent().fadeOut('fast');
    });
}

function activeElements(){
    $('.editorcontent h2').click(function(){
       $('.open').removeClass('open').fadeOut('fast');
       $('.h2open').removeClass('h2open');
       $(this).addClass('h2open');
       $('.editorcontent .minus').removeClass('minus');
       $('span',this).addClass('minus');
       $('.editorcontent .arrow').text('+');
       $('.editorcontent .minus').text('-');
       $(this).next().addClass('open').fadeIn('fast');
    });

	dragElement(".horizontaltap,.editorcontent,.verticaltap");

    $('.addhorizontal').click(function(){
        $('<div class="horizontaltap">'+$('.horizontaltap').html()+'</div>').prependTo(".admineditor").css({top:'300px',display:'block'});
        dragElement('.horizontaltap');
        return false;
    });

    $('.addvertical').click(function(){
        $('<div class="verticaltap">'+$('.verticaltap').html()+'</div>').prependTo(".admineditor").css({left:'300px',display:'block'});
        dragElement('.verticaltap');
        return false;
    });


    $('.positionPicker .ball').draggable(
    {
        containment:'.positionPicker',
        scroll:false,
        drag: function(){
            var position = $(this).position();
            $('#bhShadow').val(position.left+'px');
            $('#bvShadow').val(position.top+'px');
            var parents=getParent($('.selectedDiv'));
            $(parents).css('boxShadow',document.getElementById('bcolorShadow').value+' '+document.getElementById('bhShadow').value+' '+document.getElementById('bvShadow').value+' '+document.getElementById('bblurShadow').value);
            addElements(parents,'boxShadow','undefined');
        },
        stop:function(){
            getHoverElement();
        }
    });

    $('.textpositionPicker .ball').draggable(
    {
        containment:'.textpositionPicker',
        scroll:false,
        drag: function(){
            var position = $(this).position();
            $('#hShadow').val(position.left+'px');
            $('#vShadow').val(position.top+'px');
            var parents=getParent($('.selectedDiv'));
            $(parents).css('textShadow',document.getElementById('colorShadow').value+' '+document.getElementById('hShadow').value+' '+document.getElementById('vShadow').value+' '+document.getElementById('blurShadow').value);
            addElements(parents,'textShadow','undefined');
        }
    });

    $('.opacity .ball').draggable(
    {
        containment:'.opacity',
        axis: "x",
        scroll:false,
        drag: function(){
            var position = $(this).position();
            $('#opacity').val(position.left/100);
            var parents=getParent($('.selectedDiv'));
            $(parents).css('opacity',document.getElementById('opacity').value);
            addElements(parents,'opacity','undefined');
        }
    });

   /*
     $('#tinyEditor').de77_wysiwyg();


          $( "#catalog li" ).draggable({
    			appendTo: "body",
    			helper: "clone"
    		});

    		$( "#tinyEditor,#tinyEditor *" ).droppable({
    		   greedy: true,
    			drop: function( event, ui ) {
    				$( "<span></span>" ).html( ui.draggable.html()).prependTo( this );
                    $('#tinyEditor .dropImg').remove();
    			}
    		});


    $('#tabcontent *,#tabcontent').dblclick(function(){
        $(this).de77_wysiwyg();
       return false;
    });


    */


    $('#visible').click(function(){
       if($('.elementSelect').css('display')=='none'){
            alert('Please Select Element by OnMouseOver Display any Element');
            return false;
        }
       $('.selectedDiv').children().each(function(){
            if($(this).css('display')=='none'){
                $(this).addClass('tmpDisplay').css({'display':'block'});
                return false;
            }
       });
       $('.selectedDiv').next().each(function(){
            if($(this).css('display')=='none'){
                $(this).addClass('tmpDisplay').css({'display':'block'});
                return false;
            }
       });
       $('.selectedDiv').parent().next().each(function(){
            if($(this).css('display')=='none'){
                $(this).addClass('tmpDisplay').css({'display':'block'});
                return false;
            }
       });
    });

    $('*').click(function(e) {
        if ($(e.target).is('.editor,.editor *,.colorpicker_submit,.colorpicker,.colorpicker *,undefined,#copyright,#copyright *,#frmaddadmin')) {
            return;
        }
        if(getEditor()){
               var parents=getParent($(this));
               var id= Math.floor((Math.random()*100)+1);
               var flag='no';
               $('.selectedDiv').removeClass('selectedDiv');
               $(this).addClass('selectedDiv');
               $("input").copyCSS(parents);

                $('#frmaddadmin input[id*="cssElements"]').each(function(){
                    if($(this).val()==parents){ flag='yes'; return false;}
                });
               if(flag=='no'){
                    $('#frmaddadmin').prepend('<input type="hidden" name="cssElements['+id+']" id="cssElements['+id+']" value="'+parents+'">');
               }
               if(parents.search('tmpDisplay')<0){
                    $('.tmpDisplay').css({'display':'none'});
                    $('.tmpDisplay').removeClass('tmpDisplay');
               }
               selectElement();
               return false;
        }
    });



    $('.borders div').click(function(){
       $('.borders div').attr('id','');
       $(this).attr('id','active');
    });

    $('.borderrds div').click(function(){
       $('.borderrds div').attr('id','');
       $(this).attr('id','active');
    });


    $('.editorcontent select,.editorcontent input[type="text"]').change(function(){
        if($('*:not(.editor *)').find('.selectedDiv').length){
             if($(this).attr('type')=='text'){
                applypx(this);
             }
             var selectedvalue=$(this).val();
             var prop=$(this).attr('name');
             var border='undefined';

             if(($(this).attr('class')=='textShadow') || ($(this).attr('class')=='boxShadow'))
             {
                prop=$(this).attr('class');
                 if(prop=='textShadow'){
                     selectedvalue=document.getElementById('colorShadow').value+' '+document.getElementById('hShadow').value+' '+document.getElementById('vShadow').value+' '+document.getElementById('blurShadow').value;
                 }
                 else if(prop=='boxShadow'){
                     selectedvalue=document.getElementById('bcolorShadow').value+' '+document.getElementById('bhShadow').value+' '+document.getElementById('bvShadow').value+' '+document.getElementById('bblurShadow').value;
                 }
             }

             if(prop=='borderStyle'){
                var border=getBorderStyle();
             }
             else if(prop=='borderWidth'){
                var border=getBorderWidth();
             }
             else if(prop=='borderColor'){
                var border=getBorderColor();
             }
             else if(prop=='borderRadius'){
                var border=getBorderRadius();
             }

             var parents=getParent($('.selectedDiv'));
             if(border=='undefined'){$(parents).css(''+prop+'',selectedvalue); addElements(parents,prop,'undefined');}
             else{$(parents).css(''+border+'',selectedvalue); addElements(parents,border,prop); }

         }
    });

   $('#gradientFrom').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$(el).val("#"+hex);
    		$(el).ColorPickerHide();
            var parents=getParent($('.selectedDiv'));
            addElements(parents,'backgroundImage','undefined');
        },
        onBeforeShow: function () {
      		$(this).ColorPickerSetColor(this.value);
        },
    	onShow: function (colpkr) {
    		$(colpkr).fadeIn(500);
    		return false;
    	},
    	onHide: function (colpkr) {
    		$(colpkr).fadeOut(500);
    		return false;
    	},
    	onChange: function (hsb, hex, rgb) {
    	    var parents=getParent($('.selectedDiv'));
            var gradientTo=document.getElementById('gradientTo').value;
            gradientEffect(parents,'#'+hex,gradientTo);
            $('#gradientFrom').css('backgroundColor','#'+hex);
    	}
    });


    $('#gradientTo').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$(el).val("#"+hex);
    		$(el).ColorPickerHide();
            var parents=getParent($('.selectedDiv'));
            addElements(parents,'backgroundImage','undefined');
        },
        onBeforeShow: function () {
      		$(this).ColorPickerSetColor(this.value);
        },
    	onShow: function (colpkr) {
    		$(colpkr).fadeIn(500);
    		return false;
    	},
    	onHide: function (colpkr) {
    		$(colpkr).fadeOut(500);
    		return false;
    	},
    	onChange: function (hsb, hex, rgb) {
    	    var parents=getParent($('.selectedDiv'));
            var gradientFrom=document.getElementById('gradientFrom').value;
            gradientEffect(parents,gradientFrom,'#'+hex);
            $('#gradientTo').css('backgroundColor','#'+hex);
    	}
    });

    $('#backgroundColor').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$(el).val("#"+hex);
    		$(el).ColorPickerHide();
            var parents=getParent($('.selectedDiv'));
            addElements(parents,'backgroundColor','undefined');
        },
        onBeforeShow: function () {
      		$(this).ColorPickerSetColor(this.value);
        },
    	onShow: function (colpkr) {
    		$(colpkr).fadeIn(500);
    		return false;
    	},
    	onHide: function (colpkr) {
    		$(colpkr).fadeOut(500);
    		return false;
    	},
    	onChange: function (hsb, hex, rgb) {
    	    var parents=getParent($('.selectedDiv'));
    		$(parents).css('backgroundColor','#'+hex);
            $('#backgroundColor').css('backgroundColor','#'+hex);
    	}
    });

    $('#color').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$(el).val("#"+hex);
    		$(el).ColorPickerHide();
            var parents=getParent($('.selectedDiv'));
            addElements(parents,'color','undefined');
        },
        onBeforeShow: function () {
      		$(this).ColorPickerSetColor(this.value);
        },
    	onShow: function (colpkr) {
    		$(colpkr).fadeIn(500);
    		return false;
    	},
    	onHide: function (colpkr) {
    		$(colpkr).fadeOut(500);
    		return false;
    	},
    	onChange: function (hsb, hex, rgb) {
    	    var parents=getParent($('.selectedDiv'));
    		$(parents).css('color','#'+hex);
            $('#color').css('backgroundColor','#'+hex);
    	}
    });

    $('#borderColor').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$(el).val("#"+hex);
    		$(el).ColorPickerHide();
            var parents=getParent($('.selectedDiv'));
            var element=getBorderColor();
            addElements(parents,element,'borderColor');
        },
        onBeforeShow: function () {
      		$(this).ColorPickerSetColor(this.value);
        },
    	onShow: function (colpkr) {
    		$(colpkr).fadeIn(500);
    		return false;
    	},
    	onHide: function (colpkr) {
    		$(colpkr).fadeOut(500);
    		return false;
    	},
    	onChange: function (hsb, hex, rgb) {
    	    var parents=getParent($('.selectedDiv'));
            var element=getBorderColor();
    		$(parents).css(element,'#'+hex);
            $('#borderColor').css('backgroundColor','#'+hex);
    	}
    });

    $('#colorShadow').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$('#colorShadow').val("#"+hex);
    		$('#colorShadow').ColorPickerHide();
            var parents=getParent($('.selectedDiv'));
            addElements(parents,'textShadow','undefined');
        },
        onBeforeShow: function () {
      		$(this).ColorPickerSetColor(this.value);
        },
    	onShow: function (colpkr) {
    		$(colpkr).fadeIn(500);
    		return false;
    	},
    	onHide: function (colpkr) {
    		$(colpkr).fadeOut(500);
    		return false;
    	},
    	onChange: function (hsb, hex, rgb) {
    	    var parents=getParent($('.selectedDiv'));
    		$(parents).css('textShadow','#'+hex+' '+document.getElementById('hShadow').value+' '+document.getElementById('vShadow').value+' '+document.getElementById('blurShadow').value);
            $('#colorShadow').css('backgroundColor','#'+hex);
    	}
    });

    $('#bcolorShadow').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$('#bcolorShadow').val("#"+hex);
    		$('#bcolorShadow').ColorPickerHide();
            var parents=getParent($('.selectedDiv'));
            addElements(parents,'boxShadow','undefined');
        },
        onBeforeShow: function () {
      		$(this).ColorPickerSetColor(this.value);
        },
    	onShow: function (colpkr) {
    		$(colpkr).fadeIn(500);
    		return false;
    	},
    	onHide: function (colpkr) {
    		$(colpkr).fadeOut(500);
    		return false;
    	},
    	onChange: function (hsb, hex, rgb) {
    	    var parents=getParent($('.selectedDiv'));
    		$(parents).css('boxShadow','#'+hex+' '+document.getElementById('bhShadow').value+' '+document.getElementById('bvShadow').value+' '+document.getElementById('bblurShadow').value);
            $('#bcolorShadow').css('backgroundColor','#'+hex);
    	}
    });

    $('*:not(.editor,.editor *,#copyright,#copyright *)').hover(function () {
      if(getEditor()){
        $(this).parents().removeClass('hover');
        $(this).addClass('hover');
        var tag='Tag: '+$(this).get(0).tagName;
        var position=$(this).offset();

        childEls="Tag: "+$(this)[0].tagName;

        if($(this).attr("id")){
            childEls+="    ID: #"+$(this).attr("id");
        }
        if($(this).attr("class") && $(this).attr("class")!='hover'){
            var classes = $(this).attr("class").split(/\s/);
            childEls+="    Class: ."+classes[0];
        }
        $('.tagname').text(childEls);
        $('.tagname').fadeIn('slow');
        $('.tagname').css({left:position.left+'px',top:position.top - 10 +'px'});
        return false;
      }

    }, function () {
        $('.hover').removeClass('hover');
    });
}
