{*
<div id="tabcontent">

  <form method="post">
    <table class="table table-bordered">
      <tr>
        <th width="30%"><span>{$lang.items}</span></th>
        <th width="50%" align="left"></th>
        <th><div align="center">{$lang.qnt}</div></th>
        <th width=""><div align="center">{$lang.price}</div></th>
      </tr>
      <tbody>

      {foreach from=$cartitems key=id item=cartitem}
      <tr>
        <td>
            {if $cartitem.orderdetail.thumb}
                <img title="{$cartitem.orderdetail.description}" alt="{$cartitem.orderdetail.description}"  src="{$cartitem.orderdetail.thumb}" border="0"/>
            {else}
                {if $cartitem.orderdetail.image_link}
                    <div class="loadme"><img class="resize" title="{$cartitem.orderdetail.description}" alt="{$cartitem.orderdetail.description}"  src="{$cartitem.orderdetail.image_link}" border="0"/></div>
                {else}
                    <div class="div_small_noimage" style="border:#F1EFF0 solid 1px;"><span>{$lang.image}</span> <span>{$lang.not}</span> <span>{$lang.found}</span></div>
                {/if}
            {/if}
        </td>
        <td  valign="top" align="left">{$cartitem.name}{if $cartitem.orderdetail.taxed} * {/if}<br />
              {if $cartitem.orderdetail.freeship eq 1}
                <small>{$lang.freeship}</small><br />
              {/if}
             {foreach from=$cartitem.orderdetail.customfield  item=cust}
              <small>{$cust}</small> <br />
             {/foreach}
          <small>{$cartitem.orderdetail.imei}</small> <br />
          <small ><a class="red" href="cart.php?action=view&delete={$id}" ><span style="color:red">{$lang.delete}</span></a></small> </td>
        <td><div align="center">{if $cartitem.type eq "product"}
            {assign var="update" value="true"}
            <input type="text" style="width:30px;" name="qnt[{$id}]" value="{$cartitem.qnt}" />
            {else}
            {$cartitem.qnt}
            {/if} </div></td>
        <td><div align="center"><span class="prefix">{$currency.prefix}</span> {$cartitem.orderdetail.credit-$cartitem.orderdetail.discount} <span class="suffix">{$currency.suffix}</span> </div></td>
      </tr>
      {/foreach}
      </tbody>
      <tr>
        <td colspan="3"><div align="right"><strong>{$lang.subtotal} :</strong> </div></td>
        <td align="center"><strong>{$subtotal}</strong></td>
      </tr>
      {if $taxrate}
      <tr>
        <td colspan="3"><div align="right"><strong>{$taxper}% {$taxname} :</strong> </div></td>
        <td align="center"><strong>{$taxrate}</strong></td>
      </tr>
      {/if}
      {if $taxrate2}
      <tr>
        <td colspan="3"><div align="right"><strong>{$taxper2}% {$taxname2} :</strong> </div></td>
        <td align="center"><strong>{$taxrate2}</strong></td>
      </tr>
      {/if}
      <tr>
        <td colspan="3"><div align="right"><strong>{$lang.invoicestotal} :</strong> </div></td>
        <td align="center"><strong>{$total}</strong></td>
      </tr>
      <tr>
        <td colspan="4"><br />
          <div align="right">
            <input type="button" class="btn" onclick="location.href='cart.php?action=continue';" value="{$lang.continueshopping}" style="border-radius:20px;" />
            &nbsp;&nbsp;&nbsp;
            {if $update}
            <input type="submit" class="btn btn-info" name="update" value="{$lang.updatecart}" />
            &nbsp;&nbsp;&nbsp;
            {/if}
            <input type="button" class="btn btn-danger" onclick="location.href='cart.php?action=emptycart';" value="{$lang.emptycart}" />
            &nbsp;&nbsp;&nbsp;
            <input type="button" class="btn-success btn" onclick="location.href='cart.php?action=checkout';" value="{$lang.next}" />
          </div>
        </td>
      </tr>
    </table>
    <br />
  </form>
</div>
</div>

{if $standalone}
{else}
	{include file="templates/default/cart_rightmenu.tpl"}
{/if}
*}
