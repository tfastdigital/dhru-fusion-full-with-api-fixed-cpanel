$(document).ready(function(){

    var root = document.getElementsByTagName( 'html' )[0];
    root.setAttribute( 'class', 'js' );

    $('#clear').click(function(){
            $('#intellisearchvaltab').val('');
            $('#intellisearchvaltab').select();
        });

     $('.tabsearch').click(function(){
            $('.showsearch').slideDown();
        });

     $('#closesearch').click(function(){
            $('.showsearch').slideUp();
        });

     $('.scr_resultheader').click(function(){
        $(this).next('.src-content').slideDown();
     })


    $('.slideright.open').click(function(){
       $('.colm1,#subheader,#tabs-group,.themecolor ').toggleClass('slide-right');
       if($('.colm1.slide-right').length==0){
           $.post('includes/config.save.php?admintheme_menu=open', function (data, textStatus) {});
       }
       else{
            $.post('includes/config.save.php?admintheme_menu=close', function (data, textStatus) {});
       }
    });

    $('#subpageiframe').height($(window).height()-60);

    $(window).resize(function(){
        $('#subpageiframe').height($(window).height()-60);
    });

    $('#dashboardNav #mainNav li').hover(function(){
       if($('ul:first',this).length!=0){
        var $text=$('a:first',this).text();
        if($('#mainNav').hasClass('close') && !$('p').hasClass('header')){
            $('ul:first',this).prepend('<p class="header">'+$text+'</p>');
        }
        //$('ul:first',this).fadeIn('fast');
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();
        var elemTop = $('ul:first',this).offset().top;
        var elemBottom = elemTop + $('ul:first',this).height();
        if(elemBottom>=docViewBottom){
            $('ul:first',this).css({'bottom':'-80px','top':'auto'});
        }
       }
    },function(){
        $('.header',this).remove();
        //$('ul:first',this).fadeOut('fast');
    });


    $('#mainNav .search').hover(function(){
       if($('#mainNav').hasClass('close')){
            $('#mainNav .search a').css({'text-indent':'0','background-color':'black','width':'190px'});
            $('.text_search').stop().animate({'width':'180px'});
       }
    },function(){
       if($('#mainNav').hasClass('close')){
            $('#mainNav .search a').css({'text-indent':'-9999px','background-color':'transparent','width':'40px'});
            $('.text_search').stop().animate({'width':'0px'});
        }
    });

    $('#subheader_txt_profile li.main').click(function(){
       $('ul',this).slideToggle();
    });
    $("#subheader_txt_profile li.main ul").click(function(e) {
        e.stopPropagation();
   });

   $(".quickaccess ul").click(function(e) {
        e.stopPropagation();
   });

   $('.theme a span').click(function(){
       var color = $(this).css("background-color");
       if($(this).attr('class')=='blue'){
         var fontColor='white';
       }
       if($(this).attr('class')=='gray'){
         var fontColor='#f1f0f0';
       }
       if($(this).attr('class')=='orange'){
         var fontColor='white';
       }
       if($(this).attr('class')=='green'){
         var fontColor='white';
       }
       $('.themecolor').css({backgroundColor:color});
       $('.themecolor li a').css({'color':fontColor});
       $.post('includes/config.save.php?admintheme_bg='+ color+'&admintheme_color='+fontColor+'&admintheme_opacity=1', function (data, textStatus) {
       });
   });
});

function saveTheme(template){
    $.post('includes/pages/editadmintheme.save.php?template='+ template, function (data, textStatus) {
        window.location.reload();
    });
}

function closeDropdown(){
   $('#subheader_txt_profile li.main ul').slideUp();
}
