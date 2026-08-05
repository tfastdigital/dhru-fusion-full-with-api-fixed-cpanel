<html>
<head>
<title>{$companyname} - {$invoicenum}</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
{if $adminurl}
    <base href="{$adminurl}" />
{/if}
<link rel="stylesheet" type="text/css" href="templates/{$template}/css/invoice.css" />
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
</head><body  id="printers" {if $print} onload="printdiv('printers');" {/if}>
{if $notification.error}
    <div id="notification" class="errorbox">{$lang.invoiceserror}</div>
{else}
{if $smarty.get.paymentsuccess}
    <div id="notification" class="successbox">{$lang.paymentsuccess}</div>
{elseif $smarty.get.paymentfailed}
    <div id="notification" class="errorbox">{$lang.paymentfailed}</div>
{/if}
<div align="center"><input type="button" name="print" value="Print Invoice" onclick="printdiv('printers')" /></div>

<table id="wrapper" cellspacing="1" cellpadding="10"  align="center">
  <tr>
    <td bgcolor="#ffffff"><table width="100%" id="invheader">
        <tr>
          <td align="left" width="50%" id="invheader"><strong>{$lang.invoicenumber}{$invoicenum}</strong> </td>
          <td align="right" width="50%" id="invheader"> {$lang.invoicesdatecreated}: {$datecreated} </td>
        </tr>
      </table>
      <br />
      <table width="100%">
        <tr>
          <td width="50%"> {if $logo}
            <p><img src="{$logo}" /></p>
            {else}
            <h1>{$companyname}</h1>
            {/if} <strong>{$lang.invoicespayto}</strong><br />
            {$payto} </td>
          <td width="50%" align="right">
          {if $status eq "Unpaid"}
            <font class="unpaid">{$lang.invoicesunpaid}</font><br />
            {if $allowchangegateway}
               
            {else}
            	{$paymentmethod}<br />
            {/if}
            {$paymentbutton}
          {elseif $status eq "Paid"} <font class="paid">{$lang.invoicespaid}</font><br />
            	{$paymentmethod}<br />
            	({$datepaid})
          {elseif $status eq "Refunded"} 
            	<font class="refunded">{$lang.invoicesrefunded}</font> {elseif $status eq "Cancelled"} <font class="cancelled">{$lang.invoicescancelled}</font> {elseif $status eq "Collections"} <font class="collections">{$lang.invoicescollections}</font> 
          {/if} 
          </td>
        </tr>
      </table>
      {if $offlinepaid}
      	<p align="center" class="refunded">{$lang.offlinepaid}</p>
      {else} <br />
      {/if}
      {if $applycredit}
      <table width="100%" class="applycredit">
        <tr>
          <td> {$lang.yourcreditbalance} {$totalcredit}. {$lang.thiscanbeapplied}<br />
            <br />
            <form method="post" action="viewinvoice.php">
              <input type="hidden" name="applycredit" value="true" />
              <input type="hidden" name="id" value="{$invoiceidmd5}" />
              {$lang.enteramount}:
              <input type="text" name="creditamount" size="10" value="{$creditamount}" />
              <input type="submit" value="{$lang.applycredit}" />
            </form></td>
        </tr>
      </table>
      <br />
      {/if}
      <table width="100%" id="clientdetails" cellspacing="0">
        <tr>
          <td width="50%" align="left" valign="top" ><strong>{$lang.invoicesinvoicedto}</strong><br />
            {if $userdetails.companyname}{$userdetails.companyname}<br />
            {/if}
            {$userdetails.firstname} {$userdetails.lastname}<br />
            {$userdetails.address1}, {$userdetails.address2}<br />
            {$userdetails.city}, {$userdetails.state}, {$userdetails.postcode}<br />
            {$userdetails.country} </td>
          <td width="50%" align="right" >
          {if $status neq "Paid"}
          <table bgcolor="white" cellspacing="0" cellpadding="10"  >
              <tr>
                <td valign="top" style="border:1px solid #cccccc" align="center">
                    <span class="dueaamount">{$balance}</span><br />
                    {$lang.invoicesdatedue}: {$datedue}
                </td>
              </tr>
            </table>
          {/if}
          </td>
        </tr>
      </table>
      <br />
    
      <table cellspacing="0" id="itemstable" align="center">
        <tr>
          <td id="itemsheading" align="left" width="70%" ><strong>{$lang.invoicesdescription}</strong></td>
          <td id="itemsheading" align="center" width="10%" ><strong>{$lang.qnt}</strong></td>
          <td id="itemsheading" align="center" width="20%" ><strong>{$lang.invoicesamount}</strong></td>
        </tr>
        {foreach key=num item=invoiceitem from=$invoiceitems}
        <tr bgcolor="#FFFFFF">
          <td id="itemsrow" >{$invoiceitem.description} {if $invoiceitem.taxed eq "true"} * {/if}
            </td>
            <td  id="itemsrow" align="center">{$invoiceitem.qnt}</td>
          <td align="center" id="itemsrow" > {$invoiceitem.amount}</td>
        </tr>
        {/foreach}
        <tr>

          <td id="itemsheading" colspan="2" ><div align="right">{$lang.invoicessubtotal}:&nbsp;</div></td>
          <td id="itemsheading" align="center" ><strong>{$subtotal}</strong></td>
        </tr>
        {if $t1 gt 0}
        <tr>
          <td id="itemsheading" colspan="2" ><div align="right">{$taxrate}% {$taxname}:&nbsp;</div></td>
          <td id="itemsheading" align="center"><strong>{$tax}</strong></td>
        </tr>
        {/if}
       {if $t2 gt 0}
        <tr>
          <td id="itemsheading" colspan="2" ><div align="right">{$taxrate2}% {$taxname2}:&nbsp;</div></td>
          <td id="itemsheading" align="center"><strong>{$tax2}</strong></td>
        </tr>
        {/if}        
        {if $s gt 0}
        <tr>
          <td id="itemsheading" colspan="2" ><div align="right">{$shippingname}:&nbsp;</div></td>
          <td id="itemsheading" align="center"><strong>{$shippingcharge}</strong></td>
        </tr>
        {/if}
        {if $promotion}
        <tr>
          <td id="itemsheading" colspan="2" ><div align="right">{$lang.promotion} [{$promotion_code}]:&nbsp;</div></td>
          <td id="itemsheading" align="center"><strong>{$promotion}</strong></td>
        </tr>        
        {/if}    
        {if $c gt 0}    
        <tr>
          <td id="itemsheading" colspan="2" ><div align="right">{$lang.invoicescredit}:&nbsp;</div></td>
          <td id="itemsheading" align="center"><strong>{$credit}</strong></td>
        </tr>
        {/if}    
        {if $tdiscount}
        <tr>
          <td id="itemsheading" colspan="2" ><div align="right">{$lang.discount}:&nbsp;</div></td>
          <td id="itemsheading" align="center"><strong>{$tdiscount}</strong></td>
        </tr>        
        {/if}
        <tr>
          <td id="itemsheading" colspan="2" ><div align="right">{$lang.invoicestotal}:&nbsp;</div></td>
          <td id="itemsheading" align="center"><strong>{$total}</strong></td>
        </tr>
      </table>
      {if $taxrate}
      <p>
        * {$lang.taxindicates} 
        {if $taxtype eq 'Inclusive'}
        <br />
        * Inclusive of all Taxes
        {/if}
      </p>
      
      {/if} 
      {if $transactions}
      <p><strong>{$lang.invoicestransactions}</strong></p>
      <table cellspacing="0" id="itemstable" align="center">
        <tr>
          <td id="itemsheading" ><strong>{$lang.invoicestransdate}</strong></td>
          <td id="itemsheading" ><strong>{$lang.invoicestransgateway}</strong></td>
          <td id="itemsheading" ><strong>{$lang.invoicestransid}</strong></td>
          <td id="itemsheading" ><strong>{$lang.invoicestransamount}</strong></td>
        </tr>
        {foreach key=num item=transaction from=$transactions}
        <tr >
          <td id="itemsrow" >{$transaction.date}</td>
          <td id="itemsrow">{$transaction.gateway}</td>
          <td id="itemsrow">{$transaction.transid}</td>
          <td id="itemsrow">{$transaction.amount}</td>
        </tr>
        {foreachelse}
        <tr >
          <td id="itemsrow" colspan="4" align="center" > {$lang.invoicestransnonefound}</td>
        </tr>
        {/foreach}
        <tr>
          <td id="itemsheading" width="30%" colspan="3"><div align="right"><strong>{$lang.invoicesbalance}:&nbsp;</strong></div></td>
          <td id="itemsheading" align="center" width="20%" ><strong>{$balance}</strong></td>
        </tr>
      </table>
      {/if} 
      {if $notes} <br />
      <div class="invoicesnotes"><strong>{$lang.invoicesnotes}:</strong> <br />
        {$notes}</div>
      {/if} <br />
      <br />
      <br />
    </td>
  </tr>
</table>
{/if}

</body>
</html>