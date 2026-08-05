{literal}
    <script>
        $(document).ready(function () {
            $('.services').searchService({searchBox: '#searchservicebox'});
        });

        function loadItems(gp) {
            if (gp) {
                $('.group.active').removeClass('active');
                $('.group.g_' + gp).addClass('active');
            } else {
                $('.group').addClass('active');
            }
        }

    </script>
{/literal}


    <div class="container reseller-pricing"><div class="page-container">

        <div class="card card-search mb-4  bottom-space">
            <div class="row  align-items-center">

            <div class="col-lg-4">
                <div class="form-group">
                    <input type="text" name="search" id="searchservicebox" class="form-control"
                           placeholder="{$lang.search} {$lang.service}"/>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                {if $deffile eq 1}
                    <select class="form-control no-chosen" onchange="loadItems(this.value)">
                        <option value="">{$lang.all} {$lang.group}</option>
                        {foreach from=$serverservicelist key=GroupName item=Services}
                            <option value="{str_replace("*","",$GroupName|substr:0:2)}">{$GroupName}</option>
                        {/foreach}
                    </select>
                {/if}
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="hot" onclick="showhot(this);"   class="custom-control-input" id="hotitem">
                        <label class="custom-control-label" for="hotitem">{$lang.hotproduct}</label>
                    </div>

                </div>
            </div>

        </div>
        </div>

    </div>


</div>


<div class="container reseller-pricing"><div class="page-container">


        {assign var='i' value='0'}


        {foreach from=$serverservicelist key=GroupName item=Services}

    <div class="table-responsive services">

            <div class="group card  mb-4  bottom-space  active  g_{str_replace("*","",$GroupName|substr:0:2)}">


                <table class="table  table-striped  table-hover">
                    <thead>
                        <tr>
                        <th colspan="2"><h5> {$GroupName} </h5></th>
                        <th class="text-center no-wrap  d-none d-lg-table-cell">
                            <span class="">{$lang.deliverytime}</span></th>
                            {if $displayprice eq 1}
                                <th  class="text-right">{$lang.price}</th>
                                {foreach from=$groups key=gid item=Gr}
                                    <th class="text-right">{$Gr}</th>
                                {/foreach}
                            {/if}
                        </tr>
                    </thead>

                    <tbody>
                    {foreach from=$Services key=id item=Service}
                        <tr class="{if $Service.hot eq 1} table-danger hottest {/if} href service active"
                            data-whatever="{$Service.service_name}" data-toggle="modal" data-target="#modal-ajax"
                            href="{$Service.detaillink}?standalone=true">
                            <td class="cursor-pointer text-center  p-0 p-lg-2" data-whatever="{$service.service_name}"   data-toggle="modal" data-target="#modal-ajax"  href="{$service.detaillink}?standalone=true" >

                                <div class="d-none d-lg-block">

                                    {if $Service.icon}
                                        <div> {$Service.icon} </div>
                                    {else}
                                        <i class="fal fa-cogs"></i>
                                    {/if}

                                </div>

                            </td>
                            <td class="w-100" style="white-space: normal">
                                <a class="searchme">{$Service.service_name}</a>
                                <span> {if $Service.type}{if $Service.type neq Other}
                                        <span class=""> <img src="images/{$Service.type}.png"/></span>
                                    {/if}  {/if} </span>
                                <div class="d-block d-lg-none"> <small class="text-muted"> {$Service.time}</small></div>
                            </td>

                            <td class="text-center  no-wrap border-left  d-none d-lg-table-cell">
                                <span class="">
                                    {if $Service.time}
                                        <span>{$Service.time}</span>
                                    {/if}
                                </span>
                            </td>
                            {if $displayprice eq 1}
                                <td class="text-right border-left">
                                    {if $Service.discount}
                                        <span class="discount red nowrap"> <span class="prefix">{$currency.prefix}</span> {$Service.credit}<span class="suffix">{$currency.suffix}</span> </span>
                                    {/if}
                                    <span class="nowrap"> <span class="prefix">{$currency.prefix}</span> {$Service.credit-$Service.discount}<span class="suffix">{$currency.suffix}</span>  </span>
                                </td>
                                {foreach from=$groups key=gid item=Gr}
                                    <td class="text-right border-left">
                                        <span class="nowrap"> <span class="prefix">{$currency.prefix}</span> {$Service.cgprice.$gid} </span>
                                    </td>
                                {/foreach}
                            {/if}

                        </tr>
                        {foreachelse}
                        <div>
                            {$lang.norecordsfound}
                        </div>
                    {/foreach}
                    <span class="d-none">{$i++}</span>
                    </tbody>
                </table>
            </div>

    </div>
        {/foreach}





    </div></div>


{literal}
    <style>
        .group {
            display: none
        }

        .group.active {
            display: block
        }

        .service {
            display: none
        }

        .service.active {
            display: table-row
        }
    </style>
{/literal}
