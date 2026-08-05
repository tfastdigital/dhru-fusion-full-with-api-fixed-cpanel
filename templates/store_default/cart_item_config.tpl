{include file="templates/default/productlist.tpl"}

<script src="includes/js/rating.js" type="text/javascript"></script>
<link rel="stylesheet" href="includes/css/rating.css" type="text/css"/>

<div class="container"><div class="page-container">



	<div   class="alert alert-cart"></div>
	<div class="row">
        <div class="col-lg-12 mx-auto">

			<div>
				{if $service eq 'imei'}
					{if $forquickcheckout}

					<form method="post" name="imeiorder_form" id="imeiorder_form">
						{$token}
						<input type="hidden" name="servicetype" value="imei" />
						<input type="hidden" name="id" value="{$item}" />

						<h4>{$modeldtl.Brand} / {$modeldtl.Name} / {$services.retail_name} </h4>

						<div class="row">
							<div class="col-lg-12">
								<div id="imeiserviceDetails">
									{literal}
										 <script> getWidgetdetailsIMEI({/literal}'{$item}'{literal},'#imeiserviceDetails','#notification',true,'#loader',true,{/literal}{if $bids}{$bids}{else}0{/if}{literal},{/literal}{if $mids}{$mids}{else}0{/if}{literal},{/literal}{if $cids}{$cids}{else}0{/if}{literal},{/literal}{if $pids}{$pids}{else}0{/if}{literal},{/literal}{$forquickcheckout}{literal},{/literal}{if $min}1{else}0{/if}{literal}); </script>
									{/literal}
								</div>
							</div>
						 </div>
					</form>

					{$modeldtl.Brandimage}
					{$services.customhtml}

					{else}


						<form method="post" name="imeiorder_form{if $min eq 1}2{/if}" id="imeiorder_form{if $min eq 1}2{/if}">
							{$token}
							<input type="hidden" name="servicetype" value="imei" />
							<input type="hidden" name="id" value="{$item}" />
							<div id="imeiserviceDetails">
								{literal}
									 <script>getWidgetdetailsIMEI({/literal}'{$item}'{literal},'#imeiserviceDetails','#notification',true,'#loader',true,{/literal}{if $bids}{$bids}{else}0{/if}{literal},{/literal}{if $mids}{$mids}{else}0{/if}{literal},{/literal}{if $cids}{$cids}{else}0{/if}{literal},{/literal}{if $pids}{$pids}{else}0{/if}{literal},'',{/literal}{if $min}'1'{else}'0'{/if}{literal}); </script>
								{/literal}
							</div>
						</form>
					{/if}
				{/if}

			</div>


		{if $service eq 'product'}
        	<form method="post" name="serverorder_form" id="serverorder_form{$unique_id}">
        		<input type="hidden" name="servicetype" value="product" />
        		<input type="hidden" name="id" value="{$item}" />
        		{$token}
        		{assign var='default' value=$servicedtl.default_image}


				<div class="card card-product-detail mb-4 bottom-space">
                 	{include file="templates/default/productdetails.tpl"}

					<div class="">
						<div id="productdetails">
							{literal}
							<script type="text/javascript">  getContect('#tab1','{/literal}{$productinfolink}{literal}','#productdetails',true,'#loader',true); </script>
							{/literal}
						</div>
					</div>

				</div>
        	</form>





			{if $servicedtl.feature}
				<div id="product-features"  class="card-product-features card mb-4 bottom-space">
					{literal}
						<script type="text/javascript">
							getContect('#tab5','{/literal}{$featureslink}{literal}','#product-features',true,'#loader');
						</script>
					{/literal}
				</div>
			{/if}




			<div class="bg-white mb-4 bottom-space">
				<div id="loadbundle">
					{literal}
					<script>
						getContect('#loadbundle','{/literal}{$bundlelink}{literal}','#loadbundle',true,'#loader');
					</script>
					{/literal}
				</div>
			</div>



			<div class="related-products">

				{if $producthot}
					<h3 class="title"> <span>{$lang.related} {$lang.product} </span></h3>
				{/if}

				<div class="row">
					{foreach from=$producthot key=GroupName item=Services}
						{foreach from=$Services key=id name=limit item=name}
							{call name=productlist data=$name service='product'}
						{/foreach}
					{/foreach}
				</div>

			</div>

		{/if}


		{if $service eq 'server'}
			<form method="post" name="serverorder_form" id="serverorder_form">
				<input type="hidden" name="servicetype" value="server" />
				<input type="hidden" name="id" value="{$item}" />
				{$token}
				<h2 class=" h2">
					{$servicedtl.service_name}
				</h2>
				 <div id="serviceDetails2">
                     {literal}
                		<script>
                            getServicedetailsServer({/literal}'{$item}'{literal},'#serviceDetails2','.alert',true,'#loader',true);
                        </script>
            		{/literal}
                 </div>
				{if $servicedtl.image_link}
					<img src="{$servicedtl.image_link}"  />
				{/if}
			</form>
		  {if !$cart}
			{if $servicedtl.review eq 1}
    		     <div id="serverdetails">
                     {literal}
                		<script type="text/javascript">
                             getContect('#tab5','widget/getFeatures?serviceid={$item}&action=serverreview','#serverdetails',true,'#loader');
                        </script>
            		{/literal}
                </div>
			{/if}
		  {/if}
		{/if}
	</div>
		</div>

	</div></div>





