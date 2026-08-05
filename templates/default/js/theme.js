
function afterpageLoad(){
    registerModal();
    $('html').removeClass('no-js');
    $('#loader').addClass('invisible').removeClass('visible');
}
window.onload=afterpageLoad ;

$(document).ready(function() {

    $('header .dropdown-toggle').click(function(event){
        event.stopPropagation();
    });

    $('.maincategory').each(function () {
        if($(this).find('.selectedgroup').length > 0){
            $(this).addClass('selectedgroup');
        }
    });

    /*$(".gridalicious").gridalicious({
        width:200,
        gutter: 20,
        animate: true,
        animationOptions: {
            speed: 50,
            duration: 100,
            complete: onComplete
        },
    });
    function onComplete(data) {
        console.log(data);
    }*/


    $('.carousel').carousel();
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    new WOW().init();

    $(document).ajaxStop(function() {
        $('select.form-control:not(.no-chosen),select.chosen').each(function(){
            if($(this).is(':visible'))
            {
                $(this).chosen();
            }
        });
        /*$('.alert').click(function(){
            $(this).hide();
        });*/
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('.collapse-bg').on('click touchstart',function (event) {
        $("button.navbar-toggler").click();
    });

    $('.ordertheme').click(function () {
        $('.ordertheme.active').removeClass('active');
        $('#orderstyle').val($(this).addClass('active').attr('data-value'));
        settheme();
    });

    $('.thememode').click(function () {
        $('.thememode.active').removeClass('active');
        $('#mode').val($(this).addClass('active').attr('data-value'));
        settheme('mode');
        if($('#mode').val()=='dark') {
            $('body').addClass('dark');
        }
        else{
            $('body').removeClass('dark');
        }
    });


    $('#modal-ajax').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var title = button.data('whatever')
        var modal = $(this);

        modal.find('.modal-title').text(title);
    });

    $('.thememode').click(function () {
        $('.thememode.active').removeClass('active');
        $('#thememode').val($(this).addClass('active').attr('data-value'));
    });

    /*$('.login-captcha').attr('src','widget/verificationimage?login=1');*/

    $('.imeiservices').searchService({searchBox:'#imeisearchservicebox'});
    $('.serverservices').searchService({searchBox:'#serversearchservicebox'});

    var o=function(){
        if($(this).scrollTop()>100){
            $(".page-index .header-fixed").addClass("navbar-shrink");
        }
        else{
            $(".page-index .header-fixed").removeClass("navbar-shrink");
        }
    };

    if($(window).width()>992){
        o();
        $(window).scroll(o);
    }


    var timer;
    $(window).scroll(function() {
        if ( timer ) clearTimeout(timer);
        timer = setTimeout(function(){
            if ($(this).scrollTop()) {
                $('#toTop:hidden').stop(true, true).fadeIn();
                $('.fixed-action-btn').addClass('active');
                $('.chat-icon-position').not('.openchat').addClass('hide');
            } else {
                $('#toTop').stop(true, true).fadeOut();
                $('.fixed-action-btn').removeClass('active');
                $('.chat-icon-position').removeClass('hide');
            }
        }, 1000);
    });



    setContentHeight();

    $(window).resize(function(){
        setContentHeight();

    })


    $("#language").change(function()
    {
        window.location.href="?selectlanguage="+$(this).val();
    });
    $("#currency").change(function()
    {
        window.location.href="?selectcurrencie="+$(this).val();
    });

    $('select.form-control:not(.no-chosen)').chosen();


    var ua = navigator.userAgent.toLowerCase();
    function removeSpaces(ua) {
        return ua.split(' ').join('');
    }
    ua = removeSpaces(ua);
    var iOS = ua.match(/(iphone|ipod|ipad)/);
    if(iOS) {
        $('html').addClass('ios');
    }
    var iPad = ua.match(/(ipad)/);
    if(iPad) {
        $('html').addClass('ipad');
    }
    var iPhone = ua.match(/(iphone|ipod)/);
    if(iPhone) {
        $('html').addClass('iphone');
    }
    var android = ua.indexOf("android") > -1;
    if(android) {
        $('html').addClass('android');
    }
    var android4 = ua.indexOf("android4") > -1;
    if(android4) {
        $('html').addClass('android4');
    }
    var android2 = ua.indexOf("android2") > -1;
    if(android2) {
        $('html').addClass('android2');
    }

    var i=0;
    setInterval(function () {
        i++;
        progressbar(i);
    },1000);

    progressbar(i);

    function progressbar(i) {
        $('.remaining-time').each(function () {

            var reply=$(this).attr('reply');

            if(reply=='Pending'){

                var date1=$(this).attr('ordertime');
                var date2=$(this).attr('averagetime');
                var times=$(this).attr('times');
                var orderid=$(this).attr('orderid');

                times = parseInt(times)+parseInt(i*1000);
                minutes1 = (((date2 - date1)/1000) / 60);
                minutes2 = (((times - date1)/1000) /60);
                var percentage = ((100*minutes2)/minutes1);


                if( Math.round(percentage)==50){
                    checkorder(orderid);
                }
                else if(Math.round(percentage)==95){
                    checkorder(orderid);
                }
                else if(Math.round(percentage)==110){
                    checkorder(orderid);
                }
                else if(Math.round(percentage)==140){
                    checkorder(orderid);
                }
                else if(Math.round(percentage)==200){
                    checkorder(orderid);
                }
                else{
                    var  perc= percentage;
                    if(percentage>=95){
                        perc=95;
                    }
                    var template =  '<div class="progress">\n' +
                        '              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="'+perc+'" aria-valuemin="0" aria-valuemax="100" style="width: '+perc+'%"></div>\n' +
                        '           </div>';
                    $(this).html(template);
                }

            }

        })
    }


    function checkorder(orderid) {

        $.post(urlprefix+"widget/getorderdetail?orderid="+orderid+"&type=imei", function (data, textStatus) {
            var data= JSON.parse(data);

            if(data.status=='Replied'){
                $('#orderid__'+data.order_id+' .order-status').html('<span class="textgreen">Success</span>');
                $('#orderid__'+data.order_id+' .replay-code').html(data.code);
                $('#orderid__'+data.order_id).addClass('updateorder-'+data.status);
            }
            if(data.status=='Cancelled'){
                $('#orderid__'+data.order_id+' .order-status').html('<span class="textred">Rejected</span>');
                $('#orderid__'+data.order_id+' .replay-code').html(data.code);
                $('#orderid__'+data.order_id).addClass('updateorder-'+data.status);
            }
            if(data.status=='Accepted'){
                $('#orderid__'+data.order_id+' .order-status').html('<span class="textyellow">In Process</span>');
                $('#orderid__'+data.order_id+' .col-action').html('-');
                $('#orderid__'+data.order_id).addClass('updateorder-'+data.status);
            }

        });
    }


    var timeout;
    $('#searchvalue').keyup(function (e) {
        if(e.which == 13){
            e.preventDefault();

            if(timeout) {
                clearTimeout(timeout);
                timeout = null;
            }
            var search = this.value;
            timeout = setTimeout(searchresult, 1000);
            function searchresult(){
                $.post(urlprefix+"widget/globalsearch?search="+search, function (data, textStatus) {

                    if(data){
                        var result = JSON.parse(data);

                        var imei='';
                        for (var key in result.imei) {
                            if (result.imei.hasOwnProperty(key)) {
                                imei+='<tr>' +
                                    '<td>#'+ result.imei[key].order_id +'</td>' +
                                    '<td>'+ result.imei[key].credit +'</td>' +
                                    '<td>'+ result.imei[key].date +'</td>' +
                                    '<td>'+ result.imei[key].status +'</td>' +
                                    '<td> <b>'+ result.imei[key].imei +'</b>  <br/> '+  result.imei[key].reply +'</td>' +
                                    '</tr>';
                            }
                        }
                        $('#searchresult-imei').html(imei);

                        var file='';
                        for (var key in result.file) {
                            if (result.file.hasOwnProperty(key)) {
                                file+='<tr>' +
                                    '<td>#'+ result.file[key].order_id +'</td>' +
                                    '<td>'+ result.file[key].file +'</td>' +
                                    '<td>'+ result.file[key].credit +'</td>' +
                                    '<td>'+ result.file[key].date +'</td>' +
                                    '<td>'+ result.file[key].status +'</td>' +
                                    '<td>'+ result.file[key].reply +'</td>' +
                                    '</tr>';
                            }
                        }
                        $('#searchresult-file').html(file);

                        var server='';
                        for (var key in result.server) {
                            if (result.server.hasOwnProperty(key)) {
                                server+='<tr>' +
                                    '<td>#'+ result.server[key].order_id +'</td>' +
                                    '<td>'+ result.server[key].credit +'</td>' +
                                    '<td>'+ result.server[key].date +'</td>' +
                                    '<td>'+ result.server[key].status +'</td>' +
                                    '<td>'+ result.server[key].reply +'</td>' +
                                    '</tr>';
                            }
                        }
                        $('#searchresult-server').html(server);
                    }
                    else{
                        var notfound ='<tr> <td colspan="5"> result not found </td> </tr>';
                        $('#searchresult-imei').html(notfound);
                    }
                    $('#modal-search').modal('show');

                });
            }
        }
    });

});


function setContentHeight(){
    if($(window).height()>=$('#container-content').height()){
        //$('#container-content').css({'min-height':$(window).height()-274});
    }
}
var searchtimer;
function searchItems(val){
    clearTimeout(searchtimer);
    searchtimer = setTimeout(function(){
        var html = '<div class="serchcontent">';
        $.post(urlprefix+'widget/getSearchProducts',{search: val,json:1}, function (data, textStatus) {
            if(data !== '[]')
            {
                var data = JSON.parse(data);
                $.each(data, function(key,type){
                    $.each(data[key], function(id,items){
                        html += '<li class="dropdown-header">'+id+'</li>'
                        $.each(items, function(id,item){
                            html += '<li class="dropdown-item"><a class="nav-link" href="'+item.seourl+'">'+item.service_name+'</a></li>'
                        });
                    });
                });
            }
            else{
                html += '<li>No result found</li>';
            }
            html += '</div>';
            $("#searchresult").html(html).slideDown();
        });
    }, 1000);
}

function settheme(type,json) {
    var themesettings = {orderstyle:$('#orderstyle').val(),mode:$('#mode').val(),column:$('#column').val()};
    if(type=='column'){
        themesettings.column=json;
    }

    $('#themesettings').val(btoa(JSON.stringify(themesettings)));
    SubmitForm('#themeset',urlprefix+'widget/save/settings/action/themesettings','#clientsettings','','true','#loader',true,'',function () {
        if(type!=='column') {
            window.location.reload();
        }
    });

}


function vieworderdetail(id) {
    $('#modal-orderdetail').modal('show');
    $('.orderdetail').removeClass('active');
    $('#orderdetail_'+id).addClass('active');
}

function getmoreorderdetails(id,url) {

    $(id).html('<div class="ajax-responsive loading"></div>');

    $.post(url, function (response, textStatus) {

        var data = JSON.parse(response);

        var template='<table class="table table-striped  table-hover">';
        if(data.model){
            template +='<tr><td>Model</td><td>:</td><td>'+data.model+'</td></tr>';
        }
        if(data.provider){
            template +='<tr><td>provider</td><td>:</td><td>'+data.provider+'</td></tr>';
        }
        if(data.mep){
            template +='<tr><td>mep</td><td>:</td><td>'+data.mep+'</td></tr>';
        }
        if(data.kbh){
            template +='<tr><td>kbh</td><td>:</td><td>'+data.kbh+'</td></tr>';
        }
        if(data.type){
            template +='<tr><td>type</td><td>:</td><td>'+data.type+'</td></tr>';
        }
        if(data.locks){
            template +='<tr><td>locks</td><td>:</td><td>'+data.locks+'</td></tr>';
        }
        if(data.pin){
            template +='<tr><td>pin</td><td>:</td><td>'+data.pin+'</td></tr>';
        }
        if(data.prd){
            template +='<tr><td>prd</td><td>:</td><td>'+data.prd+'</td></tr>';
        }
        if(data.sn){
            template +='<tr><td>sn</td><td>:</td><td>'+data.sn+'</td></tr>';
        }
        if(data.secro){
            template +='<tr><td>secro</td><td>:</td><td>'+data.secro+'</td></tr>';
        }
        if(data.reference){
            template +='<tr><td>reference</td><td>:</td><td>'+data.reference+'</td></tr>';
        }
        if(data.note){
            template +='<tr><td>note</td><td>:</td><td>'+data.note+'</td></tr>';
        }
        if(data.comments){
            template +='<tr><td>comments</td><td>:</td><td>'+data.comments+'</td></tr>';
        }

        if(data.custom){
            data.custom.forEach(function (cust) {
                template +='<tr><td>'+cust.name+'</td><td>:</td><td>'+cust.value+'</td></tr>';
            })
        }
        template +='</table>';
        $(id).html(template).show();
    });

}


function loadItems(gp){
    if(gp){
        $('.group.active').removeClass('active');
        $('.group.g_'+gp).addClass('active');
    }
    else{
        $('.group').addClass('active');
    }
}

function showdiscounted(obj) {
    if($(obj).is(':checked')){
        $('.service').removeClass('active');
        $('.service.discounted').addClass('active');
    }
    else{
        $('.service,.group').addClass('active');
    }

    $('.group').each(function () {
        if($('.service.active',this).length == 0){
            $(this).removeClass('active');
        }
    })
}



function msToTime(date1,date2,container) {

    seconds = Math.floor((date2 - (date1))/1000);
    minutes = Math.floor(seconds/60);
    hours = Math.floor(minutes/60);
    days = Math.floor(hours/24);

    hours = hours-(days*24);
    minutes = minutes-(days*24*60)-(hours*60);
    seconds = seconds-(days*24*60*60)-(hours*60*60)-(minutes*60);

    var str = '';
    if(days>0){
        str = days + " day(s) ";
    }
    else if(hours > 0){
        str = hours + " hr ";
    }
    else if(minutes > 0){
        str = minutes + " min ";
    }
    else{
        str =  "Just few seconds";
    }
    $(container).html(str);
}


function copy(id) {
    var copyText = strip(($(id).addClass('copied').html()).replace(/<br\s*[\/]?>/gi,'\n'));
    copyToClip(copyText);
}

function strip(html)
{
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}




function onscrollFixed(element){
    if($(window).width()>=920){
        $(element).css({'opacity':0});
        setTimeout(function(){
            $('thead',element).removeClass('table-head-fixed');
            $('tbody > tr:first-child > td > div',element).each(function(){
                $(this).css({'width':$(this).width()+'px'});
            });
            $('th > div',element).each(function(){
                $(this).css({'width':$(this).width()+'px'});
            });
            $('thead',element).addClass('table-head-fixed');
            //$(element).css({'height':($(window).height()-280)+'px'});
            $(element).css({'opacity':1});
        }, 1000);
    }
}

function expandall(){
    $('#catloglist li .icon-plus-sign').each(function(){
        $(this).parent().find('ul').slideDown();
        $(this).toggleClass('icon-minus-sign');
    });
}

function collapseall(){
    $('#catloglist li .icon-plus-sign').each(function(){
        $(this).parent().find('ul').slideUp();
        $(this).toggleClass('icon-minus-sign');
    });
}

function SelectChildren(element) {
    if ($("#" + element).is(':checked')) {
        $("." + element).attr('checked', true);
    } else {
        $("." + element).attr('checked', false);
    }
}


(function($){
    $.fn.extend({
        searchService: function(options) {
            var defaults = {
                searchBox: '#searchlistbox',
                searchObj: '.searchme'
            };

            var options = $.extend(defaults, options);
            this.each(function() {
                var o =options;
                var obj = $(this);
                $(o.searchBox).keyup(function(){
                    searchWord = $(this).val();
                    if (searchWord.length >= 1) {
                        $('.service',obj).addClass('active');
                        $('.group',obj).addClass('active');
                        $(o.searchObj,obj).each(function() {
                            text = $(this).text();
                            if (text.match(RegExp(searchWord, 'i'))) {
                                $(this).parents('.service').addClass('active');
                            }
                            else{
                                $(this).parents('.service').removeClass('active');
                            }
                        });
                    }else{
                        $('.service',obj).addClass('active');
                        $('.group',obj).addClass('active');
                    }

                    $('.group.active').each(function(){
                        if($(this).find('.service.active').length==0){
                            $(this).removeClass('active');
                        }
                    });

                });
            });
        }
    });
})(jQuery);

function showhot(obj){
    if($(obj).is(':checked')){
        $('.services tr').hide();
        $('.services tr.hottest').show();

        $('.group').each(function () {
            if($(this).find('.hottest').length === 0){
                $(this).removeClass('active');
            }
        })
    }
    else{
        $('.services tr').show();
        $('.group').addClass('active');
    }

}


function moveto(o){
    window.location.hash='#'+$(o).val();
}


jQuery.fn.liScroll = function(settings) {
    settings = jQuery.extend({
        travelocity: 0.03
    }, settings);
    return this.each(function(){
        var $strip = jQuery(this);
        $strip.addClass("newsticker")
        var stripHeight = 1;
        $strip.find("li").each(function(i){
            stripHeight += jQuery(this, i).outerHeight(true); // thanks to Michael Haszprunar and Fabien Volpi
        });
        var $mask = $strip.wrap("<div class='mask'></div>");
        var $tickercontainer = $strip.parent().wrap("<div class='tickercontainer'></div>");
        var containerHeight = $strip.parent().parent().height();
        $strip.height(stripHeight);
        var totalTravel = stripHeight;
        var defTiming = totalTravel/settings.travelocity;	// thanks to Scott Waye
        function scrollnews(spazio, tempo){
            $strip.animate({top: '-='+ spazio}, tempo, "linear", function(){$strip.css("top", containerHeight); scrollnews(totalTravel, defTiming);});
        }
        scrollnews(totalTravel, defTiming);
        $strip.hover(function(){
                jQuery(this).stop();
            },
            function(){
                var offset = jQuery(this).offset();
                var residualSpace = offset.top + stripHeight;
                var residualTime = residualSpace/settings.travelocity;
                scrollnews(residualSpace, residualTime);
            });
    });
};


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


