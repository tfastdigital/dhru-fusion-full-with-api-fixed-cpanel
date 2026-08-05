
 {include file="templates/default/productlist.tpl"}

{if $newhomepagegroup}
	<div class=" index-items-homepagegroup  index-items mb-4 bottom-space">
		<div class="container"><div class="page-container"><div class="row">
			 {foreach from=$newhomepagegroup key=GroupName item=Group}

				 <div class="col-lg-3 {if $onlyimagemode eq 'true'}imagemode{/if} col-product">
					 <div class="card    h-100 text-center card-group card-product">


						 <a  class="h-100 w-100  d-flex flex-column" href="{$Group.link}">
							 <div class="position-relative card-product-img"  >
								 <div class="d-flex h-100 align-items-center" >
									 {if $Group.image}
										 <img class="card-img-top  mx-auto" src="{$Group.image}" alt="" />
									 {else}
										 <div class="w-100 p-3 text-center align-items-center rounded-top   image-not-found">
											 <span class="big-icon">   <i class="fas fa-image fa-4x"></i>  </span>
										 </div>
									 {/if}
								 </div>

							 </div>

							 <div class="card-info">
								 <div class="truncate-text mt-3"> {$Group.group} </div>
							 </div>

						 </a>

					 </div>
				 </div>

			 {/foreach}
		 </div></div></div>
	</div>
 {/if}



{if $dailydeals || $productitems || $items || $serveritems || $remoteitems}



			{if $cart}

				{if   $ishomepagegroup}
					<div id="homegroupitem">
						{literal}
							<script> getContect('#homegroup','widget/getHomepagegroup','#homegroupitem',true,'#loader');</script>
						{/literal}
					</div>
				{/if}


				{if $dailydeals and $resellerstore}
					<div class="index-items dailydeals mb-4 bottom-space">
						<div class="container">
							<div class="page-container">
								<h3 class="title">
									 <span>{$lang.dailydeals}</span>
								</h3>
								<div class="row">
									{foreach from=$dailydeals key=GroupName item=Services}
										{call name=productlist data=$Services service='product'}
									{/foreach}
								</div>
							</div>
						</div>
					</div>
				{/if}


				{if $productitems}
					<div class="index-items  mb-4 bottom-space popularitems"><div class="container"><div class="page-container">
						{foreach from=$productitems key=GroupName item=Services}
							{foreach from=$Services key=id item=name}
								{assign var='manufacture_name' value=$name.manufacture_name}
							{/foreach}
						{/foreach}
						<h3 class="title">
							<span>
								{if $manufacture_name}
									{$manufacture_name} {$lang.manufacture} {$lang.product}
								{else}
									 {$lang.popular} {$lang.product}
								{/if}
							</span>
						</h3>

						<div class="row">
							{foreach from=$productitems key=GroupName item=Services}
								{call name=productlist data=$Services service='product'}
							{/foreach}
						</div>
							</div></div></div>
				{/if}



			{/if}



	{if !$eCommerce}
		{if $items}
			<div class="index-items  mb-4 bottom-space imeiservices"><div class="container"><div class="page-container">
						<h3 class="title">
							<span>{$lang.imei} {$lang.services}</span>
						</h3>
						<div class="row">
							{foreach from=$items key=GroupName item=Services}
								{call name=productlist data=$Services service='imei'}
							{/foreach}
						</div>
					</div></div></div>
		{/if}

		{if $serveritems}
			<div class="index-items  mb-4 bottom-space serverservices"><div class="container"><div class="page-container">
						<h3 class="title">
							<span>{$lang.server} {$lang.services}</span>
						</h3>

						<div class="row">
							{foreach from=$serveritems key=GroupName item=Services}
								{call name=productlist data=$Services service='server'}
							{/foreach}
						</div>
					</div></div></div>
		{/if}

		{if $remoteitems}
			<div class="index-items  mb-4 bottom-space remoteservices"><div class="container"><div class="page-container">
						<h3 class="title">
							<span>{$lang.remote} {$lang.services}</span>
						</h3>

						<div class="row">
							{foreach from=$remoteitems key=GroupName item=Services}
								{call name=productlist data=$Services service='remote'}
							{/foreach}
						</div>
					</div></div></div>
		{/if}
	{/if}





{/if}
