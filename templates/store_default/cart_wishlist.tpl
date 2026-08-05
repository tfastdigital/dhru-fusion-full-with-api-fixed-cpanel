 {include file="templates/default/productlist.tpl"}


 <div class="container"><div class="page-container">

	<div class="row">
		{foreach from=$productitems key=GroupName item=Services}
			{call name=productlist data=$Services service='product'}
			{foreachelse}
			<div class="text-center col-lg-12">
				{call name=noresultfound}
			</div>
		{/foreach}
	</div>
	 </div></div>
