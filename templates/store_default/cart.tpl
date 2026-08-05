 {include file="templates/default/productlist.tpl"}


<div class="container"><div class="page-container">



	{if $noticy}
	  {include file="templates/default/paymentnotice.tpl"}
	{/if}

	<div class="row">


		{if $group>0 && !$item && $service eq 'product'}
			{include file="templates/default/cart_rightmenu.tpl"}
		{/if}

		<div class="col-lg-{if $group>0 && !$item && $service eq 'product'}9{else}12{/if}">

			<div class="">
				<div class="row align-items-center">
					<div class="col-lg-6">
						<h2 class="page-title m-0 inner-page-title">
							  {if $groupname}{$groupname}{elseif $service}{$service}{else}Cart{/if}
						</h2>
					</div>


					<div class="col-lg-6">
						<div class="d-flex justify-content-end">
							{if $group && $service eq 'imei'}
								<div class="position-relative   ml-auto mr-3">
									<input type="text" name="modelsearch" style="" class="form-control " onkeyup="quickModel1(this)" autocomplete="off"  id="modelsearch"  placeholder="{$lang.search} {$lang.model}" />
									<ul id="modelslist" class="modellist-dp position-absolute p-0 border w-100" style="z-index:99;overflow: auto;height:250px;display:none;top:38px;"></ul>
									<input type="hidden" name="brand" id="brand" />
									<input type="hidden" name="model_id" id="model" />
								</div>
							{/if}
							{if $service neq 'imeigroups' && $service neq 'filegroups' && $service neq 'servergroups' && $service neq 'remotegroups' }
								<div class=" d-none   d-lg-block">
									<select class="form-control no-chosen" onchange="location.href='{$sortbylink}sortby/'+this.value">
										<option value="">{$lang.sort} {$lang.by}</option>
										<option value="">{$lang.position}</option>
										<option {if $sortby eq 'featured'} selected="selected" {/if} value="featured">{$lang.featured} {$lang.items}</option>
										<option {if $sortby eq 'namea'} selected="selected"  {/if} value="namea">{$lang.name} : {$lang.atoz}</option>
										<option {if $sortby eq 'namez'} selected="selected"  {/if} value="namez">{$lang.name} : {$lang.ztoa}</option>
										<option {if $sortby eq 'pricel'} selected="selected"  {/if} value="pricel">{$lang.price} : {$lang.lowtohigh}</option>
										<option {if $sortby eq 'priceh'} selected="selected"  {/if} value="priceh">{$lang.price} : {$lang.hightolow}</option>
									</select>
								</div>
							{/if}
						</div>
					</div>
				</div>


			<div>
				{if $filtervisible}
					<ul class="filter-by">
						<li>Filter by : </li>
						{foreach from=$filtervisible key=key item=filters}
							<li class="bg-light rounded-20 px-3 ">
								<span class="text-muted">{$key}</span>
								{foreach from=$filters key=keyi item=filteritems}
									{$filteritems}
								{/foreach}
							</li>
						{/foreach}
					</ul>
				{/if}
			</div>

			</div>

			{if $groupdescription}
				<div class="text-muted">
					{$groupdescription}
				</div>
			{/if}



			{if $group && $service eq 'imei' && !$eCommerce}

				<div class="row">
					{foreach from=$items key=GroupName item=Services}
						 {call name=productlist data=$Services service='imei'}
					{foreachelse}
						<div class="text-center text-muted card  w-100 mx-3">
							{call name=noresultfound}
						</div>
					{/foreach}
				</div>

			{elseif $group && $service eq 'server'  && !$eCommerce}


				<div class="row">
					{foreach from=$items key=GroupName item=Services}
						 {call name=productlist data=$Services service='server'}
					{foreachelse}
						<div class="text-center text-muted card  w-100 mx-3">
							{call name=noresultfound}
						</div>
					{/foreach}
				</div>

			{elseif $group && $service eq 'product'}

				<div class="row">
					{foreach from=$items key=GroupName item=Services}
						{call name=productlist data=$Services service='product'}
					{foreachelse}
						<div class="text-center text-muted card  w-100 mx-3">
							{call name=noresultfound}
						</div>
					{/foreach}
				</div>

			{elseif $service eq 'imeigroups'}

				<div id="imei-groups">
					{literal}
						<script type="text/javascript">
							getContect('#tab5','{/literal}{$imeiservicegrouplink}{literal}','#imei-groups',true,'#loader',true);
						</script>
					{/literal}
				</div>

			{elseif $service eq 'servergroups'}

				<div id="server-groups">
					{literal}
						<script type="text/javascript">
							getContect('#tab5','{/literal}{$serverservicegrouplink}{literal}','#server-groups',true,'#loader',true);
						</script>
					{/literal}
				</div>


			{elseif $service eq 'remotegroups'}

				<div id="remote-groups">
					{literal}
						<script type="text/javascript">
							getContect('#tab5','{/literal}{$remoteservicegrouplink}{literal}','#remote-groups',true,'#loader',true);
						</script>
					{/literal}
				</div>

			{elseif $service eq 'filegroups'}

				<div id="file-groups">
					{literal}
						<script type="text/javascript">
							getContect('#tab5','{/literal}{$fileservicegrouplink}{literal}','#file-groups',true,'#loader',true);
						</script>
					{/literal}
				</div>

			{elseif $groupdetail}

				<div class="row">
					{foreach from=$groupdetail key=id item=name}
						{call name=grouplist data=$name service='product'}
					{/foreach}
				  </div>

			{else}

				<div>

					{if $defimei eq 1 && $imeicatlog  && !$eCommerce}

						<h4 class="p-3">
							IMEI Services
						</h4>

						<div class="row">
							{foreach from=$imeicatlog key=id item=name}
								{call name=grouplist data=$name service='imei'}
							{/foreach}
						</div>
					{/if}

					{if $defserver eq 1 && $servercatlog  && !$eCommerce}
						<h4 class="p-3">
							Server Services
						</h4>

						<div class="row">
							{foreach from=$servercatlog key=id item=name}
								{call name=grouplist data=$name service='server'}
							{/foreach}
						</div>
					{/if}




					{if $products}
						<h4 class="p-3">
							Shop Services
						</h4>
						<div class="row">
							{foreach from=$products key=id item=name}
								{call name=grouplist data=$name service='product'}
							{/foreach}
						</div>
					{/if}

				</div>
			{/if}


			{if $loademi}
				<div class="row">
					{foreach from=$items1 key=GroupName item=Services}
						 {call name=productlist data=$Services service='product'}
					{foreachelse}
						<div class="text-center card">
							{call name=noresultfound}
						</div>
					{/foreach}
				</div>
		   {/if}


		</div>
	</div>


	<div class="modal hide sortby-modal" tabindex="-1" id="sortby" role="dialog">
		<div class="modal-dialog h-100" role="document" style="margin: 500px 0 0 0 ">
			<div class="modal-content h-100 rounded-0">
				<div class="modal-header p-3 border-bottom">
					<h5 class="m-0">  Sort By </h5>
				</div>
				<div class="modal-body overflow-auto p-1">
					<ul class="sort-by">
						<li>
							<a {if $sortby eq 'featured'} class="selected" {/if}  href="{$sortbylink}?sortby=featured">{$lang.featured} {$lang.items}</a>
						</li>
						<li>
							<a  {if $sortby eq 'namea'} class="selected" {/if} href="{$sortbylink}?sortby=namea">{$lang.atoz}</a>
						</li>
						<li>
							<a {if $sortby eq 'namez'} class="selected" {/if}  href="{$sortbylink}?sortby=namez"> {$lang.ztoa}</a>
						</li>
						<li>
							<a {if $sortby eq 'pricel'} class="selected" {/if}  href="{$sortbylink}?sortby=pricel">{$lang.lowtohigh}</a>
						</li>
						<li>
							<a {if $sortby eq 'priceh'} class="selected" {/if}  href="{$sortbylink}?sortby=priceh">{$lang.hightolow}</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>



	<div class="d-actionbar-mobile">
		<div class="d-block d-lg-none w-100 bg-white">
			<div class="row">
				<div class="col-6 text-center p-2 border-right" data-toggle="modal" data-target="#sortby">
					<i class="fal fa-sort"></i> Sort
				</div>

				{if $resellerstore}
					{if $group>0 && !$item && $service eq 'product'}
						<div class="col-6 text-center p-2" data-toggle="modal" data-target="#navbarsidebar">
							<i class="fal fa-filter"></i> Filter
						</div>
					{/if}
				{/if}
			</div>
		</div>
	</div>

	</div></div>
