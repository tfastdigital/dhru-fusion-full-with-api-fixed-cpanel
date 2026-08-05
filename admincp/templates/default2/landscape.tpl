<html >
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<title>{$companyname} - {$invoicenum}</title>

<style type="text/css">
#receipt_wrapper
{
	font-family:Arial;
	width:100%;	
}

#receipt_header
{
	text-align:center;
}

#company_name
{
	font-size:150%;
	font-weight:bold;
}

#company_phone
{
	margin-bottom:15px;

}

#sale_time
{
	margin-bottom:5px;
}

#receipt_items
{
	position:relative;
	border-collapse:collapse;
	margin-top:15px;
	margin-bottom:15px;
	width:100%;
}

#receipt_items td
{
	position:relative;
	padding:3px;	
}

.short_name
{
	display:none;
}

#sale_return_policy
{
	width:80%;
	margin:0 auto;
	text-align:center;
}

#barcode
{
	margin-top:10px;
	text-align:center;
}

#signature
{
	margin-top: 30px;
	text-align: center;
}
html {
    overflow: auto;
}
</style>
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
</head>
<body  id="printers" {if $print} onload="printdiv('printers');" {/if} >
<div align="center"><input type="button" name="print" value="Print Invoice" onclick="printdiv('printers')" /></div>

<div id="receipt_wrapper" >
	<div id="receipt_header" align="center">
	
		<div id="company_address" style="float: left;" align="left">{$payto}</div>
        <div id="company_address"  style="float: right" align="right">{$lang.invoicesinvoicedto} :<br />
{if $userdetails.companyname}{$userdetails.companyname}<br />
{/if} {$userdetails.firstname} {$userdetails.lastname}<br />
{$userdetails.address1}, {$userdetails.address2}<br />
{$userdetails.city}, {$userdetails.state}, {$userdetails.postcode}<br />
{$userdetails.country} <br />

{if $status neq "Paid"} {$balance}
{$lang.invoicesdatedue}: {$datedue} 

{/if} 

</div>

	<div style="clear:both"> </div>
<span style="width:100%;" >  </span>  
		<div id="sale_receipt" style="float:right;">Sales Receipt <br /> {$datecreated}</div>

		<div id="sale_time" style="float:right;"></div>
	</div>
	<div id="receipt_general_info">
				<div id="sale_id">Sale ID: <strong>{$invoicenum}</strong></div>
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
            	<font class="refunded">{$lang.invoicesrefunded}</font> {elseif $status eq "Cancelled"} <font class="cancelled">
              {$lang.invoicescancelled}</font> {elseif $status eq "Collections"} <font class="collections">{$lang.invoicescollections}</font> 
          {/if}
	</div>
<span style="width:100%;" >  </span>  
 
    <br />
    <table id="receipt_items" style="WIDTH: 100%;">
	<tr>
	<th style="width:33%;text-align:left;">Item</th>
	<th style="width:15%;text-align:center;">Qty.</th>
    <th style="width:20%;text-align:center;">Price</th>
	</tr>
    
  {foreach key=num item=invoiceitem from=$invoiceitems}  
	<tr>
	<td style="text-align:left;">
            {$invoiceitem.description} {if $invoiceitem.taxed eq "true"} * {/if}
    </td>
	<td style='text-align:center;'>{$invoiceitem.qnt}</td>
    <td style="text-align:center;">{$invoiceitem.amount}</td>
    </tr>
 {/foreach}
	   


	    <tr>
	    <td align="center"></td>
		<td  ></td>
		<td > </td>
	    </tr>

	<tr>
    <td style='text-align:right;border-top:2px solid #000000;'> </td>
	<td style='text-align:right; border-top:2px solid #000000;'>Sub Total</td>
	<td style='text-align:center;border-top:2px solid #000000;'>{$subtotal}</td>
	</tr>
{if $taxrate}
	<tr>
    <td style='text-align:right;'> </td>
	<td style='text-align:right;'>{$taxrate}% {$taxname}:</td>
	<td style='text-align:center;'>{$tax}</td>
	</tr>
{/if}
{if $taxrate2}
	<tr>
    <td> </td>
	<td style='text-align:right;'>{$taxrate2}% {$taxname2}:</td>
	<td  style='text-align:center;'>{$tax2}</td>
	</tr>
{/if}        
{if $shippingcharge}
<tr>
<td> </td>
<td  style='text-align:right;'>{$shippingname}:</td>
<td  style='text-align:center;'>{$shippingcharge}</td>
</tr>
{/if}
{if $promotion}
<tr>
<td> </td>
<td colspan="2" style='text-align:right;'>{$lang.promotion} [{$promotion_code}]:</td>
<td  style='text-align:right;'>{$promotion}</td>
</tr>
{/if} 
<tr>
<td> </td>
<td  style='text-align:right;'>{$lang.invoicescredit}:</td>
<td  style='text-align:center;'>{$credit}</td>
</tr>
{if $tdiscount}
<tr>
<td> </td>
<td  style='text-align:right;'><div align="right">{$lang.discount}: </div></td>
<td  align="center"><strong>{$tdiscount}</strong></td>
</tr>        
{/if}
<tr>
<td> </td>
<td style='text-align:right;'>Total</td>
<td  style='text-align:center'>{$total}</td>
</tr>

<tr><td colspan="3"> </td></tr>
 {if $taxrate}
      <tr>
      <td align="center" colspan="3">
        * {$lang.taxindicates} 
        {if $taxtype eq 'Inclusive'}
        <br />
        * Inclusive of all Taxes
        {/if}
        </td>
        
      </tr>
      
{/if} 

		
    <tr><td colspan="3"> </td></tr>
				


	</table>
<span style="width:100%;" >  </span>  
 {if $transactions}
      <p><strong>{$lang.invoicestransactions}</strong></p>
      <table cellspacing="0" id="itemstable" style="width: 100%;" align="center">
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
          <td id="itemsheading" width="30%" colspan="3"><div align="right"><strong>{$lang.invoicesbalance}: </strong></div></td>
          <td id="itemsheading" align="center" width="20%" ><strong>{$balance}</strong></td>
        </tr>
      </table>
      {/if} 
      {if $notes} <br />
      <div class="invoicesnotes"><strong>{$lang.invoicesnotes}:</strong> <br />
        {$notes}</div>
      {/if}


</div>
	
</body>
</html>

