
{if $cart}
	<h4 class="p-3 service-title">  {$fileservice.service_name}</h4>
{/if}


<div class="position-fixed bg-white p-5 active  w-100 text-center align-items-center" id="custom-alert" style="z-index: 99;top: 70px;left: 0px;bottom: 0;display: none">

	<div class="sa-icon   animate">
		<span class="sa-line sa-tip animateSuccessTip"></span>
		<span class="sa-line sa-long animateSuccessLong"></span>
		<div class="sa-placeholder"></div>
		<div class="sa-fix"></div>
	</div>



	<div class="alert col-lg-5 mx-auto alert-success d-block" id="custom-alert-msg"></div>
	{$lang.continuetoplace}? <a class="btn" onclick="$('#custom-alert').hide()"> {$lang.clickhere} </a>

	<div class="position-relative col-lg-6 mt-5 mx-auto">
		<small class="position-absolute" style="margin-top: -15px;background: white;padding: 0 6px;margin-left: -10px;color:#999"> {$lang.or} </small>
		<hr/>
	</div>

	<a class="text-muted btn d-block p-4" href="{$fileorderhistorylink}">{$lang.view} {$lang.file} {$lang.order} {$lang.history} </a>


</div>



<div class="row h-100">
<div class="col-lg-6 d-flex flex-column h-100  border-right">

	<div class="p-3">

	<div   class="alert addedtocart"></div>

	<div class="h-100 flex-column">

		<div class="form-group ">
			<label>
				{$lang.file}
			</label>
			<div>
				<input type="file" name="ask" />
			</div>
		</div>
		{if $fileservice.bulk_reply}
		<div class="form-group ">
			<label>
				{$lang.multiplefile}
			</label>
			<div>
				<input type="file" name="bulk" />

				<div class="text-muted">{$lang.zipallfile} </div>
			</div>
		</div>
		{/if}


		{if $ordernotes}
		<div class="form-group ">
			<label>
				{$lang.notes}:
			</label>
			<div>
				<input type="text" class="form-control " name="notes" />

				<div class="text-muted">{$lang.additionalnote}</div>
			</div>
		</div>

		{/if}
		{if $ordercomments}
		<div class="form-group ">
			<label>
				{$lang.comments}:
			</label>
			<div>
				<textarea class="form-control "  name="comments" cols="30" rows="2" ></textarea>

				<div class="text-muted">{$lang.remember}</div>
			</div>
		</div>

		{/if}
		{if $orderemail}
			<div class="form-group ">
				<label>
					{$lang.responsemail}:
				</label>
				<div>
					<input type="text" class="form-control " name="response"  />

					<div class="text-muted">{$lang.responseinfo}</div>
				</div>
			</div>
		{/if}

		{if $pin eq 1}
			<div class="form-group ">
				<label>
					{$lang.masterpin}:
				</label>
				<div>
					<input class="form-control "  type="password" name="pin" id="pin" maxlength="4" />
				</div>
			</div>
		{/if}

		{if $smsgateway	&& $userdetails.ordersms eq 1}

			{if $orderno}
				<div class="form-group ">
					<label>
						{$lang.responseno}:
					</label>
					{if $responseno}
						<label>
							<input type="radio" checked="" name="no" value="1" />
							{$responseno}
						</label>
						<label>
							<input type="radio" name="no" value="2"  />
						</label>
						<input type="text" class="form-control " name="otherno" />
						<div class="text-muted">{$lang.mobilenumber}</div>
					{else}
						<input type="text" class="form-control " name="otherno" />
						<div class="text-muted">{$lang.mobilenumber}</div>
					{/if}

				</div>
			{/if}

		{/if}

		{if $infopos neq 2}
		  <div id="information"> </div>
		{/if}

	</div>

	<div class="d-actionbar-mobile">
		<button type="button" class="btn btn-primary w-100"   id="placeorder" onclick="SubmitFormFile('#placeorder','{$placeorderlink}','#fileorder_form2','.alert','true','#loader');" value="{$lang.placeorder}" >
			{$lang.placeorder}
		</button>
	</div>

	</div>

</div>

	<div class="col-lg-6   h-100">
		<div class="p-3">
			<div class="flex-column w-100">
				<div class="form-group ">
					<div class="border-bottom pb-2">


							 <div class="d-flex justify-content-between">
									<div>

										<div id="mult" style="display:none">
											<h4 style="">	{if !$loggedin} <span class="prefix">{$currency.prefix}</span>  {else} {$userdetails.currency.prefix} 	{/if}<span id="ocredit">{$fileservice.credit-$fileservice.discount}</span>{if !$loggedin}<span class="suffix">{$currency.suffix}</span>  {else} {$userdetails.currency.suffix}{/if}</h4>
										</div>
										<div  class="d-flex align-items-center text-green  fw-100" style="font-size: 35px">
										   <span>{if !$loggedin} <span class="prefix">{$currency.prefix}</span>  {else} {$userdetails.currency.prefix} 	{/if}</span>
											<div id="ctotal" class="total-400">{$fileservice.credit-$fileservice.discount}</div>
										   <span>	{if !$loggedin}<span class="suffix">{$currency.suffix}</span>  {else} {$userdetails.currency.suffix} {/if}</span>
										</div>
									   <span class="text-muted  font-normal ">
										   {if $fileservice.time}
												{$fileservice.time} {$lang.deliverytime}
											{/if}

											{if $averagetime}
												{if $averagetime.d gt 0}
													{$averagetime.d} {$lang.days}
												{/if}
												{if $averagetime.h gt 0}
													{$averagetime.h} {$lang.hours}
												{/if}
												{if $averagetime.m gt 0}
													{$averagetime.m} {$lang.minutes}
												{/if}
												{$lang.average} {$lang.deliverytime}
											{/if}
									   </span>

								 </div>

								 </div>


					</div>
				</div>

			{if !$cart}
				<div class="form-group ">
					{if $fileservice.type eq 'Database'} <span class="badge badge-info"> {$lang.datebase} </span> {/if}
					{if $fileservice.type eq 'Calculator'} <span class="badge badge-info"> {$lang.calculator}  </span> {/if}
					{if $fileservice.type eq 'Other'} <span class="badge badge-info"> {$lang.other}  </span> {/if}
					{if $fileservice.verifiable} <span class="badge badge-info"> {$lang.verifiable} </span> {/if}
					{if $fileservice.usercan_cancel} <span class="badge badge-info"> {$lang.cancancel}   </span> {/if}
				</div>
			{/if}


			<div   class="p-0 alert2 bg-gray position-relative service-information"></div>

		  </div>

			<div class="knowleg">
				{if $fileservice.faq_id}
				<script>
					getContect('','{$knowledgebase}','.knowleg',false,'#loader',true);
				</script>
				{/if}
			</div>
		</div>
    </div>



