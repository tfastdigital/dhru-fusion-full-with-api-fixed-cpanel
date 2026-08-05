

function getModels(bId,serviceId,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).show();}

    $.post(urlprefix+'widget/getModels',{bid: bId,serviceid: serviceId}, function (data, success, textStatus) {
        $("#modelsTr").show();
		if(loader){ $(loaderDivId).hide();}
        $(callbackDivId).fadeIn();
        $(callbackDivId).html(data);

    });
}
function getWidModels(bId,serviceId,callbackDivId,loader,loaderDivId,model){
    if(loader){ $(loaderDivId).show();}
    $.post(urlprefix+'widget/getModels',{bid: bId,serviceid: serviceId,mid: model}, function (data, success, textStatus) {
        $("#modelsTr").show();
        $(callbackDivId).fadeIn();
        $(callbackDivId).html(data);
        if(loader){ $(loaderDivId).hide();}
    });
}
function updateCartQnt(pid,qnt){
	var uqnt = { pid:qnt};
	$.post(urlprefix+'cart',{update: true,qnt:uqnt}, function (data, success, textStatus) {

	});
}

function getWidProvider(bId,serviceId,callbackDivId,loader,loaderDivId,model){
    if(loader){ $(loaderDivId).show();}
    $.post(urlprefix+'widget/getProvider',{cid: bId,serviceid: serviceId,pid: model}, function (data, success, textStatus) {
        $("#providerTr").show();
        $(callbackDivId).fadeIn();
        $(callbackDivId).html(data);
        if(loader){ $(loaderDivId).hide();}
    });
}
function getModelImage(bId,serviceId,callbackDivId,loader,loaderDivId){

    $.post(urlprefix+'widget/getModels?image=true',{bid: bId,serviceid: serviceId}, function (data, success, textStatus) {
        $(callbackDivId).fadeIn();
        $(callbackDivId).html(data);
    });
}
function getProvider(cId,serviceId,callbackDivId,loader,loaderDivId){
    if(loader){ $(loaderDivId).show();}
    $.post(urlprefix+'widget/getProvider',{cid: cId,serviceid: serviceId}, function (data, success, textStatus) {

        $("#providerTr").show();
        $(callbackDivId).fadeIn();
        $("#providerload").remove();
        $(callbackDivId).html(data);
        if(loader){ $(loaderDivId).hide();}
    });
}


function checknumber(x)
{
	var out
	var valid=/(^\d+$)|(^\d+\.\d+$)/;
	if (valid.test(x))
		out=true;
	else
		out=false;
	return out;
}
function removeNotDigits(imei)
{
	var anum=/(^\d+$)|(^\d+\.\d+$)/;
	for(var i=0;i<imei.length;i++)
	{
		if (!anum.test(imei.charAt(i)))
			imei = imei.replace(imei.charAt(i),"0");
	}
	return imei;
}
function luhnCheck()
{
		var imei = document.getElementById('imei1').value;
		var step2 = 0;
		var step2a = 0;
		var step2b = 0;
		var step3 = 0;
		for(var i=imei.length;i<14;i++)
			imei = imei + "0";
		for(var i=1;i<14;i=i+2)
		{
			var step1 = (imei.charAt(i))*2 + "0";
			step2a = step2a + parseInt(step1.charAt(0)) + parseInt(step1.charAt(1));
		}
		for(var i=0;i<14;i=i+2)		step2b = step2b + parseInt(imei.charAt(i));
		step2 = step2a + step2b;
		if(step2%10 == 0)
			step3 = 0;
		else
			step3 = 10 - step2%10;
			if(checknumber(step3))
			document.getElementById('imei2').value = step3;

		else
		{
			document.getElementById('imei1').value = removeNotDigits(document.getElementById('imei1').value);
			luhnCheck();
		}
}
function remove_imei2(){
	if(document.getElementById('imei1').value == '' ){
		document.getElementById('imei2').value = '';
	}
}
function add_imei()
{
	if($('#imei1').length){
		var imei = document.getElementById('imei1').value + document.getElementById('imei2').value;
		if(imei.length == 15)
		{
			if(document.getElementById('imei_bulk').value == ''){
				document.getElementById('imei_bulk').value = imei;
			}else{
				document.getElementById('imei_bulk').value = document.getElementById('imei_bulk').value + "\r\n" + imei;
			}
			document.getElementById('imei1').value = '';
			document.getElementById('imei2').value = '';
		}
	}
}

function add_serialno()
{
	var imei = document.getElementById('imei_custom').value;
	if(imei){
		if(document.getElementById('imei_bulk').value == ''){
			document.getElementById('imei_bulk').value = imei;
		}else{
			document.getElementById('imei_bulk').value = document.getElementById('imei_bulk').value + "\r\n" + imei;
		}
	}
	document.getElementById('imei_custom').value = '';
}

