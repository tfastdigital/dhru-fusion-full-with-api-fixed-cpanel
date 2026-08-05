
<form  method="post" name="store" id="store">
  <div   class="alert"></div>
  <div class="table-responsive">
    <table class="table  table-striped">
      <thead>
        <tr>
          <th>{$lang.user} </th>
          <th>{$lang.product} </th>
          <th>{$lang.date} </th>
          <th>{$lang.my} {$lang.earnings}</th>

        </tr>
      </thead>
      <tbody>
		  {foreach from=$myorders key=id item=order}
		  <tr>
			<td>{$order.user}</td>
			<td>{$order.service} [#{$order.order_id}]</td>
			<td>{$order.date}</td>
			<td>{$order.commission|string_format:"%.2f"} [{$order.disc|string_format:"%.2f"}%]</td>

		  </tr>
		  {/foreach}
        </tbody>
    </table>
  </div>
</form>
