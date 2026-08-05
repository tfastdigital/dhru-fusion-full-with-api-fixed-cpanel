
<div    class="alert alert-cart alert-quick">
	</div>
	<form method="post" name="serverorder_form{$unique_id}" id="serverorder_form{$unique_id}" >
		<input type="hidden" name="servicetype" value="product" />
		<input type="hidden" name="id" value="{$mitem}" />
		{$token}

          {include file="templates/default/productdetails.tpl"}

	</form>
