{literal}
    <script type="text/javascript">
        $(document).ready(function(){
            $('.service-list').searchService({searchBox:'#searchservicebox2'});
        });

        function popupOrder(ServicesID,servicename){
            if(servicename==''){
                servicename='Place Order';
            }
            $('.service-title').text(servicename);
            $('#service-id').val(ServicesID);

            $('#modal-order').show();
            getServicedetailsIMEI(ServicesID,'#serviceDetails2','.alert',true,'#loader2','','','#information',0,'',1);
        }
    </script>
{/literal}

{if $ismobile}
    <style>
        .h-100{
            height: auto !important;
        }
        .text-uppercase{
            display: none !important;
        }
    </style>
{/if}


{assign var=theme value=$userdetails.themesettings|json_decode:1}


    {function name=getservicedetail}
        <input type="hidden" id="service-id" name="id"/>
        <input type="hidden" id="service-name" name="servicename"/>
        <div id="serviceDetails2" class="position-relative h-100 d-flex flex-column">
            <div class="">
                <h2 class="p-5 text-center mt-5" style="color:#ccc;font-weight:100;">
                    {if $theme.orderstyle eq 2}
                        <i class="fal fa-arrow-up"></i>&nbsp;&nbsp;
                    {else}
                        <i class="fal fa-arrow-left"></i>&nbsp;&nbsp;
                    {/if}
                    <div>
                        {$lang.select} {$lang.service}
                    </div>
                </h2>
            </div>
        </div>
        <div id="loader2" style="display: none">
            <div class="position-absolute d-flex justify-content-center align-items-center w-100 h-100 text-center" style="top:0;left:0;">
                <div class="ajax-responsive loading"></div>
            </div>
        </div>
    {/function}


    {function name=servicefilter}

        <div class="card  card-search mb-4 bottom-space">
    <div class="form-inline">
        <div class="form-group pr-3 d-none d-lg-block">
            <i class="fal fa-search"></i>
        </div>
        <div class="form-group w-25">
                <select class="form-control" onChange="loadItems(this.value)">
                    <option value="">{$lang.all} {$lang.group}</option>
                    {foreach from=$imeiservicelist key=GroupName item=Services}
                        <option value="{str_replace("*","",$GroupName|substr:0:2)}">{$GroupName}</option>
                    {/foreach}
                </select>
            </div>

            <div class="form-group mb-0">
                <input type="text"   class="form-control " placeholder="{$lang.search} {$lang.service}..." id="searchservicebox2"  autocomplete="off" />
            </div>

        </div>
</div>

    {/function}



    <div class="container h-100">  <div class="page-container">
        <form method="post" name="imeiorder_form2" id="imeiorder_form" class="h-100">
            {$token}
            {if $theme.orderstyle neq '2'}
                {call name=servicefilter}
            {/if}
                <div class="h-100 d-flex w-100 flex-column">

                    {if $theme.orderstyle eq '3' || $ismobile || $action eq 'placeorder'}

                        <div  class="service-list">
                            {foreach from=$imeiservicelist key=GroupName item=Services}

                                <div>
                                    <h3 class="title"><span>{$GroupName}</span> </h3>
                                </div>

                                <div class="row group active  g_{str_replace("*","",$GroupName|substr:0:2)}">
                                    {foreach from=$Services key=ServicesID item=ServicesI}
                                        <div class="col-lg-4 col-md-6  mb-4  bottom-space cursor-pointer service active {if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount} discounted {/if}" id="id_{$ServicesID}"  {if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount} title="{$lang.discounted} {$lang.services}" {/if}   onclick="popupOrder('{$ServicesID}','{$ServicesI.service_name}');">
                                            <div class="card w-100 h-100   rounded">
                                                <div class="row h-100">
                                                    <div class="col-auto">
                                                        <div class="bg-gray  h-100 d-flex align-items-center p-3 p-sm-3 text-uppercase">{str_replace("*","",$GroupName|substr:0:2)}</div>
                                                    </div>
                                                    <div class="col p-0 mw-360">
                                                        <div class="pt-3 pb-3">
                                                            <span  class="searchme"> {$ServicesI.service_name} </span> {if $ServicesI.newservice eq 1}<span class="textred">{$lang.new}</span>{/if}
                                                            {if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount}
                                                                &nbsp;&nbsp;&nbsp; <span style="color: #009fff;"> <i class="fal fa-tags"></i></span>
                                                            {/if}
                                                            <br />
                                                            <div class="text-muted">
                                                                {$GroupName}
                                                            </div>
                                                            <span>
                                                                {$ServicesI.purchasepoint} {$lang.point}
                                        				    </span>
                                                            <span class="badge badge-warning">
														   {$ServicesI.time}
														</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            {/foreach}
                        </div>


                        <div id="modal-order" class="modal     modal-ajax" tabindex="-1" style="display: none">
                            <div class="backdrop-over"></div>
                            <div class="modal-dialog modal-dialog-centered modal-lg mx-auto">
                                <div class="modal-content rounded">
                                    <div class="modal-header">
                                        <h5 class="modal-title service-title">{$lang.placeorder} IMEI</h5>
                                        <button type="button" class="close" onclick="$('#modal-order').hide()"  aria-hidden="true"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        {call name=getservicedetail}
                                    </div>
                                </div>
                            </div>
                        </div>


                    {elseif $theme.orderstyle eq 1}

                        <div class="row">
                            <div class="col-lg-4 h-100">
                                <div  class="service-list">
                                    {foreach from=$imeiservicelist key=GroupName item=Services}
                                        <div class="card mb-4 bottom-space group active g_{str_replace("*","",$GroupName|substr:0:2)}">
                                            <div>
                                                <h4 class="pb-3 m-0 border-bottom">
                                                    {$GroupName}
                                                </h4>
                                                {foreach from=$Services key=ServicesID item=ServicesI}
                                                    <div class="cursor-pointer  service active" id="id_{$ServicesID}"    onclick="popupOrder('{$ServicesID}','{$ServicesI.service_name}');">
                                                        <div class="border-top w-100">
                                                            <div class="">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-9">
                                                                        <div class="py-3">
                                                                            <span  class="searchme"> {$ServicesI.service_name} </span>
                                                                            {if $ServicesI.newservice eq 1}<span class="textred">{$lang.new}</span>{/if} <br />
                                                                            {if $ServicesI.time}
                                                                                <span class="text-muted"> {$ServicesI.time} </span>
                                                                            {/if}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 text-right">
                                                                        <div class="py-3">
                                                                            <div>
                                                                                <div> {$ServicesI.purchasepoint} <br/> {$lang.point}  </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {/foreach}
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>

                            <div class="col-lg-8 d-flex h-100 pl-0 flex-column">
                                <div class="card">
                                    <h4   class="mb-4 bottom-space service-title"> </h4>
                                    {call name=getservicedetail}
                                </div>
                            </div>

                        </div>
                        <div class="not-found d-none">
                            {$lang.resultnotfound}
                        </div>

                    {else}

                        <div class="big-chosen mb-4 bottom-space">
                            <select class="chosen form-control" name="id"   id="service_id" onchange="getServicedetailsIMEI(this.value,'#serviceDetails2','.alert',true,'#loader','','','#information','','',1);">
                                <option value="">{$lang.select} </option>
                                {foreach from=$imeiservicelist key=GroupName item=Services}
                                    <optgroup label="{$GroupName}">
                                        {foreach from=$Services key=ServicesID item=ServicesI}
                                            <option
                                                    {if $sid eq $ServicesID}
                                                        selected='selected'
                                                    {/if}
                                                    {if $ServicesI.pricenotify eq 1}
                                                        class="price_change"
                                                    {elseif $ServicesI.discountflag eq 1}    {/if}  value="{$ServicesID}" data-price="{$ServicesI.credit-$ServicesI.discount}" >
                                                        {$ServicesI.service_name} - {$ServicesI.purchasepoint}   {$lang.point} {if $ServicesI.pricenotify eq 1} ** {/if}{if $ServicesI.newservice eq 1} *{$lang.new}
                                                    {/if}
                                            </option>
                                        {/foreach}
                                    </optgroup>
                                {/foreach}
                            </select>
                        </div>

                        <div class="h-100 d-flex flex-column">
                            <div class="card">
                                {call name=getservicedetail}
                            </div>
                        </div>

                    {/if}


                </div>
        </form>
        </div></div>





{if $action eq 'placeorder'}
{literal}
    <script>
        popupOrder({/literal}'{$sid}'{literal},{/literal}'{$smarty.get.servicename}'{literal});
        //getServicedetailsIMEI({/literal}'{$sid}'{literal},'#serviceDetails2','#notification',true,'#loader','','','#information',0);
    </script>
{/literal}
{/if}





{literal}
    <style>
        .list-group-item:hover{cursor:pointer;background:#eee}
        .group,.service{display:none}
        .group.active,.service.active{display:flex}
        .fal:hover{color:orange}


        ::-webkit-scrollbar {
            width:2px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }


    </style>
{/literal}
