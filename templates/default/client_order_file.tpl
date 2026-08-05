{literal}
	<script type="text/javascript">

    $(document).ready(function(){
       $('.service-list').searchService({searchBox:'#searchservicebox2'});
    });

    function popupOrder(ServicesID,servicename,submit=false){
        $('#modal-order').show();
        $('#modal-order .modal-title').text(servicename);
        console.log(ServicesID);
        $('#service-id').val(ServicesID);
        $('#service-name').val(servicename);

        if(!submit){
           $('.alert1').addClass('d-none');
        }
        else{
            $('.alert1').removeClass('d-none');
        }

        $('#modal-order').show();
        getServicedetailsFile(ServicesID,'#serviceDetails2','.alert2',true,'#loader','','','#information');

    }

    </script>

{/literal}

{assign var=theme value=$userdetails.themesettings|json_decode:1}


{function name=getservicedetail}


    <input type="hidden" id="service-id" name="id"/>
    <input type="hidden" id="service-name" name="servicename"/>
    <div id="serviceDetails2" class="h-100 position-relative d-flex flex-column">
        <div class="">
            <h1 class="p-5 text-center mt-5" style="color:#ccc;font-weight:100;">
                {if $theme.orderstyle eq 2}
                    <i class="fal fa-arrow-up"></i>&nbsp;&nbsp;
                {else}
                    <i class="fal fa-arrow-left"></i>&nbsp;&nbsp;
                {/if}
                <div>&nbsp;&nbsp;
                Select Service
                </div>
            </h1>
        </div>
    </div>
    <div id="loader2" style="display: none">
        <div class="position-absolute d-flex justify-content-center align-items-center w-100 h-100 text-center" style="top:0;left:0;">
            <div class="ajax-responsive loading"></div>
        </div>
    </div>

{/function}


{function name=servicefilter}
<div class="card card-search mb-4 bottom-space">
    <div class="form-inline">
        <div class="form-group pr-3 d-none d-lg-block">
            <i class="fal fa-search"></i>
        </div>
        <div class="form-group w-25">
            <select class="form-control" onChange="loadItems(this.value)">
                <option value="">{$lang.all} {$lang.group}</option>
                {foreach from=$fileservicelist key=GroupName item=Services}
                    <option value="{$GroupName|substr:0:2}">{$GroupName}</option>
                {/foreach}
            </select>
        </div>

        <div class="form-group mb-0">
            <input type="text"   class="form-control " placeholder="{$lang.search} {$lang.service}..." id="searchservicebox2"  autocomplete="off" />
        </div>

        <div class="custom-control custom-checkbox mr-3 ml-auto" data-toggle="tooltip" data-title="Discounted services">
            <input type="checkbox" name="discounted" onclick="showdiscounted(this);"  class="custom-control-input" id="chk1">
            <label class="custom-control-label" for="chk1"> Discounted </label>
        </div>


    </div>
</div>

{/function}



<div class="container">
    <div class="page-container">


    <form  method="post" name="fileorder_form" class="h-100" id="fileorder_form2" enctype="multipart/form-data">

      {$token}

        {if $theme.orderstyle neq '2'}
            {call name=servicefilter}
        {/if}

            <div class="h-100 d-flex w-100 flex-column">

                {if $theme.orderstyle eq '3'  || $ismobile || $action eq 'placeorder'}

                <div  class="service-list service-list-box">
                    {foreach from=$fileservicelist key=GroupName item=Services}

                        <div>
                            <h4 class="mt-3"><span>{$GroupName}</span> </h4>
                        </div>

                        <div class="row group active g_{$GroupName|substr:0:2}">
                            {foreach from=$Services key=ServicesID item=ServicesI}
                                <div class="col-lg-4 col-md-6   mb-4 bottom-space service active" id="id_{$ServicesID}"  {if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount} title="Discounted Service" {/if}   onclick="popupOrder('{$ServicesID}','{$ServicesI.service_name}');">
                                    <div class="card w-100 h-100  rounded">
                                        <div class="row h-100">
                                            <div class="col-auto col-group-icon">
                                                <div class="bg-gray  h-100 d-flex align-items-center p-3 p-sm-3 text-uppercase">{$GroupName|substr:0:2}</div>
                                            </div>
                                            <div class="col p-0">
                                                <div class="pt-3 pb-3">
                                                    <span  class="searchme"> {$ServicesI.service_name} </span> {if $ServicesI.newservice eq 1}<span class="textred">{$lang.new}</span>{/if}
                                                    {if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount}
                                                        &nbsp;&nbsp;&nbsp; <span style="color: #009fff;"> <i class="fal fa-tags"></i></span>
                                                    {/if}
                                                    <br />
                                                    <div class="text-muted">
                                                        {$GroupName}
                                                    </div>
                                                    <span class="{if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount} discount_text {/if} badge badge-success">
															{if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount}
                                                                <i class="fa fa-tags"></i>
                                                            {/if}
                                                        {$userdetails.currency.prefix}{$ServicesI.credit-$ServicesI.discount}{$userdetails.currency.suffix}
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


                <div id="modal-order" class="modal modal-ajax" tabindex="-1" style="display: none">
                    <div class="backdrop-over"></div>
                    <div class="modal-dialog modal-dialog-centered modal-lg mx-auto">
                        <div class="modal-content rounded">
                            <div class="modal-header">
                                <h5 class="modal-title service-title">Place File order</h5>
                                <button type="button" class="close" onclick="$('#modal-order').hide()"  aria-hidden="true"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                {call name=getservicedetail}
                            </div>
                        </div>
                    </div>
                </div>



                {elseif $theme.orderstyle eq '2'}

                    <div class="  big-chosen mb-4 bottom-space">
                        <select class="form-control" name="id"   id="service_id"  onchange="popupOrder(this.value)">
                            <option value="">{$lang.select}</option>
                            {foreach from=$fileservicelist key=GroupName item=Services}
                                <optgroup label="{$GroupName}">
                                    {foreach from=$Services key=ServicesID item=ServicesI}
                                        <option
                                            {if $sid eq $ServicesID}
                                                selected='selected'
                                            {/if}
                                            {if $ServicesI.pricenotify eq 1}
                                                class="price_change"
                                            {elseif $ServicesI.discountflag eq 1} class="discount_text"  {/if}  value="{$ServicesID}" data-price="{$ServicesI.credit-$ServicesI.discount}" >{$ServicesI.service_name} - {$ServicesI.credit-$ServicesI.discount} {$lang.credit} {if $ServicesI.pricenotify eq 1} ** {/if}{if $ServicesI.newservice eq 1} *{$lang.new} {/if}
                                            {if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount}
                                                &nbsp;&nbsp;&nbsp; -------- &nbsp;&nbsp;&nbsp; <span style="color: #009fff;">   Discounted </span>
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





                {else}



                    <div class="row">
                        <div class="col-lg-4 col-left h-100" style="overflow: auto">

                            <div  class="service-list">
                                {foreach from=$fileservicelist key=GroupName item=Services}
                                    <div class="card mb-4 bottom-space group active g_{str_replace("*","",$GroupName|substr:0:2)}">
                                        <h4 class="pb-3 m-0 border-bottom">
                                            {$GroupName}
                                        </h4>
                                        <div class="row">
                                            {foreach from=$Services key=ServicesID item=ServicesI}
                                                <div class="col-lg-12  cursor-pointer  service active {if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount} discounted {/if}" id="id_{$ServicesID}"  {if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount} title="{$lang.discounted} {$lang.services}" {/if}   onclick="popupOrder('{$ServicesID}','{$ServicesI.service_name}');">
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
                                                                            {if $ServicesI.credit gt $ServicesI.credit-$ServicesI.discount}
                                                                                <div class="text-center" style="color: #009fff;"> <i class="fal fa-tags"></i></div>
                                                                            {/if}
                                                                            <div> <div> <span class="text-muted"> {$userdetails.currency.prefix} </span> </div> {$ServicesI.credit-$ServicesI.discount}</div>
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

                        <div class="col-lg-8 col-right pl-0 d-flex h-100  flex-column">
                            <div class="card">
                                {call name=getservicedetail}
                            </div>
                        </div>

                    </div>


                    <div class="not-found d-none">
                        {$lang.resultnotfound}
                    </div>
                {/if}


            </div>


    </form>

    </div>
</div>

 {literal}
    <style>
        .list-group-item:hover{cursor:pointer;background:#eee}
        .group,.service{display:none}
        .group.active,.service.active{display:flex}

        ::-webkit-scrollbar {
            width:2px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }


    </style>
 {/literal}



 {if $notification.success || $notification.error}
    {literal}
        <script>
            popupOrder({/literal}'{$smarty.post.id}'{literal},{/literal}'{$smarty.post.servicename}'{literal},true);
        </script>
    {/literal}
{/if}
