<script src="includes/js/chosen.jquery.js"></script>
<link rel="stylesheet" href="includes/css/chosen.css" />

{literal}
<script type="text/javascript">
$(document).ready(function(){
   $('.searchgroup').searchFromList({searchBox:'#searchgroupbox'});
});
function getServiceByIMEIGroup2(id,loaderDivId,callbackDivId){
    if(loader){ $(loaderDivId).show();}
    $.post(urlprefix+'widget/getServiceListIMEIGroupwise',{groupid: id}, function (data, textStatus) {
        $(callbackDivId).html(data);
        $(callbackDivId).show();
        if(loader){ $(loaderDivId).hide();}
        tabSelection();
        $('.searchservice').searchFromList({searchBox:'#searchservicebox'});
    });
}

function serviceDetails(serviceid){
    $('#service_id').val(serviceid);
    tabSelection();
}

function tabSelection(){
    var cActive=$('.nav-tabs .active');
    $(cActive).removeClass('active');
    $(cActive).next().addClass('active');

    var pActive=$('.tab-content .active');
    $(pActive).removeClass('active');
    $(pActive).next().addClass('active');
}
</script>
<style>
    .searchservice,.searchgroup{margin:0;}
    .searchservice li,.searchgroup li{list-style: none;}
</style>
{/literal}
<div id="tabcontent">

  <div id="formstyle_1">
    <form class="form-inline frm-inline" method="post" name="imeiorder_form" id="imeiorder_form">
      <fieldset>

      {$token}
      <input type="hidden" name="id" id="service_id" value=""/>


<div class="tabbable tabs-below">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#tab1">{$lang.groups}</a></li>
    <li><a data-toggle="tab" href="#tab2">{$lang.services}</a></li>
    <li><a data-toggle="tab" href="#tab3">{$lang.placeorder}</a></li>
  </ul>

     <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                {if $ordertype eq 2}
                   <div class="row-fluide">
                        <input type="text" name="search" id="searchgroupbox"   placeholder="{$lang.searchsgroup}"/>
                        <ul class="searchgroup">
                            {foreach from=$imeigroup key=ID item=Group}
                                <li  class="group-list item-block pull-left" id="{$ID}" onclick="getServiceByIMEIGroup2(this.id,'#loader','#loadservices');"><span class="searchme">{$Group.name}</span></li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}
                <div class="clearfix"></div>
            </div>


           <div class="tab-pane" id="tab2">
              <input type="text" name="search" id="searchservicebox"   placeholder="{$lang.searchservice}"/>
              {if $ordertype eq 2}
                <div id="loadservices"></div>
              {else}
                <div class="form-group "><label class="form-label">{$lang.services}</label><div class="controls"></div></div>
               {/if}
              <div class="clearfix"></div>
            </div>


           <div class="tab-pane service-details" id="tab3">
                <div>
                    <div    class="alert"></div>
                       {if $infopos neq 2}
                        <div id="information" ></div>
                      {/if}

                      <div id="serviceDetails"></div>
                      <div class="form-group "><label class="form-label">{$lang.notes}:</label><div class="controls"><input type="text" name="notes"  /><br /><small>{$lang.additionalnote}</small></div></div>
                      <div class="form-group "><label class="form-label">{$lang.comments}:</label><div class="controls"><textarea name="comments" cols="30" rows="2" ></textarea><br /><small>{$lang.remember}</small></div></div>
                      <div class="form-group "><label class="form-label">{$lang.responsemail}:</label><div class="controls"><input type="text" name="response"  /><br /><small>{$lang.responseinfo}</small></div></div>
                      {if $pin eq 1}
                      	<div class="form-group "><label class="form-label">{$lang.masterpin}:</label><div class="controls"><input type="password" id="pin" name="pin" maxlength="4" /><br /></div></div>
                      {/if}
                      {if $smsgateway}
                      <div class="form-group "><label class="form-label">{$lang.responseno}:</label><div class="controls">
                        {if $responseno}
                            <input type="radio" name="no" value="1" /> {$responseno}<br />
                            <input type="radio" name="no" value="2" /> <input type="text" name="otherno" /><br/><small>{$lang.mobilenumber}</small>
                        {else}
                            <input type="text" name="otherno" /><br/><small>{$lang.mobilenumber}</small>
                        {/if}
                      </div></div>
                      {/if}

                      <div class="form-group ">
                      	<span><button type="submit" class="btn btn-primary waves-effect waves-light" id="placeorder" onclick="SubmitForm('#placeorder','{$actionlink}','#imeiorder_form','.alert','true','#loader');" value="{$lang.placeorder}" >{$lang.placeorder}</button>  </span></div>
                      {if $infopos eq 2}
                        <div id="information" ></div>
                      {/if}
                  </div>
              </div>

         </div>
  </div>


      </fieldset>
    </form>
  </div>
</div>
</div>
{include file="templates/default/client_order_rightmenu.tpl"}
