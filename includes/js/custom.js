
var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearInterval(timer);
        timer = setTimeout(callback, ms);
    };
})();
function removeLoginCountry(cnt){
    $.post( urlprefix+"settings/logins?removecntr="+cnt, function( data ) {
        $("#"+cnt).hide();
    });
}
function getRetailDetails(service,loaddiv){
//cart?group=6481&item=86493&service=imei
    $.post( urlprefix+"cart?group=6481&min=1&item="+service+"&standalone=1&service=imei", function( data ) {

        $(loaddiv).html(data);
    });
}
function getDirectInfo(url,gateway){
    $.post( url+"/"+gateway, function( data ) {
        $("#directinfo").html(data);
    });
}
function calculateStorePrice(serviceid)
{

    var price=parseFloat($('.price_'+serviceid).val());
    var increase=parseFloat($('.inc_'+serviceid).val());
    var increaseby=($('.by_'+serviceid).val());

    var calc=0;
    if(increaseby=='Percent')
    {
        calc= (price+((price*increase)/100)).toFixed(2);
    }else{
        calc= (price+ increase ).toFixed(2);
    }
    $(".calsell_"+serviceid).html(calc);

}
function setCurrencyTo(cid)
{
    $.post( "index?selectcurrencie="+cid, function( data ) {
        location.reload();
    });
}
function removeFromHome(type,pid){
    $.post( urlprefix+"widget/homeproduct?type="+type+"&pid="+pid, function( data ) {

        location.reload();
    });
}
function registerModal(){
    $("[data-target='#modal-ajax'],[data-target='#modalverification']").off().on('click',function(ev) {
        var cur=$(this).attr('data-target');
        var size=$(this).attr('data-size');
        var whatever=$(this).attr('data-whatever');
        if(typeof size === "undefined"){
            size='modal-lg';
        }
        $('#modal-size').removeClass('modal-sm').removeClass('modal-md').removeClass('modal-lg').removeClass('modal-xl');
        $('#modal-size').addClass(size);
        var target = $(this).attr("href");

        $(".modal-title",cur).html(whatever);
        $(".modal-body",cur).html('<div class="ajax-responsive loading"></div>');

        $(".modal-body",cur).load(target, function() {
            $(cur).modal("show");
        });
        ev.preventDefault();
    });

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    $('select.form-control:not(.no-chosen)').chosen();

}



function SubmitForm (buttonId,page,formId,callbackDivId,loader,loaderDivId,blankformdata,alertaccept,callbackfunction){


    $(formId).submit(function(event){
        event.preventDefault();
    });


    $(buttonId).attr("disabled", true);
    $(callbackDivId).hide();
    var temp=$(buttonId).text();

    $(buttonId).text('Please Wait...');

    $(callbackDivId).empty().append('');
    if(loader){ $(loaderDivId).show();}
 /*   if(alertaccept){
        if(page.indexOf("?")!=0){
            page=page+"&alertaccept="+alertaccept;
        }else{
            page=page+"?alertaccept="+alertaccept;
        }
    }*/


    $.ajax({
        type: "POST",
        url: page,
        data: $(formId).serialize(),
        contentType: "application/x-www-form-urlencoded",
        dataType: "text",
        success: function (data) {


            $(buttonId).text(temp);
            $(callbackDivId).removeClass('successbox');
            $(callbackDivId).removeClass('errorbox');
            $(callbackDivId).removeClass('info');
            $(callbackDivId).removeClass('alert-success');
            $(callbackDivId).removeClass('alert-error');
            $(callbackDivId).removeClass('alert-danger');
            $(callbackDivId).removeClass('alert-info');
            $(callbackDivId).show();

            //$(callbackDivId).removeClass('alert');
            data=data.replace('http:','HTTP');
            data=data.replace('https:','HTTPS');

            var callback_data = data.split(":");

            if(callback_data[0]) {
                callback_data[0] = callback_data[0].replace('HTTPS', 'https:');
                callback_data[0] = callback_data[0].replace('HTTP', 'http:');
                callback_data[0]=$.trim(callback_data[0]);
            }

            if(callback_data[1]) {
                callback_data[1] = callback_data[1].replace('HTTPS', 'https:');
                callback_data[1] = callback_data[1].replace('HTTP', 'http:');
            }

            if(callback_data[2]) {
                callback_data[2] = callback_data[2].replace('HTTPS', 'https:');
                callback_data[2] = callback_data[2].replace('HTTP', 'http:');
            }

            if(callback_data[0]=='redirect'){
                $(callbackDivId).addClass('info');
                $(callbackDivId).addClass('alert-info');
                $(callbackDivId).empty().append('Redirecting - please wait ... <BR /> *If this appears for more than five seconds, <a href="main">click here</a> .');
                $(window.location).attr('href', callback_data[1]);
            }
            if(callback_data[0]=='reload'){
                location.reload();
            }
            if(callback_data[0]=='redirectto'){
                $(callbackDivId).addClass('info');
                $(callbackDivId).addClass('alert-info');
                $(callbackDivId).empty().append('Redirecting - please wait ... <BR /> *If this appears for more than five seconds, <a href="main">click here</a> .');
                $(window.location).attr('href', 'http://'+$.trim(callback_data[1]));
            }

            if(callback_data[0]=='showdiv'){
                $(callback_data[1]).show();
                $(callbackDivId).addClass('info');
                $(callbackDivId).addClass('alert-info');
                if(callback_data[2]){
                    $(callbackDivId).empty().append(callback_data[2]);
                }else {
                    $(callbackDivId).empty().append('Enter OTP');
                }
                /*if(callback_data[3]){
                    $(callback_data[3]).attr('readonly', true);
                    $(buttonId).attr("disabled", true);
                    return true;
                }*/
            }




            if(callback_data[0]=='success'){
                $(callbackDivId).addClass('successbox');
                $(callbackDivId).addClass('alert-success');
                $(callbackDivId).empty().append(callback_data[1]);

                if(blankformdata){}else{
                    var $inputs = $(formId+' :input');
                    var values = {};
                    $inputs.each(function() {

                        if ($(this).is('select')){

                        }else
                        if ($(this).is('input:button')){

                        }
                        else if($(this).is('input:checkbox')){

                        }else if($(this).is('input:hidden')){

                        }else if($(this).is('input:radio')){

                        }else{
                            $(this).val('');
                        }
                    });
                }
                $('html, body,.modal-body').animate({scrollTop:0}, 'slow');
                if(callback_data[3]){
                    $(callback_data[3]).hide();
                }
                if(callback_data[2]){
                    var hide_data = callback_data[2].split(",");
                    $.each( hide_data , function(index, value) {
                        $("#hide_"+value).hide();
                    });
                }
            }
            if(callback_data[0]=='alert' ){
                var reply=confirm(callback_data[1]);
                if(reply){
                    SubmitForm (buttonId,callback_data[2],formId,callbackDivId,loader,loaderDivId,blankformdata,true);
                }
            }
            if(callback_data[0]=='success_addedcart'){
                $(callbackDivId).addClass('successbox');
                $(callbackDivId).addClass('addedtocart');
                $(callbackDivId).addClass('alert-success');
                $(callbackDivId).empty().append(callback_data[1]);

                if(blankformdata){}else{
                    var $inputs = $(formId+' :input');
                    var values = {};
                    $inputs.each(function() {
                        if ($(this).is('input:button')){
                        }else if($(this).is('input:hidden')){
                        }else if($(this).is('input:radio')){
                        }else if($(this).is('input:checkbox')){
                        }else if($(this).is('select')){
                        }
                        else{
                            $(this).val('');
                        }
                    });
                }

                $(callbackDivId).append('<a href="'+urlprefix+'cart/action/view" class="alert-viewcart">View Cart</a>');

                $('html, body,.modal-body').animate({scrollTop:0}, 'slow');
                viewminicart('#cartminiview');
            }
            if(callback_data[0]=='error'){

                if(page=='login?action=clientlogin')
                {
                    $(".captchalogin").show();
                }

                $(callbackDivId).addClass('errorbox');
                $(callbackDivId).addClass('alert-error');
                $(callbackDivId).addClass('alert-danger');
                $(callbackDivId).empty().append(callback_data[1]);
                $('html, body,.modal-body').animate({scrollTop:0}, 'slow');

                if(callback_data[3]){
                    $(callback_data[3]).hide();
                }
            }

            if(callback_data[0]=='debug'){
                $(callbackDivId).addClass('errorbox');
                $(callbackDivId).addClass('alert-error');
                $(callbackDivId).addClass('alert-danger');
                $(callbackDivId).empty().append(data);
            }
            if(data=='')
            {
                $(callbackDivId).hide();
            }


            $(buttonId).attr("disabled", false);

            if(loader){
                $(loaderDivId).hide();
            }
            if(callbackfunction){
                callbackfunction(callback_data[0],callback_data);
            }
        },
        error: function (ed) {
            //  alert('err'+ed);
        },
        complete: function (cd) {
            // alert('crr'+cd);
        }
    });
    hideAlert(callbackDivId);
}


function SubmitFormJSON (buttonId,page,formId,callbackDivId,loader,loaderDivId,blankformdata,alertaccept,callbackfunction){


    $(formId).submit(function(event){
        event.preventDefault();
    });

    $(buttonId).attr("disabled", true);
    $(callbackDivId).hide();
    var temp=$(buttonId).text();
    var classes = '';


    $(buttonId).text('Please Wait...');
    $(callbackDivId).html();
    if(loader){ $(loaderDivId).show();}

    $.ajax({
        type: "POST",
        url: page,
        data: $(formId).serialize(),
        contentType: "application/x-www-form-urlencoded",
        dataType: "text",
        success: function (data) {


            $(buttonId).text(temp);
            var callback = JSON.parse(data);

            console.log(callback,'callback');

            $(callbackDivId).removeClass('alert-success alert-error alert-danger alert-info');

            if(callback.status=='error'){
                classes = 'alert-danger';
                $(callbackDivId).addClass('alert-danger');
            }
            else if(callback.status=='success'){
                classes = 'alert-success';
                if(!blankformdata){
                    var $inputs = $(formId+' :input');
                    $inputs.each(function() {
                        if ($(this).is('select')){}
                        else if($(this).is('input:button')){}
                        else if($(this).is('input:checkbox')){}
                        else if($(this).is('input:hidden')){}
                        else if($(this).is('input:radio')){}
                        else{$(this).val('');}
                    });
                }
            }
            else if(callback.status=='debug'){
                classes = 'alert-info';
                $(callbackDivId).html(data);
            }
            else if(callback.status=='reload'){
                location.reload();
            }
            else if(callback.status=='alert' ){
                var reply=confirm(callback.message);
                if(reply){
                    SubmitFormJSON(buttonId,page,formId,callbackDivId,loader,loaderDivId,blankformdata,true);
                }
            }
            else if(callback.status=='success_addedcart'){
                classes = 'alert-success';
                if(!blankformdata){
                    var $inputs = $(formId+' :input');
                    var values = {};
                    $inputs.each(function() {
                        if ($(this).is('input:button')){
                        }else if($(this).is('input:hidden')){
                        }else if($(this).is('input:radio')){
                        }else if($(this).is('input:checkbox')){
                        }else if($(this).is('select')){
                        }
                        else{
                            $(this).val('');
                        }
                    });
                }

                $(callbackDivId).append('<a href="cart?action=view" class="alert-viewcart">View Cart</a>');

                $('html, body').animate({scrollTop:0}, 'slow');
                viewminicart('#cartminiview');
            }


            if(callback.divid && callback.divcontent){
                $(callback.divid).html(callback.divcontent);
            }
            if(callback.hidediv){
                $(callback.hidediv).hide();
            }
            if(callback.showdiv){
                $(callback.showdiv).show();
            }
            if(callback.redirect){
                classes = 'alert-info';
                callback.message = 'Redirecting - please wait ... <BR /> *If this appears for more than five seconds, <a href="main">click here</a> .';
                $(window.location).attr('href', callback.redirect);
            }


            $(callbackDivId).addClass(classes).html(callback.message).show();
            $('html, body').animate({scrollTop:0}, 'slow');
            $(buttonId).attr("disabled", false);




            if(loader){
                $(loaderDivId).hide();
            }
            if(callbackfunction){
                callbackfunction(callback);
            }
        },
        error: function (ed) {
            //  alert('err'+ed);
        },
        complete: function (cd) {
            // alert('crr'+cd);
        }
    });
    hideAlert(callbackDivId);
}



function clearAllNotification(quickn)
{
    if(confirm('Are you sure want to remove all Announcements?'))
    {
        $.post('includes/hideAnnounce',{clearall: true,quicknew:quickn}, function (data, textStatus) {
        });
    }
}

function SubmitForm2 (buttonId,page,formId,callbackDivId,loader,loaderDivId,blankformdata,alertaccept){

    $(formId).submit(function(event){
        event.preventDefault();
    });
    $(buttonId).attr("disabled", true);
    $(callbackDivId).hide();
    var temp=$(buttonId).text();
    $(buttonId).text('Please Wait...');
    $(callbackDivId).empty().append('');
    if(loader){ $(loaderDivId).show();}

    $.ajax({
        type: "POST",
        url: page,
        data: $(formId).serialize(),
        contentType: "application/x-www-form-urlencoded",
        dataType: "text",
        success: function (data) {
            $(buttonId).text(temp);
            $(callbackDivId).show();
            $(callbackDivId).removeClass('alert-success');
            $(callbackDivId).removeClass('alert-danger');
            $(callbackDivId).removeClass('alert-info');
            var callback_data = data.split(":");
            callback_data[0]=$.trim(callback_data[0]);
            if(callback_data[0]=='success'){
                $('#custom-alert').show();
                $('#custom-alert-msg').addClass('alert-success').html(callback_data[1]);
                $('input[type="text"],textarea',formId).val('');
                $('.sa-icon').addClass('alert-success');
            }
            if(callback_data[0]=='error'){
                $(callbackDivId).addClass('alert-danger');
                $(callbackDivId).empty().append(callback_data[1]);
            }
            if(callback_data[0]=='debug'){
                $(callbackDivId).addClass('alert-danger');
                $(callbackDivId).empty().append(data);
            }
            if(callback_data[0]=='redirectto'){
                $(callbackDivId).addClass('info');
                $(callbackDivId).addClass('alert-info');
                $(callbackDivId).empty().append('Redirecting - please wait ... <BR /> *If this appears for more than five seconds, <a href="main">click here</a> .');
                $(window.location).attr('href', 'http://'+$.trim(callback_data[1]));
            }
            $(buttonId).attr("disabled", false);
            if(loader){
                $(loaderDivId).hide();
            }
        }
    });
}


    function SubmitFormFile (buttonId,page,formId,callbackDivId,loader,loaderDivId,showonsuccess,hideonsuccess,dontclose,refresh,parentrefresh){

        $(buttonId).attr("disabled", true);
        $(callbackDivId).hide();
        var temp=$(buttonId).text();
        $(buttonId).text('Please Wait...');
        $(callbackDivId).empty().append('');
        if(loader){ $(loaderDivId).show();}



        var formData = new FormData($(formId)[0]);


        $.ajax({
            url: page,
            type: 'POST',
            data: formData,
            success: function (data) {

                $(callbackDivId).show();
                $(callbackDivId).removeClass('alert-success');
                $(callbackDivId).removeClass('alert-danger');
                $(callbackDivId).removeClass('alert-info');
                var callback_data = data.split(":");
                callback_data[0]=$.trim(callback_data[0]);
                if(callback_data[0]=='success'){
                    $(callbackDivId).show();
                    $(callbackDivId).addClass('alert-success').html(callback_data[1]);
                    $('input[type="text"],textarea',formId).val('');
                    $('.sa-icon').addClass('alert-success');
                }
                if(callback_data[0]=='error'){
                    $(callbackDivId).addClass('alert-danger');
                    $(callbackDivId).empty().append(callback_data[1]);
                }
                if(callback_data[0]=='debug'){
                    $(callbackDivId).addClass('alert-danger');
                    $(callbackDivId).empty().append(data);
                }
                if(callback_data[0]=='redirectto'){
                    $(callbackDivId).addClass('info');
                    $(callbackDivId).addClass('alert-info');
                    $(callbackDivId).empty().append('Redirecting - please wait ... <BR /> *If this appears for more than five seconds, <a href="main">click here</a> .');
                    $(window.location).attr('href', 'http://'+$.trim(callback_data[1]));
                }
                $(buttonId).attr("disabled", false);
                $(buttonId).text(temp);
                if(loader){
                    $(loaderDivId).hide();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });


    }



function hideNews(url,id){
    if(confirm('Are you sure want to remove Announcements?'))
    {
        $.post(url,{qid: id}, function (data, textStatus) {

        });
    }
}

function hideAlert(callbackDivId){
    var myInterval;
    $(callbackDivId).ajaxSuccess(function(){
        var $newdiv1 = $('<span id="alert-counter" style="float:right;"/>');
        var counter = 20;
        if($(callbackDivId).find('#alert-counter').length=='0'){
            $(callbackDivId).prepend($newdiv1);
            clearInterval(myInterval);
            myInterval = setInterval(function () {
                --counter;
                $('#alert-counter').text('Dismis in '+counter+ ' seconds');
                if(counter=='1'){
                    $(callbackDivId).fadeOut('slow');
                    clearInterval(myInterval);
                    $('#alert-counter').text('');
                }
            }, 1000);
        }
    });
    $(callbackDivId).not('.addedtocart').click(function(){
        $(this).fadeOut();
    });
}


function getContect (aId,page,callbackDivId,loader,loaderDivId,iLoader){

    if(iLoader){
        var position = $(callbackDivId).position();
        var left= position.left+'px';
        var top= position.top+'px';
        var height=$(callbackDivId).height()+'px';
        var width=$(callbackDivId).width()+'px';
        $('#loader').css({'top':top,'left':left,'height':height,'width':width,'position':'absolute'});
        $(callbackDivId).empty().html('<div class="spinner-loader"><i class="fal fa-spinner fa-spin fa-3x fa-fw"></i></div>');
        //$(callbackDivId).css({'position':'relative'}).html('<div class="loader" style="position:absolute"> <div class="aBar" style="display:block;box-shadow:none"></div></div>');
    }else{
        if(loader){ $(loaderDivId).show();}
    }

    $("ul li a").removeClass('tabmenu_active');
    $(aId).parent('li').parent().find('li').removeClass('active');
    $(aId).addClass('tabmenu_active');
    $(aId).parent('li').addClass('active');



    $.post(page, function (data, textStatus) {
        $(callbackDivId).empty().append(data);
        if(loader){ $(loaderDivId).hide();}
        oddEven();
        filterlist();
        registerModal();
        return false;
    });
}


function loadMore (page,callbackDivId,loaderid,startfrom,totalrows){
    if(startfrom <= totalrows){
        $(loaderid).empty().html('<div class="spinner-loader"><i class="fal fa-spinner fa-spin fa-3x fa-fw"></i></div>');
        $.post(page+'&fromstart='+startfrom, function (data, textStatus) {
            $(loaderid).empty();
            $(callbackDivId).append(data);
        });
    }
}


function getJson (page,callback){
    $.post(page, function (data, textStatus) {
        if(callback){
            callback(data);
        }
        return false;
    });
}




function setCookies(val){
    var c_name='UserAuto';
    var value=val;
    var exdays=365;
    if(val){
        var exdate=new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
        document.cookie=c_name + "=" + c_value;
    }else{
        var exdays=-1;
        var exdate=new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
        document.cookie=c_name + "=" + c_value;
    }
}
function getCookie(c_name) {
    var i,x,y,ARRcookies=document.cookie.split(";");
    for (i=0;i<ARRcookies.length;i++)
    {
        x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
        y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
        x=x.replace(/^\s+|\s+$/g,"");
        if (x==c_name)
        {
            return unescape(y);
        }
    }
}

// Imei Service load
function getWidgetdetailsIMEI(serviceId,callbackDivId,callbackserviceInfoId,loader,loaderDivId,forCart,bid,mid,cid,pid,forquickcheckout,min){

    if(loader){ $(loaderDivId).show();}
    if(callbackDivId=='#loadDetails'){
        $.post(urlprefix+'widget/getServicedetailsIMEI',{serviceid: serviceId,cart:forCart,price: true,brand: bid,model: mid,country: cid,provider: pid,forquickcheckout:forquickcheckout,min:min}, function (data, textStatus) {

            $(callbackDivId).empty().append(data);
            if(loader){ $(loaderDivId).hide();}
            getServiceInfoIMEI(serviceId,callbackserviceInfoId,true,loaderDivId);
            if(bid!=0 && mid!=0){
                getWidModels(bid,serviceId,'#modelsdropdown',true,'#loader',mid);
            }
            if(cid!=0 && pid!=0){
                getWidProvider(cid,serviceId,'#providerdropdown',true,'#loader',pid);
            }
        });
    }  else {
        $.post(urlprefix+'widget/getServicedetailsIMEI',{serviceid: serviceId,cart:forCart,brand: bid,model: mid,country: cid,provider: pid,forquickcheckout:forquickcheckout,min:min}, function (data, textStatus) {

            $(callbackDivId).empty().append(data);
            if(loader){ $(loaderDivId).hide();}

            getServiceInfoIMEI(serviceId,callbackserviceInfoId,true,loaderDivId);

            if(bid!=0 && mid!=0){
                getWidModels(bid,serviceId,'#modelsdropdown',true,'#loader',mid);
            }
            if(cid!=0 && pid!=0){
                getWidProvider(cid,serviceId,'#providerdropdown',true,'#loader',pid);
            }
        });
    }

}
function getServiceByIMEIGroup(groupId,callbackDivId,callbackserviceInfoId,loader,loaderDivId,forCart,fordirect){
    if(loader){ $(loaderDivId).show();}

    $.post(urlprefix+'widget/getServiceListIMEI',{groupid: groupId,cart:forCart,direct: fordirect}, function (data, textStatus) {
        $(callbackDivId).empty().append(data);
        $('#service_id').removeClass('chzn-done');
        $('#service_id').show();
        $('#service_id_chzn').remove();
        jQuery(".chosenserv").data("placeholder","Select Service...").chosen();
        if(loader){ $(loaderDivId).hide();}
    });

}

function gotoServiceList(){
    $('#servicelist,#placeorder').toggleClass('d-none');
}

function getServicedetailsIMEI(serviceId,callbackDivId,callbackserviceInfoId,loader,loaderDivId,forCart,fordirect,InfoDivId,chosen,chargeable,reward){

    if(!chosen){
        chosen=1;
    }
    if(!chargeable){
        chargeable=0;
    }

    if(loader){ $(loaderDivId).show();}
    $(callbackDivId).empty();
    $('#service-id').val(serviceId);

    $('.service-list li.active').removeClass('active');
    $('#id_'+serviceId).addClass('active');
    // $('#servicelist,#placeorder').toggleClass('d-none');
    $(window).scrollTop( 0 );

    if(callbackDivId=='#loadDetails'){
        $.post(urlprefix+'widget/getServicedetailsIMEI',{serviceid: serviceId,cart:forCart,price: true,direct: fordirect,chosen:chosen,charge:chargeable}, function (data, textStatus) {

            $(callbackDivId).html(data);
            if(loader){ $(loaderDivId).hide();}
            /*if(InfoDivId){
                getServiceInfoIMEI(serviceId,InfoDivId,true,loaderDivId);
            }else{
                getServiceInfoIMEI(serviceId,callbackserviceInfoId,true,loaderDivId);
            }*/
        });

    }  else {
        $.post(urlprefix+'widget/getServicedetailsIMEI',{serviceid: serviceId,cart:forCart,direct: fordirect,chosen:chosen,charge:chargeable,reward:reward}, function (data, textStatus) {

            $(callbackDivId).html(data);
            if(loader){ $(loaderDivId).hide();}

            /*if(InfoDivId){
                getServiceInfoIMEI(serviceId,InfoDivId,true,loaderDivId);
            }else{
                getServiceInfoIMEI(serviceId,callbackserviceInfoId,true,loaderDivId);
            }*/
        });
    }
}


function generateAffCode(bid,callbackDivId,loaderDivId){
    if(bid!=''){
        $(loaderDivId).show();
        $.post(urlprefix+'widget/generateCode',{banner: bid}, function (data, textStatus) {
            $(callbackDivId).empty().append(data);
            $(loaderDivId).hide();
        });
    }
}
function getIMEIRedirect(serviceId,brand,model){

    var ids=serviceId.split('-');
    $("#quickgroup").val(ids[1]);
    $("#quickitem").val(ids[0]);
    $("#quickbrand").val(brand);
    $("#quickmodel").val(model);
    $("#frmquickwid4").submit();

}
function getIMEIList(serviceId,callbackDivId,callbackserviceInfoId,loader,loaderDivId,forCart){
    if(loader){ $(loaderDivId).show();}
    $.post(urlprefix+'widget/getModelsList',{serviceid: serviceId}, function (data, textStatus) {

        $(callbackDivId).empty().append(data);
        if(loader){ $(loaderDivId).hide();}
        getServiceInfoIMEI(serviceId,callbackserviceInfoId,true,loaderDivId);
    });
    $('#serviceDetails').show();
    // centerThis('.popupWindow');
}
function getProviderList(callbackDivId,serviceId,callbackserviceInfoId){

    $('#loader').show();
    $.post(urlprefix+'widget/getModelsList',{countriid: serviceId}, function (data, textStatus) {

        if(data=='Not Found'){
            $("#servicedropdown").html('');
        }
        if(data){
            $(callbackDivId).empty().html(data);
        }else{
            alert('Please select any country');
        }
        $('#loader').hide();
    });
    $(callbackserviceInfoId).show();
}
function getServiceInfoIMEI(serviceId,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).show();}
    $.post(urlprefix+'widget/getServiceInfoIMEI',{serviceid: serviceId}, function (data, success, textStatus) {


        if(data==''){
            $(callbackDivId).hide();
        }else{
            $(callbackDivId).fadeIn();
            $(callbackDivId).empty().html(data);

            $(callbackDivId).addClass('info');
        }
        if(loader){ $(loaderDivId).hide();}
    });
}
function setFrequent(id,ob)
{
    if(ob.checked){
        $.post(urlprefix+'widget/setFrequent',{serviceid: id}, function (data, success, textStatus) {

        });
    }else{
        $.post(urlprefix+'widget/setFrequent',{serviceid: id,remove: true}, function (data, success, textStatus) {

        });
    }
}
function checkStrength(pass,callbackDivId){

    var small=0;
    var caps=0;
    var nums=0;
    var strength=0;
    try{
        var re = new RegExp("[a-z]",'g');
        if((small=pass.match(re).length)>0){
            if(small>=2){
                strength=strength+20;
            }
        }
    }catch(e){}
    try{
        var ret = new RegExp("[A-Z]",'g');
        if( (caps=pass.match(ret).length)>0){
            if(caps>=2){
                strength=strength+20;
            }
        }
    }catch(e){}
    try{
        var red = new RegExp("[0-9]",'g');
        if((nums=pass.match(red).length)>0){
            if(nums>=1){
                strength=strength+20;
            }
        }
    }catch(e){}
    if(strength>=60){
        var cnt;
        if(small>2){
            cnt =small-2;
            strength=strength+(cnt*10);
        }
        if(caps>2){
            cnt =caps-2;
            strength=strength+(cnt*10);
        }
        if(nums>2){
            cnt =nums-2;
            strength=strength+(cnt*15);
        }
    }



}

// End imei service load

function getServicedetailsFile(serviceId,callbackDivId,callbackserviceInfoId,loader,loaderDivId){
    if(loader){ $(loaderDivId).show();}
    $('#servicelist,#placeorder').toggleClass('d-none');
    $(window).scrollTop( 0 );
    $.post(urlprefix+'widget/getServicedetailsFile',{serviceid: serviceId}, function (data, textStatus) {
        $(callbackDivId).empty().append(data);
        if(loader){ $(loaderDivId).hide();}
        getServiceInfoFile(serviceId,callbackserviceInfoId,true,loaderDivId);
    });
}
function getServices(serviceId,callbackDivId,callbackserviceInfoId,loader,loaderDivId,servicetype){
    if(loader){ $(loaderDivId).show();}

    $.post(urlprefix+'widget/getServices',{id: serviceId,servicetype:servicetype}, function (data, textStatus) {
        $(callbackDivId).empty().append(data);
        if(loader){ $(loaderDivId).hide();}
        getServiceInfoFile(serviceId,callbackserviceInfoId,true,loaderDivId);
    });

}
function getServiceInfoFile(serviceId,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).show();}
    $.post(urlprefix+'widget/getServiceInfoFile',{serviceid: serviceId}, function (data, success, textStatus) {
        if(data==''){
            $(callbackDivId).hide();
        }else{
            $(callbackDivId).fadeIn();
            $(callbackDivId).empty().append(data);
            $(callbackDivId).addClass('info');
        }
        if(loader){ $(loaderDivId).hide();}

    });

}


function getSearch(val){
    $.post(urlprefix+'widget/getSearchProducts',{search: val}, function (data, textStatus) {
        if(data)
        {
            $("#searchresult").empty().append(data).slideDown();
        }
        else{
            $("#searchresult").slideUp();
        }
    });
}
function getKnowledgebaseSearch(url,item,info){

    $.post(url,{search: item}, function (data, textStatus) {
        $("#searchKnowledgebase").slideDown('fast');
        $("#notification1").show('fast');
        $("#searchKnowledgebase").empty().append(data);
    });
}

// Server service load

function getServicedetailsServer(serviceId,callbackDivId,callbackserviceInfoId,loader,loaderDivId,forCart){
    if(loader){ $(loaderDivId).show();}
    $.post(urlprefix+'widget/getServicedetailsServer',{serviceid: serviceId,cart:forCart}, function (data, textStatus) {
        $(callbackDivId).empty().append(data);
        if(loader){ $(loaderDivId).hide();}
        getServiceInfoServer(serviceId,callbackserviceInfoId,true,loaderDivId);
    });
}
function getServiceInfoServer(serviceId,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).show();}
    $.post(urlprefix+'widget/getServiceInfoServer',{serviceid: serviceId}, function (data, success, textStatus) {
        if(data==''){
            $(callbackDivId).hide();
        }else{
            $(callbackDivId).fadeIn();
            $(callbackDivId).empty().append(data);
            $(callbackDivId).addClass('info');
        }
        if(loader){ $(loaderDivId).hide();}

    });

}
// product load
function getServicedetailsProduct(serviceId,callbackDivId,callbackserviceInfoId,loader,loaderDivId,forCart){
    if(loader){ $(loaderDivId).show();}
    $.post(urlprefix+'widget/getServicedetailsProduct',{serviceid: serviceId,cart:forCart}, function (data, textStatus) {
        $(callbackDivId).empty().append(data);
        if(loader){ $(loaderDivId).hide();}
        getServiceInfoProduct(serviceId,callbackserviceInfoId,true,loaderDivId);
    });
}

function getServiceInfoProduct(serviceId,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).show();}
    $.post(urlprefix+'widget/getServiceInfoProduct',{serviceid: serviceId}, function (data, success, textStatus) {
        if(data==''){
            $(callbackDivId).hide();
        }else{
            $(callbackDivId).fadeIn();
            $(callbackDivId).empty().append(data);
            $(callbackDivId).addClass('info');
        }
        if(loader){ $(loaderDivId).hide();}
    });
}

function checkUsername(user,notification,loader,loaderDivId)
{
    if (window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var callback_data = xmlhttp.responseText.split(":");
            if(callback_data[0]=='success'){
                //document.getElementById(notification).className='successbox';
                //document.getElementById(notification).innerHTML=callback_data[1];
            }

            if(callback_data[0]=='error'){
                //document.getElementById(notification).className='errorbox';
                //document.getElementById(notification).innerHTML=callback_data[1];
            }

        }
    }
    xmlhttp.open("GET","widget/checkUser?username="+ user,true);
    xmlhttp.send();
}



function getServiceInfoFile(serviceId,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).show();}
    $.post(urlprefix+'widget/getServiceInfoFile',{serviceid: serviceId}, function (data, success, textStatus) {
        if(data==''){
            $(callbackDivId).hide();
        }else{
            $(callbackDivId).fadeIn();
            $(callbackDivId).empty().append(data);
            $(callbackDivId).addClass('info');
        }

        if(loader){ $(loaderDivId).hide();}
    });

}

$(document).ready(function(){



    $('.check-strength').keypress(function(){

        if($(this).val().length!=0){

            setTimeout(function(){
                var parent=$('.check-strength').parents('.controls');
                $(parent).find('.password-meter').removeClass('veryweak');
                $(parent).find('.password-meter').removeClass('weak');
                $(parent).find('.password-meter').removeClass('ok');
                $(parent).find('.password-meter').removeClass('strong');
                $(parent).find('.password-meter').removeClass('verystrong');

                if($(parent).find('.password-strength').length==0){
                    $(parent).append('<div class="password-strength"><span class="password-status"></span><div class="password-meter"></div></div>');
                    $('.password-strength').fadeIn();
                }

                $.post('widget/checkPassword',{val: $('.check-strength').val()},function (data, success, textStatus) {

                    $(parent).find('.password-status').empty().append(data);
                    $(parent).find('.password-meter').addClass(data.replace(' ',''));
                });
            },1);
        }
    });


    var timer1;
    $('#searchlistbox').keyup(function(e){
        if($(this).val().length>2){
            $(this).addClass('loading');
            clearInterval(timer1);
            timer1 = setTimeout(function() {
                $("#articlebox").show();
                $.post(urlprefix+'includes/getdata/article',{art: $('#searchlistbox').val()}, function (data, success, textStatus) {
                    $('#articlebox').html(data);
                    $(this).removeClass('loading');
                });
            }, 500);

        }else{
            $("#articlebox").hide();
            $(this).removeClass('loading');
        }

    });


    $('#storeamount').keydown(function(event) {
        var vals=$(this).val();
        if(vals!=""){
            $.post(urlprefix+'modules/gateways/callback/storepaypal',{taxcal: vals}, function (data, success, textStatus) {
                $('#taxcal').val(data);
            });
        }
    });
    $('#storeamount').keyup(function(event) {
        var vals=$(this).val();
        if(vals!=""){
            $.post(urlprefix+'modules/gateways/callback/storepaypal',{taxcal: vals}, function (data, success, textStatus) {
                $('#taxcal').val(data);
            });
        }
    });
    $('#storeamount').blur(function(event) {
        var vals=$(this).val();
        if(vals!=""){
            $.post(urlprefix+'modules/gateways/callback/storepaypal',{taxcal: vals}, function (data, success, textStatus) {
                $('#taxcal').val(data);
            });
        }
    });
    $('#notification').click(function(){
        $(this).slideUp();
    });

    filterlist();
    oddEven();
    //addToCompare();
    $('body').click(function(){
        $('.serchcontent').slideUp('fast');
    });
});
function setquickValue4(mid,bid,obj){
    //$("#brand").val(bid);
    //$("#model").val(mid);
    // getServiceList('#servicedropdown',mid,bid,'#serviceload');
}
function setquickValue(mid,bid,obj){
    $("#brand").val(bid);
    $("#model").val(mid);
    $("#modelsearch").val($(obj).text());
    $("#modelslist").hide();
    getServiceList('#servicedropdown',mid,bid,'#serviceload');

}
function setquickValue2(mid,bid,obj){
    $("#brand").val(bid);
    $("#model").val(mid);
    $("#modelsearch").val($(obj).text());
    $("#modelslist").hide();
    getServiceList('#countrydropdown',mid,bid,'#countryload');
}

function quickModel1(obj){
    delay(function(){
        $('.quick-loader').show();
        $(obj).addClass('loading');
        var model=$(obj).val();

        if(model.length>1){
            $.post(urlprefix+'widget/searchmodel',{val: model,imei:true},function (data, success, textStatus) {

                $("#modelslist").html(data);
                $("#modelslist").slideDown();
                $('.quick-loader').hide();
                $(obj).removeClass('loading');
            });
        }else{
            $("#modelslist").slideUp();
            $('.quick-loader').hide();
            $(obj).removeClass('loading');
        }
    },500);
}
function quickModel(obj){
    delay(function(){
        $('.quick-loader').show();
        $(obj).addClass('loading');
        var model=$(obj).val();
        if(model.length>1){
            $.post(urlprefix+'widget/searchmodel',{val: model},function (data, success, textStatus) {

                $("#modelslist").html(data);
                $("#modelslist").slideDown();
                $('.quick-loader').hide();
                $(obj).removeClass('loading');
            });
        }else{
            $("#modelslist").slideUp();
            $('.quick-loader').hide();
            $(obj).removeClass('loading');
        }
    },500);
}



function checkDiscount(txtDiscount){
    var yourCredit=document.getElementById('yourDis_'+txtDiscount).value;
    var newCredit=document.getElementById('new_'+txtDiscount).value;
    if(parseFloat(yourCredit) > parseFloat(newCredit)){
        alert('New Price must be greater then Your Price');
        document.getElementById('new_'+txtDiscount).value='';
    }
}

function filterlist(){
    $('.searchForm h6').click(function(){
        $('.searchForm form').slideToggle('slow');
    });
}

function oddEven(){
    $('.data tr:odd').addClass('odd');
    $('.data tr:even').addClass('even');
}
function viewminicart(cartdivid){
    $.post(urlprefix+'cart',{action: 'viewmini'}, function (data, success, textStatus) {
        $(cartdivid).empty().append(data);
        $('.cartminiview').empty().append(data);
    });
}
function cartreload(divid,val,gatewayid){
    $("#loader").show();
    $.post(urlprefix+'cart',{action: 'checkout_reload' ,shippingid: val,gatewayid:gatewayid}, function (data, success, textStatus) {
        $(divid).empty().append(data);
        $("#loader").hide();
    });
}
function getModelslist(divid,val,divload){
    $("#loader").show();
    $(divload).show();
    $.post(urlprefix+'widget/getModelsList',{action: 'checkout_reload' ,brand: val }, function (data, success, textStatus) {
        $(divid).empty().append(data);
        $("#loader").hide();
    });
    shippingdropdown('#shippingdropdown');
}
function closeCookie(){
    $("#COOKIELAW").hide();
    $.post(urlprefix+'widget/saveCookie?close=true', function(data) {

    });
}
function changeSettings(){
    $("#COOKIELAW").hide();
    $("#COOKIESETT").show();
}

function getServiceList(divid,val,brand,divload){
    $("#loader").show();
    $(divload).show();
    $.post(urlprefix+'widget/getModelsList',{action: 'checkout_reload' ,model: val,brand: brand }, function (data, success, textStatus) {

        $(divid).empty().append(data);
        $("#loader").hide();
    });
    $('#serviceDetails').hide();
    shippingdropdown('#shippingdropdown');
}
function getServiceList2(divid,provider,country,divload){
    $("#loader").show();
    $(divload).show();
    $.post(urlprefix+'widget/getModelsList',{action: 'checkout_reload' ,provider: provider,country: country,checkout: 3 }, function (data, success, textStatus) {
        $(divid).empty().append(data);
        $("#loader").hide();
    });
    $('#serviceDetails').hide();
    shippingdropdown('#shippingdropdown');
}

function shippingRequired()
{
    $.post(urlprefix+'widget/getshipping',function (data, success, textStatus) {
        if(data='required'){

        }
    });
}

function checkoutreload(divid,val,promotion,shippingaddress){

    $("#loader").show();
    $.post(urlprefix+'cart',{action: 'checkout_reload' ,shippingid: val ,promotioncode:promotion}, function (data, success, textStatus) {

        $(divid).empty().append(data);
        // $("#loader").hide();
    });
    shippingdropdown('#shippingdropdown',shippingaddress);
}
function saveCart(){
    $("#loader").show();
    $.post(urlprefix+'includes/gatedata/saveCart?save=true', function (data, success, textStatus) {
        if(data){
            $('#notification').addClass('successbox');
            $('#notification').empty().append(data);
        }
        $("#loader").hide();
    });

}
function shippingdropdown(divid,shippingaddress,gateway){
    $("#loader").show();
    $.post(urlprefix+'shippingcost',{action: 'shippingdropdown',paymentgateway:gateway,country:shippingaddress.country_code,state:shippingaddress.state_code,city:shippingaddress.city,latitude:shippingaddress.latitude,longitude:shippingaddress.longitude}, function (data, success, textStatus) {
        $(divid).empty().append(data);
        $("#loader").hide();
    });

}
function setval(vals){
    $("#curriers").val(vals);
}
function toggleslide(divid){
    $(divid).slideToggle();
}
function addToCompare(pid,flag){
    $("#loader").show();
    $.post(urlprefix+'includes/cart',{serviceid : pid, action : 'compare', bycheckbox : true}, function (data, success, textStatus) {
        if(data!=''){
            if(data>1){
                $('#viewCompare').fadeIn('slow');
            }
            else{
                $('#viewCompare').hide();
            }
            if(data){

            }else{
                $('#viewCompare').hide();
            }
        }
    });

    $.post(urlprefix+'cart',{serviceid : pid, action : 'compare', bycheckbox : true}, function (data, success, textStatus) {
        if(data!=''){
            $('.compare_item').empty().append(data);

            if(flag){
                $("#add_"+pid).removeAttr("checked");
            }
        }
    });
    $("#loader").hide();
}
function getCCGateway(val){
    if(val=='cc'){
        $("#creditcard").show();
    }else{
        $("#creditcard").hide();
    }



}
function addtocart(item,qnt){
    if(!qnt){
        qnt=1;
    }
    $("#loader").show();
    $.post(urlprefix+'includes/cart',{servicetype : 'product',bycheckbox:true ,id: item ,quantity:qnt,addremove:document.getElementById(item).checked}, function (data, success, textStatus) {
        viewminicart('#cartminiview');
        $("#loader").hide();
    });
}
function getTotalConfigPrice(ob){

    var price= parseFloat($("#actualprice").html());
    var extra =0;

    $('select').each(function(){
        if($(this).attr('class')=='customfield'){

            if(isNaN($("option:selected", $(this)).attr("class"))){
            }else{
                if($("option:selected",$(this)).attr("class")!=''){

                    price = price+parseFloat($("option:selected",$(this)).attr("class"));
                }
            }
        }
    });
    $("#ourfinalprice").empty().append(price);
}
function setGatewayInfo(val){

    if(val=='googlecheckout'){
        $("#note").empty().append('Write Google checkout Account ID');
    }else if(val=='moneybookers'){
        $("#note").empty().append('Write Moneybookers Account ID');
    }else if(val=='paypal'){
        $("#note").empty().append('Write Paypal Account ID');
    }else if(val=='paypal_mass_pay'){
        $("#note").empty().append('Write Paypal Account ID');
    }else{
        $("#note").empty().append('');
    }
}


function copyToClip(str) {
    function listener(e) {
        e.clipboardData.setData("text/html", str);
        e.clipboardData.setData("text/plain", str);
        e.preventDefault();
    }
    document.addEventListener("copy", listener);
    document.execCommand("copy");
    document.removeEventListener("copy", listener);
};
