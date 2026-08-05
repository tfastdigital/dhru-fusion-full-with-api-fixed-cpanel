function getParent(object){
        var parentEls = object.parents().map(function (){
                var ids='';
                var cls='';

                if($(this).attr('id')){ ids='#'+$(this).attr('id'); }
                else if(this.className) {
                    var classes = $(this).attr("class");
                    classes=classes.replace(/\s/g,'.');
                    classes=classes.replace('..','.');
                    classes=classes.replace('..','.');
                    classes=classes.replace('.selectedDiv','');
                    classes=classes.replace('.hover','');
                    cls='.'+classes;
                }

                tag=this.tagName.toLowerCase();
                if(tag!='body' && tag!='form'){
                    if(cls!=''){
                        tag+=cls;
                    }
                    if(ids!=''){
                        tag+=ids;
                    }
                }
                return tag;

            }).get().join(",");

        var childEls = '';
        var cssElements;

        tag=$(object)[0].tagName.toLowerCase();
        if($(object).attr("id")){
            childEls="#"+$(object).attr("id");
            tag+=childEls;
        }
        else if($(object).attr("class")){
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
        cssElements=cssElements.split(' ');
        var last=cssElements.length-1;
        var secondlast=cssElements.length-2;
        var thirdlast=cssElements.length-3;
        var forthlast=cssElements.length-4;
        var fifthlast=cssElements.length-5;
        var lastmake= $.trim(cssElements[fifthlast]+' '+cssElements[forthlast]+' '+cssElements[thirdlast]+' '+cssElements[secondlast]+' '+cssElements[last]);
        return lastmake.replace('form ',' ');
    }


function getRules(obj) {
  var mycss = new Array();
  var ss = document.styleSheets[1];
    var rules = ss.cssRules || ss.rules;
        for (var i = 0; i < rules.length; i++) {
            var rule = rules[i];
            if($(obj).is(rule.selectorText)) {
                if (rule.selectorText.toLowerCase().indexOf(":hover") >= 0){
                    if($('#hover').is(":checked")){
                        mycss[i]=rule.selectorText;
                        break;
                     }
                }
                else if (rule.selectorText.toLowerCase().indexOf(",") >= 0){
                    break;
                }
                else if(rule.selectorText.toLowerCase().indexOf(" ") < 0){
                    break;
                }
                else{
                    mycss[i]=rule.selectorText;
                }
            }
        }
        if(mycss.length==0){
            return getParent(obj);
        }
        else{
            var longest = mycss.sort(function (a, b) { return b.length - a.length; })[0];
            return longest;
        }
        return false;
}

function addElements(inside,prop,value){
        var pattern = /[0-9]+/g;
        var id='';
        var important='';
        if($('#important').is(':checked')){
            important=' !important';
        }

        if(prop=='textShadow'){
            document.getElementById(prop).value=document.getElementById('colorShadow').value+' '+document.getElementById('hShadow').value+' '+document.getElementById('vShadow').value+' '+document.getElementById('blurShadow').value+' '+important;
        }
        else if(prop=='boxShadow'){
            document.getElementById(prop).value=document.getElementById('bcolorShadow').value+' '+document.getElementById('bhShadow').value+' '+document.getElementById('bvShadow').value+' '+document.getElementById('bblurShadow').value+' '+document.getElementById('shadowType').value+' '+important;
        }

        $('input[id*="cssElements"]').each(function(){
            if($(this).val().search(inside)>=0){
                var tmp=$(this).attr('id');
                var id = tmp.match(pattern);
                if($('input[id*="_'+prop+'['+id+']"]').length<=0){
                    if(value=='undefined'){
                       $('#frmaddadmin').prepend('<input type="hidden" name="_'+prop+'['+id+']" id="_'+prop+'['+id+']" value="'+document.getElementById(prop).value+' '+important+'"/>');
                    }
                    else{
                        $('#frmaddadmin').prepend('<input type="hidden" name="_'+prop+'['+id+']" id="_'+prop+'['+id+']" value="'+document.getElementById(value).value+' '+important+'"/>');
                    }
                }
                else{
                    if(value=='undefined'){
                       document.getElementById('_'+prop+'['+id+']').value=document.getElementById(prop).value+' '+important;
                    }
                    else{
                        document.getElementById('_'+prop+'['+id+']').value=document.getElementById(value).value+' '+important;
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


$(document).ready(function(){


   // $("body").find("script").remove().end().wrapInner('<form method="post" name="frmaddadmin" id="frmaddadmin"></form>');
    $('.editor').slideDown('slow');

    $('.editorcontent h2').append("<span class=arrow style=float:right;font-size:12px>+</span>");
    $('.editorcontent h2:first span').addClass('minus').text('-');
    $('.editorcontent h2:first').addClass('h2open');
    generateTemplatepath();
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
        $('.templatepath').remove();
        return false;

    });

    $('.activeeditor').click(function(){
        activeElements();
        document.getElementById('seteditor').value = '1';
        $('.editorcontent').fadeIn('fast');
        return false;
    });

    return false;
});

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
var css=';background:'+from+';background: -moz-linear-gradient(top,  '+from+' 0%,  '+to+' 100%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,'+from+'), color-stop(100%,'+to+'));background: -webkit-linear-gradient(top,  '+from+' 0%,'+to+' 100%);background: -o-linear-gradient(top,  '+from+' 0%,'+to+' 100%);background: -ms-linear-gradient(top,  '+from+' 0%,'+to+' 100%);background: linear-gradient(to bottom,  '+from+' 0%,'+to+' 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='+from+', endColorstr='+to+',GradientType=0);';
$(object).css({background:'-moz-linear-gradient(top,  '+from+' 0%,  '+to+' 100%)'});
$(object).css({background:'-webkit-linear-gradient(top,  '+from+' 0%,'+to+' 100%)'});
$(object).css({background:'-o-linear-gradient(top,  '+from+' 0%,'+to+' 100%)'});
$(object).css({background:'-ms-linear-gradient(top,  '+from+' 0%,'+to+' 100%)'});
$(object).css({background:'linear-gradient(to bottom,  '+from+' 0%,'+to+' 100%)'});
$(object).css({background:'-webkit-gradient(linear, left top, left bottom, color-stop(0%,'+from+'), color-stop(100%,'+to+'));'});
$(object).css({filter:'progid:DXImageTransform.Microsoft.gradient( startColorstr='+from+', endColorstr='+to+',GradientType=0);'});
document.getElementById('backgroundImage').value=css;
}

function conformation(action){
    if(action=='reset'){
        var r=confirm("Are You sure to reset template design?");
        if (r==true)
        {
            SubmitForm('#reset','includes/getdata/editor.reset.php','#frmaddadmin','#notification10','true','#loader');
            //location.reload();
        }
    }
    if(action=='undo'){
        undoaction();
    }
}

function undoaction(){
    $('.elementSelect').hide();
    $('#frmaddadmin [id*=cssElements]').each(function(){
        var path=$(this).val();
         $(path).removeAttr('style');
         var pattern = /[0-9]+/g;
         var id='';
         var tmp=$(this).attr('id');
         id=tmp.match(pattern);
         $(this).remove();

         $('#frmaddadmin input[type=text]').each(function(){
            prop=$(this).attr('id');
            id2=prop.match(pattern);
            if(parseInt(id)==parseInt(id2)){
               $(this).remove();
            }
         });
         return false;
    });
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
            if(left<0){
                $(this).css({left:'0px'});
                return false;
            }
            if(top<0){
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

    $('.addBgImageok').click(function(){
        selectedObj=$('.selectedDiv');
        var parents=getRules(selectedObj);
        $(parents).css('background-image','url(\''+$('.backgroundImage').val()+'\')');

        if($('.backgroundImage').val().indexOf('url(')<0 && $('.backgroundImage').val().indexOf('webkit')<0)
        {
            $('.backgroundImage').val('url(\'\../../../'+$('.backgroundImage').val()+'\')');
        }
       addElements(parents,'backgroundImage','undefined');
    });

    $('.positionPicker .ball').draggable(
    {
        containment:'.positionPicker',
        scroll:false,
        drag: function(){
            var position = $(this).position();
            $('#bhShadow').val(position.left+'px');
            $('#bvShadow').val(position.top+'px');
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
            $(parents).css('boxShadow',document.getElementById('bcolorShadow').value+' '+document.getElementById('bhShadow').value+' '+document.getElementById('bvShadow').value+' '+document.getElementById('bblurShadow').value);
            addElements(parents,'boxShadow','undefined');
        },
        stop:function(){
            //getHoverElement();
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
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
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
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
            $(parents).css('opacity',document.getElementById('opacity').value);
            addElements(parents,'opacity','undefined');
        }
    });

    $('.backgroundOpacity .ball').draggable(
    {
        containment:'.backgroundOpacity',
        axis: "x",
        scroll:false,
        drag: function(){
            var position = $(this).position();
            $('#backgroundOpacity').val(position.left/100);
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
            $('#backgroundColor').val('rgba('+$('#backgroundR').val()+','+$('#backgroundG').val()+','+$('#backgroundB').val()+','+$('#backgroundOpacity').val()+')');
            $(parents).css('background-color',document.getElementById('backgroundColor').value);
            addElements(parents,'backgroundColor','undefined');
        }
    });

    $('.backgroundR .ball').draggable(
    {
        containment:'.backgroundR',
        axis: "x",
        scroll:false,
        drag: function(){
            var position = $(this).position();
            $('#backgroundR').val(Math.round((position.left*255)/100));
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
            $('#backgroundColor').val('rgba('+$('#backgroundR').val()+','+$('#backgroundG').val()+','+$('#backgroundB').val()+','+$('#backgroundOpacity').val()+')');
            $(parents).css('background-color',document.getElementById('backgroundColor').value);
            addElements(parents,'backgroundColor','undefined');
        }
    });

    $('.backgroundG .ball').draggable(
    {
        containment:'.backgroundG',
        axis: "x",
        scroll:false,
        drag: function(){
            var position = $(this).position();
            $('#backgroundG').val(Math.round((position.left*255)/100));
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
            $('#backgroundColor').val('rgba('+$('#backgroundR').val()+','+$('#backgroundG').val()+','+$('#backgroundB').val()+','+$('#backgroundOpacity').val()+')');
            $(parents).css('background-color',document.getElementById('backgroundColor').value);
            addElements(parents,'backgroundColor','undefined');
        }
    });

    $('.backgroundB .ball').draggable(
    {
        containment:'.backgroundB',
        axis: "x",
        scroll:false,
        drag: function(){
            var position = $(this).position();
            $('#backgroundB').val(Math.round((position.left*255)/100));
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
            $('#backgroundColor').val('rgba('+$('#backgroundR').val()+','+$('#backgroundG').val()+','+$('#backgroundB').val()+','+$('#backgroundOpacity').val()+')');
            $(parents).css('background-color',document.getElementById('backgroundColor').value);
            addElements(parents,'backgroundColor','undefined');
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
            alert('Please select element which is display mouse over elements');
            return false;
        }
       if($(this).is(':checked')){
            $('.selectedDiv').parent().find('*').each(function(){
                if($(this).css('display')=='none'){
                    $(this).css({'display':'block'});
                }
           });
       }
       else{
           $('.selectedDiv').parent().find('*').each(function(){
                if($(this).css('display')=='block'){
                    $(this).css({'display':'none'});
                }
           });
       }

    });

    $('*').click(function(e) {
        if ($(e.target).is('.editor,.editor *,.colorpicker_submit,.colorpicker,.colorpicker *,undefined,#copyright,#copyright *,#frmaddadmin')) {
            return;
        }
        if(getEditor()){
               var parents=getRules($(this));
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
                     selectedvalue=document.getElementById('bcolorShadow').value+' '+document.getElementById('bhShadow').value+' '+document.getElementById('bvShadow').value+' '+document.getElementById('bblurShadow').value+' '+document.getElementById('shadowType').value;
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

             if(prop=='transitionProperty' || prop=='transitionDuration' || prop=='rotate'){

                    var arr=$('#transitionProperty').val();
                    var browsers=['','-moz-','-webkit-','-o-','-ms-'];

                   if(arr){
                       var transition='';
                       var prop='transition';

                       for (var j = 0; j < 5; j++){
                            transition=transition+' '+browsers[j]+'transition:';
                            for (var i = 0; i < arr.length; i++){
                                if(arr[i]=='transform'){
                                    transition=transition +' '+browsers[j]+'transform '+$('#transitionDuration').val();
                                }
                                else
                                {
                                    transition=transition +' '+arr[i]+' '+$('#transitionDuration').val();
                                }
                                if(i!=arr.length-1){
                                   transition=transition+',';
                                }
                            }
                            transition=transition+';';

                       }
                       $('#transition').val(transition);
                  }
                  if(prop=='rotate'){
                       var transform='';
                       var prop='transform';
                       for (var j = 0; j < 5; j++){
                           transform=transform +' '+browsers[j]+'transform:rotate('+$('#rotate').val()+'deg);';
                       }
                       $('#transform').val(transform);
                  }
             }

             selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
             if(border=='undefined'){$(parents).css(''+prop+'',selectedvalue); addElements(parents,prop,'undefined');}
             else{$(parents).css(''+border+'',selectedvalue); addElements(parents,border,prop); }

         }
    });

   $('#hover').click(function(){
       if($(this).is(':checked')){
          $('.hover-show').show();
          $('.hover-hide').hide();
       }
       else{
          $('.hover-show').hide();
          $('.hover-hide').show();
       }
   })


   $('#gradientFrom').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$(el).val("#"+hex);
    		$(el).ColorPickerHide();
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
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
    	    selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
            var gradientTo=document.getElementById('gradientTo').value;
            gradientEffect(parents,'#'+hex,gradientTo);
            $('#gradientFrom').css('backgroundColor','#'+hex);
    	}
    });


    $('#gradientTo').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$(el).val("#"+hex);
    		$(el).ColorPickerHide();
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
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
    	    selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
            var gradientFrom=document.getElementById('gradientFrom').value;
            gradientEffect(parents,gradientFrom,'#'+hex);
            $('#gradientTo').css('backgroundColor','#'+hex);
    	}
    });

    $('#backgroundColor').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$(el).val("#"+hex);
    		$(el).ColorPickerHide();
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
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
    	    selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
            $('#backgroundR').val(hexToR('#'+hex));
            $('#backgroundG').val(hexToG('#'+hex));
            $('#backgroundB').val(hexToB('#'+hex));
    		$(parents).css('backgroundColor','#'+hex);
            $('#backgroundColor').css('backgroundColor','#'+hex);
    	}
    });

    $('#color').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$(el).val("#"+hex);
    		$(el).ColorPickerHide();
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
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
    	    selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
    		$(parents).css('color','#'+hex);
            $('#color').css('backgroundColor','#'+hex);
    	}
    });

    $('#borderColor').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$(el).val("#"+hex);
    		$(el).ColorPickerHide();
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
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
    	    selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
            var element=getBorderColor();
    		$(parents).css(element,'#'+hex);
            $('#borderColor').css('backgroundColor','#'+hex);
    	}
    });

    $('#colorShadow').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$('#colorShadow').val("#"+hex);
    		$('#colorShadow').ColorPickerHide();
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
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
    	    selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
    		$(parents).css('textShadow','#'+hex+' '+document.getElementById('hShadow').value+' '+document.getElementById('vShadow').value+' '+document.getElementById('blurShadow').value);
            $('#colorShadow').css('backgroundColor','#'+hex);
    	}
    });

    $('#bcolorShadow').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$('#bcolorShadow').val("#"+hex);
    		$('#bcolorShadow').ColorPickerHide();
            selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
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
    	    selectedObj=$('.selectedDiv'); var parents=getRules(selectedObj);
    		$(parents).css('boxShadow','#'+hex+' '+document.getElementById('bhShadow').value+' '+document.getElementById('bvShadow').value+' '+document.getElementById('bblurShadow').value+' '+document.getElementById('shadowType').value);
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

function hexToR(h) {return parseInt((cutHex(h)).substring(0,2),16)}
function hexToG(h) {return parseInt((cutHex(h)).substring(2,4),16)}
function hexToB(h) {return parseInt((cutHex(h)).substring(4,6),16)}
function cutHex(h) {return (h.charAt(0)=="#") ? h.substring(1,7):h}

function generateTemplatepath(){

//var l = window.location;
//var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1];

    var i=0;
    $('head link').each(function(){
        var templatePath=$(this).attr('href');
        var patharray=templatePath.split('/');
        var restorepoint=patharray.slice(0,-1);
        if($('#frmaddadmin').find('.restorepoint').length=='0'){
            $('#frmaddadmin').append('<input type="hidden" name="restorepoint" class="restorepoint" value="'+restorepoint.join('/')+'">');
        }
        if ((templatePath.indexOf('/main') > -1 || templatePath.indexOf('/style') > -1 || templatePath.indexOf('/theme') > -1)) {
            templatePaths=templatePath.split("?");
            templatePath=templatePaths[0];
            $('#frmaddadmin').append('<input type="hidden" class="templatepath" name="templatePath['+i+']" value="'+templatePath+'">');
            i++;
        }
    });
}
function savefont(font){
    SubmitForm('#savebut','includes/getdata/editor.save.php?font='+font,'#frmaddadmin','#notification10','true','#loader');
    alert('Change Font '+font);
    location.reload();
}
function getRestorepointfile(){
    $.post('includes/getdata/editor.getdropdown.restorepoint.php?path='+$('.restorepoint').val(), function(data) {
        $('.restorepointdropdown').html(data);
    });
}
function restoreSelected(){
   SubmitForm('#undo','includes/getdata/editor.apply.restorepoint.php?restorepointdropdown='+$('#restorepointdropdown').val(),'#frmaddadmin','#notification10','true','#loader');
   //location.reload();
}
