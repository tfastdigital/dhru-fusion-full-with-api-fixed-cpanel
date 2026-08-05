<html>
<head>
    <title>{$companyname} - {$invoicenum}</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    {if $adminurl}
        <base href="{$adminurl}" />
    {/if}
    <link rel="stylesheet" type="text/css" href="templates/{$template}/css/invoice.css" />

</head><body id="printers">
{if $notification.error}
<div id="notification" class="errorbox">{$lang.invoiceserror}</div>
{else}
    {if $smarty.get.paymentsuccess}
        <div id="notification" class="successbox">{$lang.paymentsuccess}</div>
    {elseif $smarty.get.paymentfailed}
        <div id="notification" class="errorbox">{$lang.paymentfailed}</div>
    {/if}
{/if}
<h2>Packing Slip #{$invoiceid}</h2>
<div>
<table style="width: 49% !important; float: left;">
    <tr>
        <td>
            Packing Date
        </td>
        <td>
        {$packingdate}
        </td>
    </tr>
    <tr>
        <td>
            Order Date
        </td>
        <td>
            {$invoicedata.date}  {$invoicedata.time}
        </td>
    </tr>
</table>
    <table style="width: 49% !important; float:right;">
        <tr>
            <td>
                {if $logo}
                    <p><img src="{$logo}" /></p>
                {else}
                    <h1>{$companyname}</h1>
                {/if}
            </td>
        </tr>
    </table>
</div>
<div>
    <table style="width: 60%;border: 1px solid #ccc; float: left" id="wrapper" cellspacing="1" cellpadding="10"  align="center">
        <tr>
            <tH style="text-align: left">Ship to</tH>
            <tH style="text-align: left">Bill to</tH>
        </tr>
        <tr>
            <td>
            {if $order.sh_firstname}
                {$order.sh_firstname}
             {else}
                {$userdetails.first_name}
            {/if}
            {if $order.sh_lastname}
                {$order.sh_firstname}
            {else}
                {$userdetails.last_name}
            {/if} <br/>
            {if $order.sh_address1}
                {$order.sh_address1}
            {else}
                {$userdetails.address}
            {/if}<br/>
            {if $order.sh_address2}
                {$order.sh_address2}
            {else}
                {$userdetails.address2}
            {/if}<br/>
            {if $order.sh_city}
                {$order.sh_city} {$order.sh_zip}
            {else}
                {$userdetails.city} {$userdetails.zip}
            {/if}<br/>
            {if $order.sh_state}
                {$order.sh_state}
            {else}
                {$userdetails.state}
            {/if}
            <br/>
                Phone:
            {if $order.sh_contact}
                {$order.sh_contact}
            {else}
                {$userdetails.phonenumber}
            {/if}<br/>
            Email: {if $order.sh_email}
                {$order.sh_email}
            {else}
                {$userdetails.email}
            {/if}


            </td>
            <td>

                    {$userdetails.first_name}
                    {$userdetails.last_name}
                 <br/>

                    {$userdetails.address}
              <br/>

                    {$userdetails.address2}
                <br/>

                    {$userdetails.city} {$userdetails.zip}
                <br/>

                    {$userdetails.state}

                <br/>
                Phone:

                    {$userdetails.phonenumber}
               <br/>
                Email:
                    {$userdetails.email}


            </td>
        </tr>
    </table>

    <table style="width: 39%; float: left; " id="wrapper" cellspacing="1" cellpadding="10"  align="center">
        <tr>
        <td>
           <h2> {$companyname}</h2> <br />{$payto} <br/>
            {$contactemail} <br/>
            {$contactphone}
        </td>
        </tr>
    </table>
</div>
<br/>
<div style="clear: both"><br/><br/></div>

<table class="items"  style="border: 1px solid #ccc; float: left" id="wrapper" cellspacing="1" cellpadding="10"  align="center">

    <thead>
    <tr >

        <td  >Item</td>
        <td  >Qty</td>
    </tr>
    </thead>
    <tbody>
    {foreach key=num item=invoiceitem from=$items}
        <tr>

            <td  >{$invoiceitem.service}
            {if $invoiceitem.sku}<br/>
                SKU: {$invoiceitem.sku}
            {/if}
                {if $invoiceitem.custom}
                    <br />
                    {foreach key=n item=cust from=$invoiceitem.custom}
                            <small>{$cust.name}: {$cust.rawvalue}</small> <br />
                    {/foreach}
                {/if}
            </td>
            <td  >{$invoiceitem.qty}</td>
        </tr>
    {/foreach}
    </tbody>
    <tfoot>
    <tr>
        <td  style="text-align: right"><strong>Total</strong></td>
        <td><strong>{$totalqnt}</strong></td>
    </tr>
    </tfoot>
</table>
<div style="clear: both"></div>
<p align="center">
    {literal}
        <script>
            function printdiv(printpage)
            {
                var headstr = "<html><head><title></title></head><body>";
                var footstr = "</body>";
                var newstr = document.getElementById(printpage).innerHTML;
                var oldstr = document.body.innerHTML;
                document.body.innerHTML = headstr+newstr+footstr;
                window.print();
                document.body.innerHTML = oldstr;
                return false;
            }
        </script>
    {/literal}

    <input type="button" name="print" value="Print Slip" onclick="printdiv('printers')" />
</p>
</body>
</html>

