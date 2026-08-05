{if  $fromapp }
    {include file="templates/default/chunks/header-head.tpl"}
    {include file="templates/default/chunks/app-css.tpl"}
{/if}
{literal}
    <script>
        function kycredirect()
        {
            location.href='{/literal}{$idverificationlink}{literal}';
        }
    </script>
{/literal}
<div class="container"><div class="page-container">
    <div class="card mb-4 bottom-space">

        {if $notification.error}
            <div    style="display: block"  class="alert alert-danger">{$notification.error}</div>
        {elseif $notification.success}

            <div    style="display: block"   class="alert alert-success">{$notification.success}</div>
        {/if}

        <div class="row">
            <div class="col-lg-6">
                <div class="app-content-header">
                {if $logo}
                    <img src="{$logo}" />
                {else}
                    <h2>
                        {$companyname}
                    </h2>
                {/if}
                <address> {$payto} </address>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="big-badge text-right">

                    {if $status eq "Unpaid"}
                        <label class="badge badge-danger">
                            {$lang.unpaid}
                        </label>
                    {elseif $status eq "Paid"}
                        <label class="badge badge-success">
                            {$lang.paid}
                        </label>
                    {elseif $status eq "Refunded"}
                        <label class="badge badge-inverse">
                            {$lang.invoicesrefunded}
                        </label>
                    {elseif $status eq "Cancelled"}
                        <label class="badge badge-danger">
                            {$lang.invoicescancelled}
                        </label>
                    {elseif $status eq "Collections"}
                        <label class="label">
                            {$lang.invoicescollections}
                        </label>

                    {else}
                        <label class="label badge badge-danger">
                            {$status}
                        </label>
                    {/if}

                </div>



            </div>

        </div>

        <div class="card-app">

            <div class="rounded mb-4 bottom-space bg-light">

                <div class="row">

                    <div class="col-lg-6">
                        {if $status neq $lang.paid && $status neq $lang.waitingapproval}
                           <!-- <div class="col-lg-6">
                                <div class="form-group m-0">
                                <div class="form-label">{$lang.paywith}</div>
                                </div>
                                <table class="w-100"><tr><td>

                                            {if $allowchangegateway}
                                                <form method="post" action="{$invoiceurl}" class="mb-4 bottom-space">
                                                    {if $accesskey}
                                                        <input type="hidden" name="accesskey" value="{$accesskey}" />
                                                    {/if}
                                                    <input type="hidden" name="id" value="{$invoiceidmd5}" />
                                                    {$gatewaydropdown}
                                                </form>
                                            {else}

                                                {$paymentmethod}
                                            {/if}


                                            {if $codmsg} <br />
                                                {$codmsg}
                                            {else}
                                                {if $blockpayment eq 1}

                                                        <button class="btn btn-primary mt-2"
                                                                onclick="kycredirect();"
                                                                name="kyc" value="KYC Verification" >KYC Verification</button>
                                                {else}
                                                {$paymentbutton}
                                                {/if}
                                            {/if}



                                        </td></tr></table>
                            </div>-->
                        {else}
                            {if $status neq $lang.waitingapproval}

                                    <div>
                                        <div class="p-3 rounded">
                                        <div> <span class="text-uppercase">{$lang.billto},</span></div>
                                        {if $userdetailsd.companyname}
                                           <div> {$userdetailsd.companyname},</div>
                                        {/if}
                                        <div><h5 class="m-0">{$userdetailsd.firstname} {$userdetailsd.lastname},</h5></div>
                                        <address class="font-normal mb-0">
                                            <div>{$userdetailsd.address1}  {$userdetailsd.address2}  </div>
                                            <div> {$userdetailsd.city} {$userdetailsd.postcode}</div>
                                            <div>{$userdetailsd.state} </div>
                                            <div> {$userdetailsd.country} </div>
                                        </address>
                                        </div>
                                    </div>

                            {/if}
                        {/if}

                    </div>


                <div class="col-lg-6">

                    <div class="app-content-header">
                        <div class="float-right  p-3">

                            <table class="w-auto">




                                {if $status eq $lang.paid}
                                    <tr>
                                        <td class="">
                                            {$lang.invoice}
                                        </td>
                                        <td class="colon">
                                            :
                                        </td>
                                        <td  class="text-right">
                                            <h4 class="m-0"> #{$invoicemask} </h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="">
                                            {$lang.orderrefno}
                                        </td>
                                        <td class="colon">
                                            :
                                        </td>
                                        <td  class="text-right">
                                            #{$invoicenum}
                                        </td>
                                    </tr>
                                {else}
                                    <tr>
                                        <td class="" style="vertical-align: middle">
                                            <div> {$lang.orderid} </div>
                                        </td>
                                        <td class="colon"> :  </td>
                                        <td  class="text-right">
                                            <h4 class="m-0">  #{$invoicenum} </h4>
                                        </td>
                                    </tr>
                                {/if}


                                <tr>
                                    <td class="">
                                        {$lang.date}
                                    </td>
                                    <td class="colon">  : </td>
                                    <td  class="text-right">
                                        {$datecreated}
                                    </td>
                                </tr>

                                {if $status eq "Paid"}
                                    <tr>
                                        <td class="">
                                            {$lang.paid} on
                                        </td>
                                        <td class="colon">  : </td>
                                        <td  class="text-right">
                                            {$datepaid}
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                {/if}



                                {if $status eq $lang.waitingapproval || $status eq $lang.paid}
                                {else}
                                    <tr>
                                        <td class="">
                                            Payment Due by
                                        </td>
                                        <td class="colon"> :  </td>
                                        <td  class="text-right">
                                            {$datedue}
                                        </td>
                                    </tr>
                                {/if}

                            </table>



                        </div>
                    </div>
                </div>


            </div>

            </div>

            <div class="bg-white">

                <div class="">
                <div class="table-responsive table-invoice-items">
                    <table class="table  table-striped">
                    <thead>
                    <tr>
                        <th class="w-100">{$lang.invoicesdescription}</th>
                        <th class="text-center">{$lang.qnt}</th>
                        <th class="text-right">{$lang.invoicesamount}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach key=num item=invoiceitem from=$invoiceitems}
                        <tr>
                            <td>
                                {$invoiceitem.description} {if $invoiceitem.taxed eq "true"} * {/if}

                                <div class="text-muted">

                                    {if $invoiceitem.freeship eq 1}

                                        <div class="font-normal">{$lang.freeship}</div>{/if}
                                    {if $invoiceitem.bundle}

                                        {foreach from=$invoiceitem.bundle  item=bund}
                                            <div class="font-normal"><i> - {$bund}</i></div>

                                        {/foreach}
                                    {/if}
                                    {if $invoiceitem.customfields}

                                        {foreach from=$invoiceitem.customfields  item=custom}
                                            <div class="font-normal"><i>{$custom.name} : {$custom.value}</i></div>

                                        {/foreach}
                                    {/if}

                                </div>

                            </td>
                            <td class="text-center">
                                {$invoiceitem.qnt}
                            </td>
                            <td class="text-right">
                                {$invoiceitem.amount}
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
                </div>

                    <div class="row">

                    <div class="col-lg-6">
                        <div class="">

                <div>
                    <div class="mt-3">
                        <div class="no-print">

                            <table class="table border-0">
                                {if $offlinepaid}
                                    <tr>
                                        <td>
                                            {$lang.offlinepaid}
                                        </td>
                                    </tr>
                                {else}
                                {/if}

                                {if $codmsg}
                                {else}
                                    {if $applycredit}
                                        <tr>
                                            <td class="p-0">
                                                <div  class="bg-light rounded p-3">
                                                    {$lang.walletbalance} {$totalcredit}.<br />
                                                    {$lang.thiscanbeapplied}<br />
                                                    <br />
                                                    <form method="post" action="{$invoiceurl}" >
                                                        <input type="hidden" name="applycredit" value="true" />
                                                        <input type="hidden" name="id" value="{$invoiceidmd5}" />
                                                        {$lang.enteramount}: <br />
                                                        <input type="text" name="creditamount" class="form-control" value="{$creditamount}" />
                                                        <button type="submit" class="btn btn-primary mt-2" value="{$lang.applycredit}">
                                                            {$lang.applycredit}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    {/if}
                                {/if}

                            </table>
                            <br/>
                        </div>
                    </div>


                </div>

                <div class="py-3">
                    {if $taxrate}
                        <small class="text-muted"> * {$lang.taxindicates}
                            {if $taxtype eq 'Inclusive'}
                                * {$lang.inclusiveofalltaxes}
                            {/if}
                        </small>
                    {/if}
                </div>
            </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="price-details">
                <table class="table border-0  align-items-center">
                    <tr>

                        <td>
                            {$lang.invoicessubtotal}
                        </td>
                        <td class="seperator-colon"> </td>
                        <td>
                            {$subtotal}
                        </td>
                    </tr>
                    {if $taxrate gt 0}
                        <tr>

                            <td>
                                 {$taxname} <span class="text-muted">({$taxrate}%) </span>
                            </td>
                            <td class="seperator-colon"> </td>
                            <td>
                                {$tax}
                            </td>
                        </tr>
                    {/if}
                    {if $taxrate2 gt 0}
                        <tr>

                            <td>
                                {$taxname2} <span class="text-muted">({$taxrate2}%) </span>
                            </td>
                            <td class="seperator-colon"> </td>
                            <td>
                                {$tax2}
                            </td>
                        </tr>
                    {/if}

                    {if $fixedcharge}
                        <tr>

                            <td>
                                {$lang.fixedcharge}
                            </td>
                            <td class="seperator-colon"> </td>
                            <td>
                                {$fixedcharge}
                            </td>
                        </tr>
                    {/if}
                    <tr>

                        <td>
                            {$shippingname}
                        </td>
                        <td class="seperator-colon"> </td>
                        <td>
                            {$shippingcharge}
                        </td>
                    </tr>


                    <tr>

                        <td>
                            {$lang.invoicescredit}
                        </td>
                        <td class="seperator-colon"> </td>
                        <td>
                            {$credit}
                        </td>
                    </tr>
                    {if $promotion gt 0}
                        <tr>
                            <td>
                                {$lang.promotion} [{$promotion_code}]
                            </td>
                            <td class="seperator-colon"> </td>
                            <td>
                                {$promotion}
                            </td>
                        </tr>
                    {/if}
                    <tr>

                        <td> {$lang.invoicestotal} </td>
                        <td class="seperator-colon"> </td>
                        <td class="double-border"><h5>{$total}</h5></td>
                    </tr>


                </table>


            </div>
                        <div class="clearfix"></div>
                    </div>



                    </div>


                    {if $status neq $lang.paid && $status neq $lang.waitingapproval}
                        <div>
                    <div class="ml-auto mt-3" style="max-width: 360px">





                        <div class="rounded p-4   bg-light">

                            <h5>
                                {if $gatewayid neq 'paypalexpress'}

                                    {if $allowchangegateway}
                                    {else}
                                        {$paymentmethod}
                                    {/if}
                                {/if}
                            </h5>

                            <table class="w-100"><tr>

                                    <td>
                                        {if $allowchangegateway}
                                            <form method="post" action="{$invoiceurl}" class="mb-4 bottom-space">
                                                {if $accesskey}
                                                    <input type="hidden" name="accesskey" value="{$accesskey}" />
                                                {/if}
                                                <input type="hidden" name="id" value="{$invoiceidmd5}" />
                                                {$gatewaydropdown}
                                            </form>
                                        {else}
                                            {* {$paymentmethod}*}
                                        {/if}

                                        {if $codmsg}
                                            {$codmsg} <br/><br/>
                                        {else}
                                            {if $blockpayment eq 1}
                                                <button class="btn btn-primary mt-2"
                                                        onclick="kycredirect();"
                                                        name="kyc" value="KYC Verification" >KYC Verification</button>
                                            {else}
                                                <div class="payment-btn"> {$paymentbutton} </div>
                                            {/if}
                                        {/if}
                                    </td></tr></table>


                            <form method="post" action="viewinvoice/?a=1&id={$idsn}" enctype="multipart/form-data">

                                {if $screenshot}
                                    <div class="form-group">
                                        <div class="form-label">
                                            Screen shot
                                        </div>
                                        <input type="file" name="screenshot" />
                                    </div>
                                {/if}

                            {if $customfields}
                                {foreach from=$customfields key=name item=fields}
                                    <div class="form-group custom-field">
                                        <div class="form-label">
                                            {$name}  {$fields.required}
                                        </div>
                                        {$fields.input} <div>{$fields.description} </div>
                                    </div>
                                {/foreach}


                            {/if}


                            {if $customfields  or $screenshot}
                                <div class="form-group m-0">
                                    <input class="btn btn-primary" type="submit" name="submitdetail" value="Submit Payment Details" />
                                </div>
                            {/if}

                        </form>
                        </div>



                    </div>
                </div>



                    {/if}

            </div>

            </div>

        </div>

        {if $notes}
            <div class="invoicesnotes">
                {$lang.invoicesnotes}:
                {$notes}
            </div>
        {/if}

    </div>



    {if $transactions}
        <div class="card ">
            <h5>Transactions</h5>
            <div class="table-responsive mt-4">
                <table id="itemstable" class="table  table-striped">
                    <thead>
                    <tr>
                        <th>{$lang.invoicestransdate}</th>
                        <th>{$lang.invoicestransgateway}</th>
                        <th>{$lang.invoicestransid}</th>
                        <th class="text-right">{$lang.invoicestransamount}</th>
                    </tr>
                    </thead>
                    {foreach key=num item=transaction from=$transactions}
                        <tr>
                            <td>
                                {$transaction.date}
                            </td>
                            <td>
                                {$transaction.gateway}
                            </td>
                            <td>
                                {$transaction.transid}
                            </td>
                            <td class="text-right">
                                {$transaction.amount}
                            </td>
                        </tr>
                        {foreachelse}
                        <tr>
                            <td colspan="4">
                                {$lang.invoicestransnonefound}
                            </td>
                        </tr>
                    {/foreach}
                </table>
            </div>

            <div class="app-content-header">
                <div class="text-right p-3 "> <h6>{$lang.invoicesbalance} : {$balance} </h6> </div>
            </div>
        </div>
    {/if}







    </div>
</div>

{if $instapay}
    {literal}
        <script>
            launchBOLT();
        </script>
    {/literal}
{/if}

<div class="content-loader" id="payment_loader">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div>
            <div class="spinner-loader p-3"><i class="fal fa-spinner fa-spin fa-3x fa-fw"></i></div>
            {$lang.pleasewait}
        </div>
    </div>
</div>



