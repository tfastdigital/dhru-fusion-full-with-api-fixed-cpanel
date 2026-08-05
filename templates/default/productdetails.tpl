

{function name=cartaction}

	<div class="w-100 form-group mb-0">

		<div class="form-label text-muted font-normal">
			{$lang.qnt}
		</div>

		<div class="d-flex align-items-center">



			<div class="form-group  mb-0 mr-2" style="min-width:70px !important">
				<select name="quantity" class="quantity-box form-control no-chosen  mr-2  " onchange="$('.quantity-box').val(this.value)">
					{if $servicedtl.minqnt gt 0 && $servicedtl.maxqnt gt 0}
						{section name=foo start=$servicedtl.minqnt loop=$servicedtl.maxqnt+1 step=1}
							<option value="{$smarty.section.foo.index}">{$smarty.section.foo.index}</option>
						{/section}
					{else}
						{section name=foo start=1 loop=1000 step=1}
							<option value="{$smarty.section.foo.index}">{$smarty.section.foo.index}</option>
						{/section}
					{/if}
				</select>
			</div>



			<button type="button" class="btn    mr-1    btn-primary" id="placeorder" onclick="SubmitForm('#placeorder','{$addtocartlink}','#serverorder_form{$unique_id}','.alert-cart','true','#loader');" value="{$lang.addtocart}" >
				{$lang.addtocart}
			</button>

		</div>

	</div>
{/function}

<div class="row">
	<div class="col-lg-12">
		<h3 class="mb-4  bottom-space">
			{$servicedtl.service_name} {if $servicedtl.productcondition} <span class="text-muted"> [{$servicedtl.productcondition}] </span> {/if}
		</h3>
	</div>
</div>

<div class="row">



	<div class="col-lg-4">
		<div class=" cart-gallery  ">
			<table class="h-100">
				<tr>
					<td style="vertical-align: middle" class="">
						<div id="carousel3" class="carousel p-3 rounded  slide-products" data-ride="carousel">

							<div class="carousel-inner   text-center mx-auto">
								{foreach from=$servicedtl.image_link key=GroupName item=image}
									{if $image.0}
										<div class="carousel-item   {if $image@first}active{/if}">
											<div>
												<img src="{$image.0}" style="max-height: 500px"/>
											</div>
										</div>
									{/if}
									{foreachelse}
									<div class="image-not-found"><span class="big-icon"> <i class="fa fa-shopping-cart"></i></span></div>
								{/foreach}
							</div>

							{if $servicedtl.image_link[2][0] neq ''}
								<a class="carousel-control-prev" href="#carousel3" data-slide="prev">
									<span class="carousel-control-prev-icon"></span>
								</a>
								<a class="carousel-control-next" href="#carousel3" data-slide="next">
									<span class="carousel-control-next-icon"></span>
								</a>
							{/if}

						</div>
					</td>

					{if $servicedtl.image_link[2][0] neq ''}
						<td  style="vertical-align: top;width:80px;text-align: center"  class="d-none-modal">
							<div class="pl-3">
								<ul class="carousel-indicators  carousel-indicator-img">
									{foreach from=$servicedtl.image_link key=id item=image}
										{if $image.0}
											<li data-target="#carousel3" data-slide-to="{$id-1}" class="{if $image@first}active{/if}">
												<img src="{$image.0}" style="max-height: 100px"/>
											</li>
										{/if}
									{/foreach}
								</ul>
							</div>
						</td>
					{/if}

				</tr>
			</table>
		</div>
	</div>


	<div class="col-lg-8" >

		<div class="cart-item-detail">

			{if $servicedtl.stock_allow}
				<div class="mb-2">
					<label class="badge badge-warning">
						{if $servicedtl.promotion_stock gte 1}
							({$lang.limitedstock})
						{/if}
						{if $servicedtl.availability_date gt $dates}
							{$servicedtl.availability_date}
						{elseif $servicedtl.stock lt 1}
							{$lang.outofstock}
						{else}
							{$lang.instock}
						{/if}
					</label>
				</div>
			{/if}

			{if $servicedtl.cartdiscount && $servicedtl.cartdiscount gt 0}
				<h2>
						<span class="{if $servicedtl.cartdiscount}discount{/if}">
							<span class="prefix">{$currency.prefix}</span> {$servicedtl.credit}<span class="suffix">{$currency.suffix}</span>
						</span>
				</h2>
			{/if}


			{if $servicedtl.time neq ''}
				<div>
					<div class="text-muted"> {$lang.deliverytime}   </div>  <div> {$servicedtl.time} </div>
				</div>
			{/if}

			{if $servicedtl.sku}
				<meta name="SKU"  content="{$servicedtl.sku}"/>
				<label class="badge badge-light">
					#{$servicedtl.sku}
				</label>
			{/if}
			{if $servicedtl.ean}
				<meta name="EAN"  content="{$servicedtl.ean}"/>
			{/if}


			<div class="my-3">
				{if $servicedtl.weight}
					<div>
						<div class="text-muted"> {$lang.weight} </div> <div>  {$servicedtl.weight} {$lang.kg} </div>
					</div>
				{/if}
				{if $servicedtl.height}
					<div>
						<div class="text-muted">{$lang.height}</div> <div> {$servicedtl.height} </div>
					</div>
				{/if}
				{if $servicedtl.width}
					<div>
						<div class="text-muted">{$lang.width}</div> <div> {$servicedtl.width} </div>
					</div>
				{/if}
				{if $servicedtl.depth}
					<div>
						<div class="text-muted">{$lang.depth} </div><div> {$servicedtl.depth} </div>
					</div>
				{/if}
			</div>


			{if $servicedtl.credit gte 0}
				{if $servicedtl.cartdiscount}
				{else}
					{if $wholesaleprice}
						<table class="table table-borderd table-striped">
							<thead>
							<tr>
								<th>
									{$lang.qnt}
								</th>
								<th>
									{$lang.wholesaleprice}
								</th>
							</tr>
							</thead>
							{foreach from=$wholesaleprice item=dtl}
								<tr>
									<td>
										{$dtl.qnt}
									</td>
									<td>
										<span class="prefix">{$currency.prefix}</span> {$dtl.price}<span class="suffix">{$currency.suffix}</span>
									</td>
								</tr>
							{/foreach}
						</table>
					{/if}
				{/if}
				{if $servicedtl.warehousecountry}
					<label>
						{$lang.shipping} {$lang.from} {$servicedtl.warehousecountry}
					</label>
				{/if}
				{if $servicedtl.freeship eq 1}
					{if $servicedtl.virtual eq 1}
						<label  class="label">
							{$lang.virtualproduct}
						</label>
					{/if}
				{else}
					{if $shippingcost eq '1'}
						<a  id="sh" href='javascript: return void(0);'  onclick="javascript:window.open( '{$shippingcost}', 'myWindow','status = 1, height = 600, width = 500, resizable = 1,scrollbars=1' )" >
							{$lang.calculate} {$lang.shipping} {$lang.cost}
						</a>
					{/if}
				{/if}
			{/if}
			{if $accessories}


				<div>
					<span class="text-muted">	{$lang.extra} {$lang.accessories}</span>
				</div>

				<table>
					{foreach from=$accessories key=rid item=rel}
						{foreach from=$rel key=kid item=services}
							<tr>
								<td>

									<div class="custom-control custom-checkbox">
										<input type="checkbox" name="adds" onclick="addtocart('{$kid}');" value="{$lang.addtocart}" class="custom-control-input" id="{$kid}">
										<label class="custom-control-label" for="{$kid}">{$services.service_name}</label>
										<span class="prefix">
											 {$currency.prefix}
										 </span>
										{$services.credit-$services.discount}
										<span class="suffix">{$currency.suffix}</span>
										<a  class="text-primary"  href="{$services.seourl}" >
											&nbsp;&nbsp;&nbsp;	{$lang.view} {$lang.details}
										</a>
									</div>


								</td>
							</tr>
						{/foreach}
					{/foreach}
				</table>
			{/if}
			{if $servicedtl.supplier_name}
				<table class="table table-borderd">
					<tr>
						<td>
							<div class="text-muted"> {$lang.seller} {$lang.name} </div> <div> {$servicedtl.supplier_name} </div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="text-muted"> + {$lang.positive} {$lang.feedback} </div> <div> {$servicedtl.supplier_success} ({$servicedtl.supplier_tot}) - <span>{$servicedtl.supplier_per}%</span> </div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="text-muted"> - {$lang.negative} {$lang.feedback} </div> <div> {$servicedtl.supplier_reject} ({$servicedtl.supplier_tot}) </div>
						</td>
					</tr>
				</table>
			{/if}
			{if $servicedtl.download_link || $servicedtl.faq_id}

				{if $servicedtl.download_link}
					<a href="{$servicedtl.download_link}" target="_blank">
						<i class="icon-download-alt"></i>
						<div class="text-muted">{$lang.software} {$lang.download}</div>
					</a>
				{/if}

			{/if}



			{assign var="blg" value=$servicedtl.id}




			{if $customfields}
				<div class="col-lg-4 p-0 mt-3">
					{foreach from=$customfields key=name item=fields}
						{if $fields.type eq 'radio'}
							<div class="form-group ">
								<label class="form-label">
									{$name}
								</label>
								<div class="controls">
									{$fields.input}
								</div>
								<span class="text-muted">{$fields.description}</span>
							</div>
						{else}
							<div class="form-group">
								<label  class="form-label">
									{$name}
								</label>
								<div class="controls">
									{$fields.input}
									<span  class="text-muted">{$fields.description}</span>
								</div>
							</div>
						{/if}
					{/foreach}
				</div>
			{/if}



			<div  class="d-none-modal">
				{if $servicedtl.short_info} <small class="font-normal"> {$servicedtl.short_info}  </small> {/if}
				<div>
					<small class="font-normal">
						{$servicedtl.customhtml}
					</small>
				</div>


				<div class="">
					<div class="form-inline mt-sm-3 mt-2">
						{if ($servicedtl.stock_allow eq 1 && $servicedtl.stock lt 1 && $servicedtl.outofstock eq 2) || ($servicedtl.availability_date gt $dates && $servicedtl.outofstock eq 2)}
							<div class="form-group  mr-2 mb-2">
								<label>{$lang.name}</label>
								<input type="text" class="form-control " name="name" />
							</div>
							<div class="form-group  mr-2 mb-2">
								<label>{$lang.email}</label>
								<input type="text" class="form-control " name="email" />
							</div>
							<input type="button" class="btn  mr-2 mb-2" id="placeorder" onclick="SubmitForm('#placeorder','{$cartsignuplink}','#serverorder_form{$unique_id}','.alert','true','#loader');" value="{$lang.signupnotification}" />
						{else}
							{if $servicedtl.credit lte 0 && $servicedtl.zeropriceaction eq 2}

							{else}
								{if $servicedtl.callfrpricing eq 1}
									<button type="button" name="callforpricing" class="btn  mr-2 mb-2 btn-primary"  onclick="javascript: location.href='{$contactitemlink}';" value="{$lang.callforpricing}" >
										{$lang.callforpricing}
									</button>
								{/if}
							{/if}
						{/if}

					</div>
				</div>

			</div>

			<div class="my-3">
				<div class="text-muted">
					{$lang.price}
				</div>
				<h2>
					{if $servicedtl.credit eq 0 && $servicedtl.zeropriceaction eq 3}

						<span class="prefix">{$currency.prefix}</span>
						<input type="text" class="form-control " name="price"   />
						<span class="suffix">{$currency.suffix}</span>

					{else}
						<span class="prefix">{$currency.prefix}</span>

						<span id="actualprice" style="display:none;">
								{$servicedtl.credit-$servicedtl.cartdiscount}
							</span>
						<span id="ourfinalprice">
								{$servicedtl.credit-$servicedtl.cartdiscount}
							</span>

						<span class="suffix">{$currency.suffix}</span>

					{/if}
				</h2>
			</div>

			<div class="d-actionbar-mobile">
				{call name=cartaction}
			</div>


			<div  class="d-none-modal">
				<div class="d-row">
					{*<a  class="text-underline"   href='{$suggestedpricelink}' data-size="modal-md" data-whatever="{$lang.suggested} {$lang.price} - {$servicedtl.service_name}"  data-toggle="modal" data-target="#modal-ajax">
                        {$lang.suggested} {$lang.price}
                    </a>*}
					{if $servicedtl.review eq 1}
						<a  class="text-underline"  data-toggle="modal" data-size="modal-md" data-target="#modal-ajax" data-whatever="Your {$lang.review} - {$servicedtl.service_name}" href="{$getfeaturelinks}">
							{$lang.customer} {$lang.review}
						</a>
					{/if}


					{if $servicedtl.images}
						<a   class="text-underline"   data-toggle="modal" data-target="#modal-ajax" data-whatever="{$lang.extra} {$lang.images}" href="{$featurelinkimages}">
							{$lang.extra} {$lang.images}
						</a>
					{/if}
					{if $servicedtl.videos}
						<a  data-toggle="modal" data-target="#modal-ajax" data-whatever="{$lang.relatedvideos}" href="{$featurelinkvideos}','#productdetails',true,'#loader');">
							{$lang.relatedvideos}
						</a>
					{/if}


					{if $servicedtl.faq_id}
						<a  class="text-underline"   href="{$faqlink}?standalone=true" data-target="#modal-ajax" data-toggle="modal" data-size="modal-lg" data-whatever="Knowledgebase Article">
							{$lang.knowledgebase} {$lang.artical}
						</a>
					{/if}

				</div>
			</div>

		</div>

	</div>


</div>

