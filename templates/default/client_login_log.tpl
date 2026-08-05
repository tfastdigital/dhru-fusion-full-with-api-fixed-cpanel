<script type="text/javascript" src="includes/js/jtip.js"></script>
<link rel="stylesheet" type="text/css" href="templates/default/css/tooltip.css" />
<div id="tabcontent">
   <table class="table">
      <tr>
        <th>#{$lang.ip}</th>
        <th><div align="left">{$lang.time}</div></th>
      </tr>
     {foreach from=$fileorderslist key=id item=order}
      <tr >
        <td>{$order.order_id}</td>
        <td>{$order.service}</td>
      </tr>
      {foreachelse}
      <tr >
        <td colspan="4">{$lang.norecordsfound}</td>
      </tr>
      {/foreach}
   </table>
</div>
</div>

