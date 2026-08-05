{literal}
<script type="text/javascript">

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
                                $(o.searchObj,obj).each(function() {
                                    text = $(this).text();
                                    if (text.match(RegExp(searchWord, 'i'))) {
                                        $(this).parents('tr,li').addClass('display-block');
                                        $('.not-found').fadeOut();
                                    }
                                    else{
                                        $(this).parents('tr,li').removeClass('display-block');
                                    }
                                });
                            }else{
                                $('tr,li',obj).addClass('display-block');
                            }

                            $('.group-service').each(function(){
                               if($(this).find('.display-block').length=='0'){
                                  $(this).find('h3').css({'display':'none'});
                               }
                               else{
                                   $(this).find('h3').css({'display':'block'});
                               }
                            });

                            if($('.group-service').find('.display-block').length=='0'){
                                $('.not-found').fadeIn();
                            }

                        });
                    });
                }
            });
        })(jQuery);

$(document).ready(function(){
   $('.searchservice').searchService({searchBox:'#searchservicebox'});
    tooltipIcon();

    var flag;
   $("#searchservicebox2").keyup(function(e){
     flag=1;
     $('.searchservice2').show();
     $('.service-details').hide();
     var filter = $(this).val();
            $(".service-list li").each(function(){
                if ($(this).text().match(RegExp(filter, 'i'))) {
                    $(this).show();
                    flag=0;
                } else {
                    $(this).hide();
                }
            });
         if(flag){
            $('.not-found').show();
         }
         else{
            $('.not-found').hide();
         }
    });


});

function tooltipIcon(){
    $('.service-feature,.icons').tooltip({
        selector: "i[data-toggle='tooltip']"
    });
}

function serviceDetails(serviceid){
    $('#service_id').val(serviceid);
    $('.list-services').hide();
    $('.service-details').fadeIn();
    $('.service-details').ajaxComplete(function() {
            tooltipIcon();
    });

}
function showservices(){
   $('.service-details').hide();
   $('.list-services').fadeIn();
}
$(function () {
    $('#pin').keypad();
});

 function setName(name,id){
    $('#service-name').text(name);
    $('#service-id').val(id);
    $('.alert1,.alert').hide();
    $('.searchservice2').hide();
    $('.service-details').show();
}



</script>

<style>
     .page-header {
        border:none
    }
    .service-details{display:none}
</style>

{/literal}

<div class="subcontainerfullwidth">


  <div id="formstyle_1" style="position:relative">
    <form method="post" name="serverorder_form" id="serverorder_form" >

      <fieldset>

      {$token}
      <input type="hidden" name="id" id="service_id" value=""/>

    {if $ordertype eq 1}
          {literal}
            <style>
                .back-btn{display:none;}
            </style>
          {/literal}
    {/if}


{if $ordertype eq 2}

        {literal}
            <style>
                .service-details{display:none}
                .service-info {
                    background: rgba(0, 0, 0, 0.05) none repeat scroll 0 0;
                    border-bottom: 1px solid #999999;
                    font-size: 14px;
                    height: 130px;
                    padding: 10px;
                    cursor:pointer
                }
                .service-feature{position:absolute;top:120px;}
                .service-feature span{background:#666;color:white;font-size:12px;text-transform:uppercase;padding:0 5px}
                .time-tag{position:absolute;top:10px;right:10px;background:green;color:white;font-size:12px;padding:0 5px;}
                .searchme{font-size:14px;}
                .service-price{font-size:17px;}
            </style>
        {/literal}

            <div class="list-services">


        <!--
            <div class="input-append pull-right">
            <form method="post" action="placorder.php">
            <input type="hidden" name="searchby" value="imei" />
                <input type="text" name="search" id="searchservicebox" class='input-large'
                 placeholder="{$lang.searchservice}"/>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn dropdown-toggle">{$lang.morefilter} <span class="caret"></span></button>
                    <ul class="dropdown-menu  pull-right more-filter" style="padding:10px;">
                      <li>
                         {$lang.group} : <select class="chosen" name="group" class="chosen"  style="width:470px">
                          		<option value="">{$lang.select}</option>
                               {foreach from=$grouparr key=ids item=Services}
                                 <option   value="{$ids}" >{$Services}</option>
                               {/foreach}
                          </select>
                      </li>
                      <li class="divider"></li>
                      <div>
                          <li>
                             {$lang.brand} : <select name="brand" id="brand"  onchange="getModelslist('#modelsdropdown2',this.value,'#modelload');">
                                <option value="">-{$lang.selectbrand}-</option>
                                {foreach from=$brandarr key=id item=order}
                                 {if $order}
                                    <option value="{$id}">{$order}</option>
                                 {/if}
                                {/foreach}
                            </select>
                           &nbsp;&nbsp;&nbsp; {$lang.model} :  <span id="modelsdropdown2"></span>
                          </li>
                      </div>
                      <li class="divider"></li>
                      <li><input type="submit" class="btn" value="Search"/></li>
                    </ul>
                 </div>
              </form>
            </div>
         -->
            <div class="clear"></div>

              <div class="not-found" style="display:none">{$lang.resultnotfound}</div>

              <div  class="searchservice">
                   {foreach from=$serverservicelist key=GroupName item=Services}
                       <div class="group-service accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" href="javascript:void(0)">{$GroupName}</a>
                            </div>
                            <div class="row-fluid">
                                {foreach from=$Services key=ServicesID item=ServicesI}
                                    <div style="background:url('{$ServicesI.image_link}') no-repeat center;" class="display-block " onclick="getServicedetailsServer('{$ServicesID}','#serviceDetails2','.alert',true,'#loader','','','#information');serviceDetails('{$ServicesID}');" >

                                            <div class="service-info">{$ServicesI.info|strip_tags|truncate:150:"..."}</div>
                                            <div class="service-feature">{if $ServicesI.imei_bulk eq 1} <i class="icon-th" data-toggle="tooltip" data-original-title="Bulk&nbsp;IMEI"></i> {/if} {if $ServicesI.type eq 'Database'} <i class="icon-tasks" data-toggle="tooltip" data-original-title="Database"></i> {/if} {if $ServicesI.type eq 'Calculator'} <i class="icon-th" data-toggle="tooltip" data-original-title="Calculator"></i> {/if} {if $ServicesI.type eq 'Other'} <i class="icon-certificate" data-toggle="tooltip" data-original-title="Other"></i> {/if} {if $ServicesI.verifiable} <i class="icon-retweet" data-toggle="tooltip" data-original-title="Verifiable"></i> {/if} {if $ServicesI.usercan_cancel} <i class="icon-remove" data-toggle="tooltip" data-original-title="Can&nbsp;Cancel"></i> {/if}</div>

                                            <div class="time-tag{if $ServicesI.time eq ' Instant'} instant{/if}">{$ServicesI.time}</div>

                                        <div  class="searchme">{$ServicesI.service_name}</div>
                                         <div class="service-price{if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount} {/if}
                                            {if $ServicesI.credit eq '0'} free{/if}">
                                            <span class="prefix">{$currency.prefix}</span> {$ServicesI.credit-$ServicesI.discount}<span class="suffix">{$currency.suffix}</span>
                                         </div>

                                    </div>
                                {/foreach}
                                <div class="clearfix"></div>

                            </div>

                       </div>
                       <br /><br />
                   {/foreach}
              </div>


            </div>

      {else}


    <div>
    <div  class="action-bar">
            <div style="position:relative;">
                <i class="fa fa-search" style="position:absolute;left:10px;top:10px;"></i>
                    <input type="text" placeholder="{$lang.search} {$lang.service}..."
                    id="searchservicebox2"  autocomplete="off"
                    style="width:100%;padding:9px 40px; box-sizing: border-box;background:#fafafa;border:none"/>
                <span  onclick="javascript:$('#searchservicebox2').val('').keyup();" style="position: absolute; right: 12px; top: 8px;cursor:pointer;"> X </span>
            </div>
    </div>
            <div class="searchservice2"> <br />
                <ul  class="service-list">
                {foreach from=$serverservicelist key=GroupName item=Services}
                     <li> <!--
<a  class="service-heading" href="javascript:void(0)">{$GroupName} </a>
-->
                        <ul>
                             {foreach from=$Services key=ServicesID item=ServicesI}
                                <li>

                                <div class="pull-left">
                                    <span class="service-ic">{$ServicesI.service_name|substr:0:2}</span>
                                 </div>

                                 <div class="pull-left">
                                 <a style="display:block" href="javascript:void(0)" {if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount} title="Discounted Service" {/if}  onclick="javascript:setName('{$ServicesI.service_name}','{$ServicesID}');getServicedetailsServer('{$ServicesID}','#serviceDetails2','.alert',true,'#loader','','','#information');">
                                {$ServicesI.service_name}
                                <br />

                                <small style="color:#888">
                                {$GroupName}
                                    <span class="{if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount} discount_text {/if} service-price2"> {if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount} <i class="fa fa-tags"></i>{/if}   {$ServicesI.credit-$ServicesI.discount} {$lang.credit} </span> <span  class="time"> {$ServicesI.time}</span>    <div class="clearfix"></div>
                                </small>
                                </a>
                               </div>
                              <div class="clearfix"></div>
                                 </li>

                             {/foreach}
                             <div class="clear"></div>

                        </ul>
                     </li>
                {/foreach}
                </ul>
                <div class="not-found" style="display:none">{$lang.resultnotfound}</div>
            </div>
    </div>

       {/if}


  <div>
        <div class="service-details">
             <input type="hidden" id="service-id" name="id"/>
            <table><tr><td><span onclick="javascript:$('#searchservicebox2').val('').keyup();" style="font-size:40px;cursor:pointer">&larr; &nbsp;&nbsp;</span> </td><td> <h4 id="service-name"  style="font-size:25px;font-weight:400;margin-top:20px;">   </h4> </td></tr></table>

            <div id="serviceDetails2">

                </div>
            <br />
        </div>
     </div>

      <div class="clearfix"></div>


</fieldset>
        </form>
      </div>
    </div>
</div>
