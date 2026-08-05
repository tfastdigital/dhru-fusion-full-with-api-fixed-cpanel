   <h5>{$lang.invoice} {$lang.id} {$orders.invoiceid}</h5>
<div class="table-responsive">
  <table class="table  table-striped">

        <tr>
          <th>{$lang.item}</th>
          <th>{$lang.price}</th>
          <th>{$lang.status}</th>
          <th>{$lang.action}</th>
         </tr>
        {foreach from=$items key=id item=order}
         <tr>
              <td>{$order.service}</td>
              <td>{$order.credit-$order.discount} {$userdetails.currency.code}</td>
              <td>
              {if $order.user_can_c eq 0}{$lang.new}{/if}
              {if $order.user_can_c eq 1}{$lang.inprocess}{/if}
              {if $order.user_can_c eq 6}{$lang.onhold}{/if}
              {if $order.user_can_c eq 4}{$lang.sent}{/if}
              {if $order.user_can_c eq 7}{$lang.received}{/if}
              {if $order.user_can_c eq 3}{$lang.rejected}{/if}
              </td>
              <td>
              {if $order.days}
                 <a href="ordershopping.php?return={$order.md5}">{$lang.return} {$lang.request}</a>
              {else}
                -
              {/if}
              </td>
        </tr>
        {/foreach}
    </table>
</div>
