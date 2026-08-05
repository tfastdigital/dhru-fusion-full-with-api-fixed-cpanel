{if $fromapp }
    {include file="templates/default/chunks/header-head.tpl"}
    {include file="templates/default/chunks/app-css.tpl"}
{/if}

<div class="container"><div class="page-container">
    <div class="card">
        <div class="card-app">

            {if $paymentmessage}
                <div class="alert alert1 alert-danger">{$paymentmessage}</div>
            {/if}

            <div class="row">

                <div class="col-lg-6 mb-4 bottom-space">

                    <div class="text-center mb-4 bottom-space">
                        <div class="success-icon">
                            <i class="fal fa-check-circle text-success fa-6x" aria-hidden="true"></i>
                        </div>
                        <h3 class="m-3">Order ID : #{$invoice}</h3>
                    </div>

                    <div class="text-center">
                        <a class="btn btn-primary text-white py-2 px-4" href="{$viewinvoice}" target="_blank">{$lang.view} {$lang.invoice}</a>
                    </div>

                    {if $shippingaddress.name}
                        <div class="border-top mt-3 pt-3">
                            <h5>Shipping to</h5>
                            <address>
                                <div>{$shippingaddress.name}</div>
                                <div>{$shippingaddress.add1} {$shippingaddress.add2} </div>
                                <div>{$shippingaddress.city} {$shippingaddress.zip}</div>
                                <div>{$shippingaddress.state} {$shippingaddress.country}</div>
                            </address>
                        </div>
                    {/if}



                    {if $shippingaddress.latitude && $shippingaddress.longitude}
                        <div class="mapouter">
                            <div class="gmap_canvas">

                                {*<iframe
                                        width="600"
                                        height="450"
                                        frameborder="0" style="border:0"
                                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBt22uOrfUe30hTHUWSGnZXPEIbP-p8RZ4&q={$shippingaddress.city},{$shippingaddress.state}" allowfullscreen>
                                </iframe>*}

                                <iframe
                                        width="100%"
                                        height="100%"
                                        frameborder="0"
                                        scrolling="no"
                                        marginheight="0"
                                        marginwidth="0"
                                        src="https://maps.google.com/maps?q={$shippingaddress.latitude},{$shippingaddress.longitude}&hl=es&z=14&amp;output=embed"
                                >
                                </iframe>

                            </div>
                            {literal}
                                <style>
                                    .mapouter {
                                        position: relative;
                                        text-align: right;
                                        height: 400px;
                                        width: 100%;
                                    }

                                    .gmap_canvas {
                                        overflow: hidden;
                                        background: none !important;
                                        height: 400px;
                                        width: 100%;
                                    }
                                </style>
                            {/literal}
                        </div>
                    {/if}

                </div>

                <div class="col-lg-6">


                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tracking&nbsp;ID</th>
                                    <th>Item</th>
                                    <th></th>
                                </tr>
                            </thead>
                        {foreach from=$orders key=id  item=order}
                            <tr>
                                <td>
                                    {if $order.type === 'AddFunds'}-{else}#{$order.order}{/if}
                                </td>
                                <td>
                                    {$order.item}
                                </td>
                                <td>

                                    {if $order.type === 'Product'}
                                        <a class="btn btn-warning text-white py-2 px-4" href="{$order.link}">{$lang.track} {$lang.order}</a>
                                    {elseif $order.type === 'AddFunds'}
                                        {if $invoicestatus === 'Paid'}
                                            <span class="text-success"> <i class="fal fa-check-double"></i> </span>
                                        {else}
                                            <span class="badge badge-danger"> Pending for approval </span>
                                        {/if}
                                    {else}
                                        <a class="btn btn-warning text-white py-2 px-4" href="{$order.link}?standalone=true" data-toggle="modal" data-target="#modal-ajax"   data-whatever="View Order #{$order.order}">{$lang.track} {$lang.order}</a>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                        </table>
                    </div>
                </div>
            </div>




        </div>
    </div>
    </div></div>

