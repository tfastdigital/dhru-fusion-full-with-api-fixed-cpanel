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

        {if $cart}
            <div class="position-relative  mb-4 bottom-space">
                {$lang.resellerprice}
                <a href="{$firstimeigroup}">{$lang.clickhere}</a>
            </div>
        {/if}

        <div class="row align-items-center">

            <div class="col-lg-4">
                <div class="form-group">
                    <input type="text" name="search" id="searchservicebox" class="form-control"
                           placeholder="{$lang.search} {$lang.service}"/>
                </div>
            </div>

            <div class="col-lg-4">
                {if $defimei eq 1}
                    {assign var='l' value='0'}
                    <div class="form-group">
                        <select class="form-control no-chosen" onchange="loadItems(this.value)">
                            <option value="">{$lang.all} {$lang.group}</option>
                            {foreach from=$serverservicelist key=GroupName item=Services}
                                <option value="{str_replace("*","",$GroupName|substr:0:2)}">{$GroupName}</option>
                            {/foreach}
                        </select>
                    </div>
                {/if}
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
    <div class="table-responsive  services">
            <div class="group card  mb-4  bottom-space active  g_{str_replace("*","",$GroupName|substr:0:2)}">


                <table class="table  table-striped  table-hover">
                    <thead>
                    <tr>
                        <th colspan="2"><h5> {$GroupName} </h5></th>
                        <th class="text-center no-wrap  d-none d-lg-table-cell"><span class="">{$lang.deliverytime}</span></th>
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
                        <tr class="{if $Service.hot eq 1} table-danger hottest {/if}   service active">
                            <td class="cursor-pointer text-center  p-0 p-lg-2" data-whatever="{$service.service_name}"   data-toggle="modal" data-target="#modal-ajax"  href="{$service.detaillink}?standalone=true" >

                                <div class="d-none d-lg-block">

                                    {if $Service.icon}
                                        <div> {$Service.icon} </div>
                                    {else}
                                        <i class="fal fa-cogs"></i>
                                    {/if}

                                </div>

                            </td>
                            <td class="cursor-pointer  w-100" style="white-space: normal"
                                data-whatever="{$Service.service_name}" data-toggle="modal" data-target="#modal-ajax"
                                href="{$Service.detaillink}?standalone=true">
                                <a class="searchme">{$Service.service_name}</a>
                                <span data-toggle="tooltip" data-placement="top"
                                      title="{$Service.type}"> {if $Service.type}{if $Service.type neq Other}
                                        <span class=""> <img src="images/{$Service.type}.png"/></span>
                                    {/if}  {/if} </span>
                                <div class="d-block d-lg-none"> <small class="text-muted"> {$Service.time}</small></div>
                            </td>

                            <td class="text-center no-wrap border-left d-none d-lg-table-cell">
                                <span class="">{if $Service.time}
                                        <span>{$Service.time}</span>{/if} </span>
                            </td>
                            {if $displayprice eq 1}
                                <td class="text-right no-wrap border-left">
                                    {if $Service.discount}
                                        <span class="discount red nowrap"> <span class="prefix">{$currency.prefix}</span> {$Service.credit}<span class="suffix">{$currency.suffix}</span> </span>
                                    {/if}
                                    <span class="nowrap"> <span class="prefix">{$currency.prefix}</span> {$Service.credit-$Service.discount}<span class="suffix">{$currency.suffix}</span>  </span>
                                </td>
                                {foreach from=$groups key=gid item=Gr}
                                    <td class="text-right border-left">
                                        <span  class="nowrap"> <span class="prefix">{$currency.prefix}</span> {$Service.cgprice.$gid} </span>
                                    </td>
                                {/foreach}
                            {/if}
                        </tr>
                        {foreachelse}
                        <tr>
                            <td colspan="3">
                                <div class="text-center">
                                    <svg class="icon" height="30" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M945.643909 899.025661 767.204891 720.555943c-1.134847-1.136893-2.585895-1.641383-3.815909-2.555196 58.732659-68.858274 94.376461-158.0302 94.376461-255.623935 0-217.74114-176.577624-394.350486-394.350486-394.350486-217.771839 0-394.350486 176.608324-394.350486 394.350486 0 34.792411 4.952802 68.322062 13.406335 100.464109 10.219759-15.58393 36.712133-52.364625 52.549843-59.237149-1.702782-13.532201-2.838651-27.220968-2.838651-41.22696 0-182.917006 148.31493-331.264683 331.264683-331.264683s331.263659 148.346653 331.263659 331.264683c0 143.771451-91.758844 265.811971-219.7284 311.643809-6.088672 25.960255-15.929808 50.720172-29.335119 73.747631 65.640999-14.005992 125.32124-44.097334 174.432775-86.301552 0.914836 1.199315 1.419326 2.648316 2.524496 3.784186l178.468694 178.375573c12.33391 12.396331 32.268938 12.396331 44.601824 0C958.007495 931.355997 958.007495 911.358547 945.643909 899.025661L945.643909 899.025661zM480.417189 541.360701c-45.421492-45.421492-105.827257-70.436212-170.111353-70.436212-64.284095 0-124.657114 25.01472-170.07963 70.436212-45.453215 45.422516-70.466911 105.826234-70.466911 170.109306 0 64.285119 25.013697 124.658138 70.466911 170.111353 45.453215 45.454238 105.857956 70.465888 170.111353 70.465888 0 0 0 0 0.030699 0 64.253396 0 124.659161-25.045419 170.07963-70.465888 45.422516-45.388746 70.437236-105.826234 70.437236-170.111353C550.853401 647.217634 525.837658 586.812893 480.417189 541.360701zM435.815365 836.979536c-33.530674 33.531698-78.100776 51.982932-125.477806 51.982932l0 0c-47.408753 0-92.010577-18.48398-125.509529-51.982932-33.529651-33.529651-51.982932-78.099752-51.982932-125.509529 0-47.408753 18.453281-91.977831 51.982932-125.506459 33.529651-33.532721 78.069053-51.953256 125.477806-51.953256 47.409776 0 91.978854 18.453281 125.509529 51.953256 33.529651 33.529651 51.981908 78.097706 51.981908 125.506459C487.797273 758.911506 469.345016 803.450908 435.815365 836.979536zM420.895561 600.914052c-12.33391-12.335956-32.268938-12.335956-44.601824 0l-65.988924 65.986877-65.9879-65.986877c-12.332886-12.335956-32.267914-12.335956-44.600801 0-12.33391 12.332886-12.33391 32.266891 0 44.601824l65.986877 65.985854-65.986877 65.9879c-12.33391 12.332886-12.33391 32.267914 0 44.601824 6.15007 6.151094 14.226003 9.242502 22.299889 9.242502 8.075933 0 16.150842-3.091408 22.300912-9.242502l65.9879-65.986877 65.988924 65.986877c6.15007 6.151094 14.224979 9.242502 22.299889 9.242502 8.075933 0 16.150842-3.091408 22.300912-9.242502 12.33391-12.33391 12.33391-32.268938 0-44.601824l-65.986877-65.9879 65.986877-65.985854C433.196725 633.212666 433.196725 613.246939 420.895561 600.914052L420.895561 600.914052z" /></svg>
                                    {$lang.norecordsfound}
                                </div>
                            </td>
                        </tr>
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
