
<div class="container"><div class="page-container">

        <form method="post" class="position-relative">

            <div class="content-loader" id="payment_loader">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div>
                        <div class="spinner-loader p-3"><i class="fal fa-spinner fa-spin fa-3x fa-fw"></i></div>
                        {$lang.pleasewait}
                    </div>
                </div>
            </div>

            <div>

                {if $cartitems}
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table border-bottom table-hover-disable  table-cart-items">
                                <thead>
                                <tr>
                                    <th class="w-100">
                                        {$lang.products}
                                    </th>
                                    <th class="text-right d-none d-lg-table-cell">{$lang.price}</th>
                                </tr>
                                </thead>

                                <tbody>
                                {foreach from=$cartitems key=id item=cartitem}
                                    <tr>


                                        <td>

                                            <div class="row align-items-center">


                                                <div class="col-md-2 col-lg-2 d-none d-md-block ">
                                                    <div class="w-100  h-100  m-auto">
                                                        {if $cartitem.orderdetail.image_link}
                                                            <img class="card-img-top" src="{$cartitem.orderdetail.image_link}" alt="{$cartitem.orderdetail.description}" />
                                                        {else}
                                                            <span class="big-icon "> <i class="fas fa-image fa-4x"></i> </span>
                                                        {/if}
                                                    </div>
                                                </div>


                                                <div class="col-md-8 col-lg-8 mb-2 mb-lg-0">

                                                    <a href="{$cartitem.seo}">
                                                        {$cartitem.name}{if $cartitem.orderdetail.taxed} * {/if}
                                                        {if $cartitem.orderdetail.freeship eq 1}
                                                            <span class="text-muted">
                                                                {$lang.freeship}
                                                            </span>
                                                        {/if}
                                                    </a>



                                                    {foreach from=$cartitem.orderdetail.customfield  item=cust}
                                                        <div class="text-muted">
                                                            {$cust}
                                                        </div>
                                                    {/foreach}
                                                    <div class="text-muted">
                                                        {$cartitem.orderdetail.imei}
                                                    </div>

                                                    <div class="d-none d-lg-block">
                                                        <a href="{$viewcart}?delete={$id}" class="delete-icon">
                                                            <i class="fal fa-trash"></i>
                                                        </a>
                                                    </div>

                                                </div>


                                                <div class="col-md-2 col-auto col-lg-2 w-100 justify-content-between center d-flex">
                                                    <div style="width:70px" >
                                                        {if $cartitem.type eq "product"}
                                                            {assign var="update" value="true"}

                                                            <div class="font-normal text-muted d-block d-lg-none">
                                                                Qnt
                                                            </div>
                                                            <select name="qnt[{$id}]" class="form-control  no-chosen" onchange="updateQnt('{$id}')">
                                                                {if $servicedtl.minqnt gt 0 && $servicedtl.maxqnt gt 0}
                                                                    {section name=foo start=$servicedtl.minqnt loop=$servicedtl.maxqnt+1 step=1}
                                                                        <option value="{$smarty.section.foo.index}" {if $smarty.section.foo.index eq $cartitem.qnt}selected="selected"{/if}>{$smarty.section.foo.index}</option>
                                                                    {/section}
                                                                {else}
                                                                    {section name=foo start=1 loop=1000 step=1}
                                                                        <option value="{$smarty.section.foo.index}" {if $smarty.section.foo.index eq $cartitem.qnt}selected="selected"{/if}>{$smarty.section.foo.index}</option>
                                                                    {/section}
                                                                {/if}
                                                            </select>

                                                            {*<div class="input-group input-qnt">
                                                                <div class="input-group-prepend" onclick="decQnt('{$id}')">
                                                                    <div class="input-group-text">-</div>
                                                                </div>
                                                                <input type="text" class="form-control text-center"  id="qnt{$id}" name="qnt[{$id}]" value="{$cartitem.qnt}" />
                                                                <div class="input-group-append"  onclick="incQnt('{$id}')">
                                                                    <div class="input-group-text">+</div>
                                                                </div>
                                                            </div>*}
                                                        {else}
                                                            <div class="text-md-center text-left mt-2">
                                                                    {$cartitem.qnt}
                                                            </div>
                                                        {/if}
                                                    </div>

                                                    <div class="d-block d-lg-none">
                                                        <a href="{$viewcart}?delete={$id}" class="delete-icon">
                                                            <i class="fal fa-trash"></i>
                                                        </a>
                                                    </div>

                                                    <div class=" d-block d-lg-none">
                                                        <div class="no-wrap"><span class="prefix">{$currency.prefix}</span> {$cartitem.orderdetail.credit-$cartitem.orderdetail.discount} <span class="suffix">{$currency.suffix}</span></div>
                                                    </div>
                                                </div>





                                            </div>

                                        </td>

                                        <td class="text-right d-none d-lg-table-cell">
                                            <div class="no-wrap"><span class="prefix">{$currency.prefix}</span> {$cartitem.orderdetail.credit-$cartitem.orderdetail.discount} <span class="suffix">{$currency.suffix}</span></div>
                                        </td>



                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <div class="float-left"></div>

                            <div class="price-details">
                                <table class="table border-0 align-items-center">
                                    <tr>

                                        <td  class="w-100">
                                            <div>
                                                {$lang.price} ({$cartitems|count} {$lang.items})
                                            </div>
                                        </td>
                                        <td class="seperator-colon"> </td>
                                        <td class="text-right">
                                            {$subtotal}
                                        </td>
                                    </tr>
                                    {if $taxrate}
                                        <tr>
                                            <td>
                                                <div>
                                                    {$taxname} <span class="text-muted">({$taxper}%)</span>
                                                </div>
                                            </td>
                                            <td class="seperator-colon"> </td>
                                            <td class="text-right">
                                                {$taxrate}
                                            </td>
                                        </tr>
                                    {/if}
                                    {if $taxrate2 neq 0}
                                        <tr>
                                            <td>
                                                <div>
                                                    {$taxname2} <span>({$taxper2}%)</span>
                                                </div>
                                            </td>
                                            <td class="seperator-colon"> </td>
                                            <td class="text-right">
                                                {$taxrate2}
                                            </td>

                                        </tr>
                                    {/if}

                                    <tr>
                                        <td>
                                            <div>
                                                {$lang.shippingcharges}
                                            </div>
                                        </td>
                                        <td class="seperator-colon"> </td>
                                        <td class="text-right">
                                            {$lang.calculateonnextstep}
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            {$lang.invoicestotal}
                                        </td>
                                        <td class="seperator-colon"> </td>
                                        <td class="text-right double-border">
                                            <h5>{$total}</h5>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="clearfix"></div>
                        </div>

                    </div>


                    <div   class="btn-cartview-next ml-auto">
                        <div class="text-right  d-block">


                            {if $update}
                                <div class="d-none">
                                    <button type="submit" class="btn btn-info" id="updateqnt" name="update" value="{$lang.update} {$lang.quantity}" >
                                        {$lang.update} {$lang.quantity}
                                    </button>
                                </div>
                            {/if}


                            <div class="d-actionbar-mobile p-lg-0">

                            <button type="button" class="btn btn-primary w-100"
                                    onclick="location.href='{$checkoutlink}';" value="" >
                                {$lang.next} &nbsp; <i class="fal fa-arrow-right"></i>
                            </button>

                            </div>

                            {if $paypalexpressbutton}

                                <h3 class="h3 p-0 or d-none d-lg-block gray m-0">
                                    <span class="text-muted">{$lang.or} </span>
                                </h3>
                                <div style="display:block">
                                    {$paypalexpressbutton}
                                </div>
                            {/if}
                        </div>
                    </div>


                {else}
                    <div class="card p-5 text-center">
                        <div class="p-5">
                            {$lang.cartisemp}
                        </div>
                    </div>
                {/if}
            </div>





        </form>
    </div></div>

{literal}
    <script>
        /*function decQnt(id){
            let qnt = parseInt($('#qnt'+id).val());
            if(qnt>1) {
                $('#qnt' + id).val(qnt - 1);
                $('#updateqnt').click();
            }
        }
        function incQnt(id){
            let qnt = parseInt($('#qnt'+id).val());
            $('#qnt' + id).val(qnt + 1);
            $('#updateqnt').click();
        }*/
        function updateQnt(id) {
            $('#updateqnt').click();
        }
    </script>
    <style>
        .input-qnt .form-control{
            background: #eee;
        }
    </style>
{/literal}
