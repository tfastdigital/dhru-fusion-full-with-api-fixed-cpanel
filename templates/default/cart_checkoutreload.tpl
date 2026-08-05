{if $error}
	<div id='notification1' class='alert alert1 alert-danger' >
		{$error}
	</div>
	{/if}
	<div class="table-responsive">
		<table class="table   table-hover">
			<thead>
				<tr>
					<th><span>{$lang.items}</span></th>
					<th class="text-center">

					</th>
				</tr>
			</thead>
			<tbody>

			{foreach from=$cartitems key=id item=cartitem}
			<tr>
				<td>
					{$cartitem.name}{if $cartitem.orderdetail.taxed} * {/if}  <span class="text-muted"> x </span> {$cartitem.qnt} <br />
					<small>{$cartitem.orderdetail.imei}</small> {if $cartitem.orderdetail.freeship eq 1} <small>{$lang.freeship}</small><br />
					{/if}
					{foreach from=$cartitem.orderdetail.customfield  item=cust} <small>{$cust}</small>
					<br />
					{/foreach}



				</td>

				<td class="text-right">
					<span class="prefix">{$currency.prefix}</span> {$cartitem.orderdetail.credit-$cartitem.orderdetail.discount} <span class="suffix">{$currency.suffix}</span>
				</td>
			</tr>
			{/foreach}
			</tbody>

		</table>

	</div>

		<div class=" price-details float-right">
			<table class="table border-0">

			<tr>

				<td>
					{$lang.subtotal}
				</td>
				<td class="seperator-colon"> </td>
				<td>
					 {$subtotal}
				</td>
			</tr>
			{if $taxrate}
			<tr>

				<td>
					 {$taxname} <span class="text-muted"> ({$taxper}%) </span>
				</td>
				<td class="seperator-colon"> </td>
				<td>
					{$taxrate}
				</td>
			</tr>
			{/if}
			{if $taxrate2}
				{if $taxper2 gt 0}
			<tr>

				<td>
					{$taxname2} <span class="text-muted"> ({$taxper2}%) </span>
				</td>
				<td class="seperator-colon"> </td>
				<td>
					{$taxrate2}
				</td>
			</tr>
				{/if}
			{/if}
			{if $shippingname}
			<tr>

				<td>
					{$lang.shipping} {$lang.charges}

					<small class="text-muted"> <br />
					{$shippingname}
					{if $deliverytime}<br />
						{$lang.deliverytime} : {$deliverytime}
					{/if}
					</small>
				</td>
				<td class="seperator-colon"> </td>
				<td>

					{if $shippingcost}
						{$shippingcost}
					{else}
						{$lang.free}
					{/if}
				</td>
			</tr>
			{/if}
			{if $promotiondiscount}
			<tr>

				<td>
					{$lang.promotion}
				</td>
				<td class="seperator-colon"> </td>
				<td>
					{$promotiondiscount}
				</td>
			</tr>
			{/if}
			<tr>

				<td>
					 {$lang.invoicestotal}
				</td>
				<td class="seperator-colon"> </td>
				<td class="double-border" >
					<h5>{$total}</h5>
				</td>
			</tr>
		</table>
		</div>

		<div class="clearfix"></div>

	<div class="mt-3 border rounded p-3">
		{if !$promotiondiscount}

			<div class="text-left">
				<a  class="d-flex align-items-center justify-content-between collapse-heading collapsed" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
				    <span><i class="fal fa-tag"></i> {$lang.discountcode}   </span>	  <span class="closed">  </span>
				</a>
			</div>

			<div class="collapse"   id="collapseExample">
				<div class="mt-3">
					<div class="input-group" >
						<input type='text' placeholder="{$lang.promotioncode}" class="form-control" name='promotion' id='promotion' />
						<div class="input-group-append">
							<input type='button' class="btn btn-secondary" name='applycode' value="{$lang.applypromotion}" onClick="checkoutreload('#cart_reload','',document.getElementById('promotion').value);" />
						</div>
					</div>
				</div>
				<div class="mt-2">
					<small class="text-muted">
						{$lang.onediscountnotepromomsg}
					</small>
				</div>
			</div>
		{else}
			<a href='javascript: void(0)' onClick="checkoutreload('#cart_reload','','REMOVEPROMO');">
				{$lang.remove} {$lang.promotion}
			</a>
		{/if}
	</div>




