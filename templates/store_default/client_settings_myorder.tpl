
<div class="container"><div class="page-container">

  <form  method="post" name="editprofile" id="editprofile" enctype="multipart/form-data">
    <div    class="alert"></div>
    {$token}
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>{$lang.item}</th>
            <th>{$lang.status}</th>
            <th class="text-center">{$lang.purchasedate}</th>
            <th class="text-center">{$lang.invoicesdatedue}</th>
            <th class="text-center">{$lang.action}</th>
          </tr>
        </thead>
        <tbody>

        {foreach from=$items key=id item=order}
        <tr>
          <td> #{$order.order_id}
            {if $order.domain}
            {$order.domain}
            {else}
            {$order.service}
            {/if} </td>
          <td>{$order.sstate}</td>
          <td align="center"> {if $order.activation}
            {$order.activation}
            {else}
            {$order.date}
            {/if} </td>
          <td class="text-center">{if $order.expiry}{$order.expiry}{/if}</td>
          <td class="text-center"><a href="settings/myorder?edit={$id}">{$lang.edit}</a></td>
        </tr>
          </tbody>

        {/foreach}
      </table>
    </div>
  </form>
  </div></div>
