{if $standalone && !$productorderslist}
{else}
{if $standalone}{else}
    <div id="tabcontent">

{/if}
  {if $notification.success}
    <div    class="alert alert-success" >{$notification.success}</div>
  {elseif $notification.error}
    <div  class="alert alert-error" >{$notification.error}</div>
  {/if}

  <div class="searchForm">
    <h6>{$lang.filterlist}</h6>
    <form method="post" action="order.shopping.php" name="filterorderproduct" id="filterorderproduct" >
      {$token}
      <select name="serviceid" id="service_id" >
        <option value="">{$lang.select}</option>
         {foreach from=$productservicelist key=id item=Services}
            <option   value="{$id}" >{$Services}</option>
         {/foreach}
      </select>
      <input type="text" name="searchvalue" />
      <input type="submit" class="btn" name="search" value="{$lang.search}" />
    </form>
  </div>

  <table class="table">
    <tr>
      <th width="20">#{$lang.ID}</th>
      <th><div align="left">{$lang.service}</div></th>
      <th align="right"></th>
      <th {if $status eq 'rejected'}{/if}>{if $status neq 'pending'}<div align="left">{$lang.reply}</div>{/if}</th>
      {if $status neq 'rejected'}<th align="right">{$lang.action}</th>{/if}
     </tr>
    {foreach from=$productorderslist key=id item=order}
    <tr id="h_{$id}" >
      <!--<td>{$order.order_id}</td>-->
      <td>{$order.invoiceid}</td>
      <td>{$order.service}</td>
      <td class="view" width="30px" >
      {if $order.shipstatus eq 0}{$lang.new}{/if}
      {if $order.shipstatus eq 1}{$lang.inprocess}{/if}
      {if $order.shipstatus eq 4}{$lang.sent}{/if}
      {if $order.shipstatus eq 3}{$lang.rejected}{/if}
      {if $order.shipstatus eq 6}{$lang.onhold}{/if}
      {if $order.shipstatus eq 7}{$lang.received}{/if}
      </td>
      <td {if $status eq 'rejected'} align="right" {/if}>{if $status neq 'pending'}{$order.reply}{/if}</td>
      {if $status neq 'rejected'}<td align="right" >{$order.action}</td>{/if}
    </tr>
    {foreachelse}
    <tr >
      <td colspan="5">{$lang.norecordsfound}</td>
    </tr>
    {/foreach}
  </table>
  {if $standalone}{else}
  <div align="center" class="pagination">{$paginate}</div>
</div>
</div>
{include file="templates/default/client_orderdtl_rightmenu.tpl"}{/if}
{/if}
