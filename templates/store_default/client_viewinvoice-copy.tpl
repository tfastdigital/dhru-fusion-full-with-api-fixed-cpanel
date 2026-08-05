{if $standalone || $fromapp }
    <!DOCTYPE html>
<html lang="en" class="no-js js">
<head>
    {include file="templates/default/chunks/header-head.tpl"}
    {include file="templates/default/chunks/app-css.tpl"}
</head>
<body>
{/if}


<div class="container pt-3">
    <div class="card">


        {if $notification.error}
            <div style="display: block" class="alert alert-danger">{$notification.error}</div>
        {elseif $notification.success}
            <div style="display: block" class="alert">{$notification.success}</div>
        {/if}
        <div class="row">
            <div class="col-lg-6">
                <div class="app-content-header">
                    {if $logo}
                        <img src="{$logo}"/>
                    {else}
                        <h2>
                            {$companyname}
                        </h2>
                    {/if}
                    {$payto}
                </div>
            </div>
            <div class="col-lg-6">

                <div class="app-content-header">
                    <div class="text-lg-right">
                        <h4>
                            #{$invoicemask}
                        </h4>
                        Ref No :#{$invoicenum}<br/>
                        {if $status eq    "Unpaid"}
                            <label class="badge badge-danger">
                                {$lang.invoicesunpaid}
                            </label>
                        {elseif $status eq "Paid"}
                            <label class="badge badge-success">
                                {$lang.invoicespaid} on {$datepaid}
                            </label>
                        {elseif $status eq    "Refunded"}
                            <label class="badge badge-inverse">
                                {$lang.invoicesrefunded}
                            </label>
                        {elseif $status eq    "Cancelled"}
                            <label class="badge badge-danger">
                                {$lang.invoicescancelled}
                            </label>
                        {elseif $status eq "Collections"}
                            <label class="label">
                                {$lang.invoicescollections}
                            </label>
                        {/if}

                        <div>
                            <label class="label">
                                {$lang.date} : {$datecreated}
                            </label>
                        </div>

                        <div class="font-normal">Payment Due by {$datedue}    </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="card-app">
            <div class="row">
                <div class="col-lg-6">
                    <div class="px-3 px-sm-0">
                        {if $userdetailsd.companyname}{$userdetailsd.companyname}
                            <br/>
                        {/if}
                        <strong>{$userdetailsd.firstname} {$userdetailsd.lastname}</strong>
                        <div class="font-normal">
                            <div>{$userdetailsd.address1}  {$userdetailsd.address2}  </div>
                            <div> {$userdetailsd.city} {$userdetailsd.postcode}</div>
                            <div>{$userdetailsd.state} </div>
                            <div> {$userdetailsd.country} </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">

                    <div class="text-left-right mt-3">


                        <div class="">
                            <div class="no-print">

                                <table class="table">
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
                                                <td>
                                                    {$lang.yourcreditbalance} {$totalcredit}.<br/>
                                                    {$lang.thiscanbeapplied}<br/>
                                                    <br/>
                                                    <form method="post" action="{$viewinvoiceurl}">
                                                        <input type="hidden" name="applycredit" value="true"/>
                                                        <input type="hidden" name="id" value="{$invoiceidmd5}"/>
                                                        {$lang.enteramount}: <br/>
                                                        <input type="text" name="creditamount" class="form-control"
                                                               value="{$creditamount}"/>
                                                        <button type="submit" class="btn btn-primary mt-2"
                                                                value="{$lang.applycredit}">
                                                            {$lang.applycredit}
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        {/if}
                                    {/if}

                                </table>
                            </div>
                        </div>


                        {if $status eq "Unpaid"}

                        <div class="p-3">
                            <table class="w-100">
                                <tr>
                                    <td>
                                        {if $allowchangegateway}
                                            <form method="post" action="{$viewinvoiceurl}" class="mb-4 bottom-space">
                                                {if $accesskey}
                                                    <input type="hidden" name="accesskey" value="{$accesskey}"/>
                                                {/if}
                                                <input type="hidden" name="id" value="{$invoiceidmd5}"/>
                                                {$gatewaydropdown}
                                            </form>
                                        {else}
                                            {$paymentmethod}
                                        {/if}


                                        <form method="post" action="{$viewinvoiceurl}?a=1&id={$idsn}"
                                              enctype="multipart/form-data" class="mb-4 bottom-space">
                                            {if $customfields}
                                                {foreach from=$customfields key=name item=fields}
                                                    <div class="form-group ">
                                                        <label class="form-label">
                                                            {$name}
                                                        </label>
                                                        <div class="controls">
                                                            {$fields.input}{$fields.required} {$fields.description}
                                                        </div>
                                                    </div>
                                                {/foreach}
                                            {/if}
                                            {if $screenshot}
                                                <div class="form-group ">
                                                    <label class="form-label">
                                                        Screen shot
                                                    </label>
                                                    <div class="controls">
                                                        <input type="file" name="screenshot"/>
                                                    </div>
                                                </div>
                                            {/if}
                                            {if $customfields or $screenshot}
                                                <input class="btn" type="submit" name="submitdetail"
                                                       value="Submit Details"/>
                                            {/if}
                                        </form>

                                        {if $codmsg}
                                            <br/>
                                            {$codmsg}
                                        {else}
                                            {$paymentbutton}
                                        {/if}

                                        {elseif $status eq    "Paid"}
                                        {$paymentmethod}
                                        ({$datepaid})
                                        <br/>
                                        {foreach from=$invoicecustom key=keyids item=fields}
                                            {$fields.name} : {$fields.value}
                                            <br/>
                                        {/foreach}
                                        {/if}

                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table  table-striped">
                    <thead>
                    <tr>
                        <th>{$lang.invoicesdescription}</th>
                        <th>{$lang.qnt}</th>
                        <th class="text-right">{$lang.invoicesamount}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach key=num item=invoiceitem from=$invoiceitems}
                        <tr>
                            <td>
                                {$invoiceitem.description} {if $invoiceitem.taxed eq "true"} * {/if}
                                {if $invoiceitem.freeship eq 1}
                                    <br/>
                                    <div class="font-normal">{$lang.freeship}</div>{/if}
                                {if $invoiceitem.bundle}
                                    <br/>
                                    {foreach from=$invoiceitem.bundle  item=bund}
                                        <div class="font-normal"><i> - {$bund}</i></div>
                                        <br/>
                                    {/foreach}
                                {/if}
                                {if $invoiceitem.customfields}
                                    <br/>
                                    {foreach from=$invoiceitem.customfields  item=custom}
                                        <div class="font-normal"><i>{$custom.name} : {$custom.value}</i></div>
                                        <br/>
                                    {/foreach}
                                {/if}
                            </td>
                            <td>
                                {$invoiceitem.qnt}
                            </td>
                            <td class="text-right">
                                {$invoiceitem.amount}
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>

                <div class="price-details">
                    <table class="table align-items-center">
                        <tr>
                            <td class="w-100">
                                {$lang.invoicessubtotal}
                            </td>
                            <td> :</td>
                            <td>
                                {$subtotal}
                            </td>
                        </tr>
                        {if $taxrate gt 0}
                            <tr>
                                <td>
                                    {$taxrate}% {$taxname}
                                </td>
                                <td> :</td>
                                <td>
                                    {$tax}
                                </td>
                            </tr>
                        {/if}
                        {if $taxrate2 gt 0}
                            <tr>
                                <td>
                                    {$taxrate2}% {$taxname2}
                                </td>
                                <td> :</td>
                                <td>
                                    {$tax2}
                                </td>
                            </tr>
                        {/if}
                        <tr>
                            <td>
                                {$shippingname}
                            </td>
                            <td> :</td>
                            <td>
                                {$shippingcharge}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {$lang.invoicescredit}
                            </td>
                            <td> :</td>
                            <td>
                                {$credit}
                            </td>
                        </tr>
                        {if $promotion gt 0}
                            <tr>
                                <td>
                                    {$lang.promotion} [{$promotion_code}]
                                </td>
                                <td> :</td>
                                <td>
                                    {$promotion}
                                </td>
                            </tr>
                        {/if}
                        <tr>
                            <td> {$lang.invoicestotal} </td>
                            <td> :</td>
                            <td><span style="font-size: 20px">{$total}</span></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-left"> {if $taxrate}  * {$lang.taxindicates}
                                    {if $taxtype eq 'Inclusive'}
                                        * Inclusive of all Taxes
                                    {/if}
                                {/if}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>


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
                    <tr>
                        <td class="text-right" colspan="4">{$lang.invoicesbalance} : {$balance}</td>
                    </tr>
                </table>
            </div>


            {if $instapay}
            {literal}
                <script>
                    launchBOLT();
                </script>
            {/literal}
            {/if}
            {if $notes}
                <div class="invoicesnotes">
                    {$lang.invoicesnotes}:
                    {$notes}
                </div>
            {/if}

        </div>

    </div>
</div>

{if $standalone || $fromapp}
</body>
</html>
{/if}
