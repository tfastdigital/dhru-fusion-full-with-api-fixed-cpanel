<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$companyname} - {$invoicenum} </title>
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

<div align="center">
    <div style="width: 300px;">
    <h3>{$companyname}</h3>
    <br />
    <span>{$payto}</span>
    <br />
    <br />
    
    <div align="left">
    <strong>{$lang.invoicesinvoicedto}</strong>:<br />
            {if $userdetails.companyname}{$userdetails.companyname}<br />
            {/if}
            {$userdetails.firstname} {$userdetails.lastname}<br />
            {$userdetails.address1}, {$userdetails.address2}<br />
            {$userdetails.city}, {$userdetails.state}, {$userdetails.postcode}<br />
            {$userdetails.country}
     </div>
     <span>-</span>
     <table width="100%">
     <tr>
     <th width="50%">ITEM CODE/DESR.</th>
     <th width="25%">QNT</th>
     <th>PRICE</th>
     </tr>
     </table>
     <span>-</span>
      <table width="100%">
      {foreach key=num item=invoiceitem from=$invoiceitems}
        <tr>
          <td width="50%" >{$invoiceitem.description} {if $invoiceitem.taxed eq "true"} * {/if}
          </td>
          <td width="25%" align="center" >{$invoiceitem.qnt}</td>
          <td align="right"  > {$invoiceitem.amount}</td>
        </tr>
        {/foreach}
        
        <tr>
        <td colspan="2" align="right">Subtotal:</td>
        <td>{$subtotal}</td>
        </tr>
     {if $t1 gt 0}  
         <tr>
        <td colspan="2" align="right">{$taxrate}% {$taxname}:</td>
        <td>{$tax}</td>
        </tr> 
     {/if}   
     {if $t2 gt 0}   
         <tr>
        <td colspan="2" align="right">{$taxrate2}% {$taxname2}:</td>
        <td>{$tax2}</td>
        </tr> 
     {/if}    
{if $s gt 0} 
         <tr>
        <td colspan="2" align="right">{$shippingname}:</td>
        <td>{$shippingcharge}</td>
        </tr>
{/if}
{if $promotion}
         <tr>
        <td colspan="2" align="right">{$lang.promotion} [{$promotion_code}]:</td>
        <td>{$promotion}</td>
        </tr>
{/if} 
{if $c gt 0}
<tr>
<td  colspan="2" align="right" >{$lang.invoicescredit}:</td>
<td>{$credit}</td>
</tr> 
{/if}  
{if $tdiscount}
<tr>
<td  colspan="2" align="right" >{$lang.discount}:</td>
<td  >{$tdiscount}</td>
</tr>
 {/if}             
         </table>
         
         <div align="right">===========</div>
      <table width="100%">
     <tr>
     <th width="50%">TOTAL</th>
     <th width="25%"></th>
     <th>{$total}</th>
     </tr>
     </table> 
      {if $transactions}
      <p><strong>{$lang.invoicestransactions}</strong></p>
      <table cellspacing="0" id="itemstable" align="center">
        <tr>
          <td id="itemsheading" ><strong>{$lang.date}</strong></td>
          <td id="itemsheading" ><strong>{$lang.gateway}</strong></td>
          <td id="itemsheading" ><strong>{$lang.id}</strong></td>
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
        {$notes} 
        {/if} 
        {if $taxrate}
      <p>
        * {$lang.taxindicates} 
                {if $taxtype eq 'Inclusive'}
                <br />
                * Inclusive of all Taxes
                {/if}
        </p>
        {/if}
      <span>-</span>
      <div align="left">
     {$lang.invoicenumber}: {$invoicenum}<br />
      {$lang.invoicesdatecreated}: {$datecreated} <br />
      </div>
      
    </div>
</div>
<p>  </p>
</body>
</html> 