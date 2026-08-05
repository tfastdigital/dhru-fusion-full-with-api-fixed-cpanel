<script type="text/javascript" src="includes/js/imei.js"></script>


<div class="row">

	{if $min}
		<div class="col-lg-12">
			<div class="">

				{if $cart}
					<div class="form-group ">
						<div class="">
							<h5>
								{if $currency.prefix}
									<span class="prefix">{$currency.prefix}</span>
								{else}
									{$userdetails.currency.prefix}
								{/if}
								<span id="ctotal">
												{$imeiservice.credit-$imeiservice.discount}
											</span>
								{if $currency.suffix}
									<span class="suffix">{$currency.suffix}</span>
								{else}
									{$userdetails.currency.suffix}
								{/if}
							</h5>


							{if  $imeiservice.time} <span class="text-muted font-normal"> {$imeiservice.time} {$lang.deliverytime} </span> {/if}
						</div>
					</div>

				{/if}

			</div>
		</div>
	{/if}

	<div class="{if $min} col-lg-12 {else} col-lg-6 {/if}  mb-2">

		<div   class="alert addedtocart mt-2"> </div>

		<div class=" border mt-2 mb-2 rounded {if $min} d-none {/if}">



			{if $modeldtl.image_link}
				<img src="{$modeldtl.image_link}" />
			{/if}
			{if $serviceimg}
				<img src="{$serviceimg}"  />
			{else}
				<div class="image-not-found text-center"><span class="big-icon"> <i class="fal fa-cog"></i></span></div>
			{/if}


		</div>


		{if $cart}


			{if $direct eq true}
				{if $imeiservice.reqredfield.imei_custom}
					<div class="form-group ">
						<label>
							{$imeiservice.reqredfield.imei_custom_name}:
						</label>
						<div>
							<textarea name="imei_custom" class="form-control " id="imei_custom" rows="6" cols="50" ></textarea>
							<div class="text-muted">{$imeiservice.reqredfield.imei_custom_info}</div>
						</div>
					</div>
				{else}
					{if $imeiservice.reqredfield.imei_single ||  !$imeiservice.reqredfield.imei_bulk}
						<div class="form-group ">
							<label>
								{$lang.imei}
							</label>
							<div class="d-flex">
								<input name="imei1" type="text" class="imei1 col form-control " id="imei1" onblur="remove_imei2()" onkeyup="luhnCheck()" maxlength="14"  />
								<input name="imei2" type="text" id="imei2" class="col-auto form-control " size="1" style="width:50px" readonly="true" class="imei2" />
								{if $imeiservice.reqredfield.imei_bulk}
									<input type="button" name="IMEI_ADD" id="IMEI_ADD" value="{$lang.addimei}" onclick="add_imei()" class="btn btn-secondary"/>
								{/if}
							</div>
							<div class="text-muted">{$lang.imeiinformation}</div>
						</div>
					{/if}
					{if $imeiservice.reqredfield.imei_bulk}
						<div class="form-group ">
							<label>
								{$lang.imeibulk}
							</label>
							<textarea name="imei_bulk" class="form-control " id="imei_bulk" rows="6" cols="50" ></textarea>
							<div class="text-muted">{$lang.imeibulkinformation}</div>
						</div>
					{/if}
				{/if}

			{else}

				{if $imeiservice.reqredfield.imei_custom}
					<div class="form-group ">
						<label>
							{$imeiservice.reqredfield.imei_custom_name}
						</label>
						<div>
							<input type="text" name="imei_custom" id="imei_custom"  class="form-control "  />
							<div class="text-muted">{$imeiservice.reqredfield.imei_custom_info}</div>
						</div>
					</div>
				{else}
					<div class="form-group ">
						<label>
							{$lang.imei}
						</label>
						<div class="d-flex">
							<input  class="form-control  col" name="imei1" type="text" id="imei1" onblur="remove_imei2()" onkeyup="luhnCheck()" maxlength="14" />
							<input name="imei2" type="text" id="imei2"  class="form-control  col-auto ml-2" style="width:50px"  readonly="true" class="imei2" />
						</div>
						<div class="text-muted">{$lang.imeiinformation}</div>
					</div>
				{/if}

			{/if}


		{else}
			{if $imeiservice.reqredfield.imei_custom}
				<div class="form-group ">
					<label>
						{$imeiservice.reqredfield.imei_custom_name}
					</label>
					<div>
						<textarea name="imei_custom"  class="form-control " id="imei_custom" rows="6" cols="50" ></textarea>
						<div class="text-muted">{$imeiservice.reqredfield.imei_custom_info}</div>
					</div>
				</div>
			{else}
				{if $imeiservice.reqredfield.imei_single ||  !$imeiservice.reqredfield.imei_bulk}
					<div class="form-group ">
						<label>
							{$lang.imei}
						</label>
						<div class="d-flex">
							<input   class="form-control  col" name="imei1" type="text" id="imei1" onblur="remove_imei2()" onkeyup="luhnCheck()" maxlength="14" />
							<input name="imei2" type="text" id="imei2"  class="form-control  col-auto" style="width:50px"   readonly="true" class="imei2" />
							{if $imeiservice.reqredfield.imei_bulk}
								<input type="button" name="IMEI_ADD" id="IMEI_ADD" value="{$lang.addimei}" onclick="add_imei()" class="btn btn-secondary"/>
							{/if}
						</div>
						<div class="text-muted">{$lang.imeiinformation}</div>
					</div>
				{/if}
				{if $imeiservice.reqredfield.imei_bulk}
					<div class="form-group ">
						<label>
							{$lang.imeibulk}
						</label>
						<div>
							<textarea name="imei_bulk"  class="form-control " id="imei_bulk" rows="6" cols="50" ></textarea>
							<div class="text-muted">{$lang.imeibulkinformation}</div>
						</div>
					</div>
				{/if}
			{/if}
		{/if}

		<div style="display:none">
			{if $imeiservice.reqredfield.model}
				<div class="row">
					<div class="col-lg-9">
						<div class="form-group ">
							<label>
								{$lang.brand}
							</label>
							<div>
								{$brands}
								<div class="text-muted">{$lang.brandinformation}</div>
							</div>
						</div>
						<div id="modelsTr" style="display:none;" class="specialP form-group ">
							<label>
								{$lang.model}
							</label>
							<div>
								<div id="modelsdropdown"> </div>
								<div class="text-muted">{$lang.modelinformation}</div>
							</div>
						</div>
					</div>
					<span class="col-lg-3" id="modelsimage"></span>
				</div>
			{/if}
		</div>

		{if $imeiservice.reqredfield.provider}
			<div class="form-group ">
				<label>
					{$lang.country}
				</label>
				<div>
					{$provider_countrys}
					<div class="text-muted">{$lang.countryinformation}</div>
				</div>
			</div>
			<div id="providerTr" style="display:none;" class="specialP form-group ">
				<label>
					{$lang.provider}
				</label>
				<div>
					<div id="providerdropdown">
					</div>
					<div class="text-muted">{$lang.providerinformation}</div>
				</div>
			</div>
		{/if}


		{if $imeiservice.reqredfield.mep}
			<div class="form-group ">
				<label>
					{$lang.mep}
				</label>
				<div>
					{$meps}
					<div class="text-muted">{$lang.mepinformation}</div>
				</div>
			</div>
		{/if}

		{if $imeiservice.reqredfield.PIN}
			<div class="form-group ">
				<label>
					{$lang.pin}
				</label>
				<div>
					<input name="PIN" class="form-control " type="text" maxlength="20" />
					<div class="text-muted">{$lang.pininformation}</div>
				</div>
			</div>
		{/if}

		{if $imeiservice.reqredfield.KBH}
			<div class="form-group ">
				<label>
					{$lang.kbh}
				</label>
				<div>
					<input name="KBH" class="form-control " type="text" maxlength="20" />
					<div class="text-muted">{$lang.kbhinformation}</div>
				</div>
			</div>
		{/if}

		{if $imeiservice.reqredfield.PRD}
			<div class="form-group ">
				<label>
					{$lang.prd}
				</label>
				<div>
					<input name="PRD" class="form-control " type="text" maxlength="20" />
					<div class="text-muted">{$lang.prdinformation}</div>
				</div>
			</div>
		{/if}

		{if $imeiservice.reqredfield.SN}
			<div class="form-group ">
				<label>
					SN
				</label>
				<div>
					<input name="SN" class="form-control " type="text" maxlength="20" />
				</div>
			</div>
		{/if}


		{if $imeiservice.reqredfield.SecRO}
			<div class="form-group ">
				<label>
					SecRO
				</label>
				<div>
					<input name="SecRO" type="text" maxlength="20" class="form-control " />
					<div class="text-muted">To get SRO, power on phone and type *#837# or *#3228# then search name that starts with	"X"	letter in the list. Example: XG55NBG3</div>
				</div>
			</div>
		{/if}


		{if $imeiservice.reqredfield.type}
			<div class="form-group ">
				<label>
					{$lang.type}:
				</label>
				<div>
					<input name="Type" class="form-control " type="text" maxlength="20" />
					<div class="text-muted">{$lang.typeinformation}</div>
				</div>
			</div>
		{/if}


		{if $imeiservice.reqredfield.reference}
			<div class="form-group ">
				<label>
					{$lang.reference}
				</label>
				<div>
					<input name="Reference" class="form-control " type="text" maxlength="20" value="25XXXXXXX" />
					<div class="text-muted">{$lang.referenceinformation}</div>
				</div>
			</div>
		{/if}


		{if $imeiservice.reqredfield.locks}
			<div class="form-group ">
				<label>
					{$lang.locks}:
				</label>
				<div>
					<div class="form-group ">
						<input type="checkbox" name="Locks[]" value="NCK" id="Lock0" />
						<label for="Lock0">
							{$lang.lock1} <b>NCK</b>
						</label>
					</div>
					<div class="form-group ">
						<input type="checkbox" name="Locks[]" value="NSCK" id="Lock1" />
						<label for="Lock1">
							{$lang.lock2} <b>NSCK</b>
						</label>
					</div>
					<div class="form-group ">
						<input type="checkbox" name="Locks[]" value="SPK" id="Lock2" />
						<label for="Lock2">
							{$lang.lock3} <b>SPK</b>
						</label>
					</div>
					<div class="form-group ">
						<input type="checkbox" name="Locks[]" value="CCK" id="Lock3" />
						<label for="Lock3">
							{$lang.lock4} <b>CCK</b>
						</label>
					</div>
					<div class="form-group ">
						<input type="checkbox" name="Locks[]" value="ESL" id="Lock4" />
						<label for="Lock4">
							{$lang.lock5} <b>ESL</b>
						</label>
						<div class="text-muted">{$lang.locksinformation}</div>
					</div>
				</div>
			</div>
		{/if}


		{if $customfields}
			{foreach from=$customfields key=name item=fields}
				<div class="form-group ">
					<label>
						{$name}
					</label>
					<div>
						{$fields.input}
						<div class="text-muted">{$fields.description}</div>
					</div>
				</div>
			{/foreach}
		{/if}


		<div class="form-group ">
			<div class="d-flex justify-content-between align-items-center">
				<button type="submit"  class="btn btn-primary" id="placeorder" onClick="SubmitForm('#placeorder','includes/cart.php','#imeiorder_form{if $min}2{/if}','.addedtocart','true','#loader');" value="{$lang.addtocart}" >
					{$lang.addtocart}
				</button>
				{if $paypalactive	&& 	$quick_checkout	&& 	$imeiservice.credit gt 0}
					<img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" onclick="SubmitForm('#quickcheckout','placeholder.php?gat=paypal','#imeiorder_form{if $min}2{/if}','.addedtocart','true','#loader');"/>
				{/if}

			</div>

		</div>



	</div>


	{if !$min}
	<div class="col-lg-6 mb-2">
		<div class="bg-light p-4 rounded" style="height: calc(100vh - 360px);overflow: auto">

			{if $cart}
				<div class="form-group ">
					<div class="">
						<h5>
							{if $currency.prefix}
								<span class="prefix">{$currency.prefix}</span>
							{else}
								{$userdetails.currency.prefix}
							{/if}
							<span id="ctotal">
                                            {$imeiservice.credit-$imeiservice.discount}
                                        </span>
							{if $currency.suffix}
								<span class="suffix">{$currency.suffix}</span>
							{else}
								{$userdetails.currency.suffix}
							{/if}
						</h5>


						{if  $imeiservice.time} <span class="text-muted font-normal"> {$imeiservice.time} {$lang.deliverytime} </span> {/if}
					</div>
				</div>

			{/if}


			<p>{$imeiservice.info}</p>
			<p>	{$imeiservice.retail_info} </p>
		</div>
	</div>
	{/if}


</div>


{if $imeiservice.download_link}
	<div class="form-group ">
		<label>
			{$downloadlink}
		</label>
	</div>
{/if}

{if !$cart}
	<div class="form-group ">
		<label>
			<input type="checkbox" name="frequentlyuse"  {if $imeiservice.frequent} checked='checked' {/if}  onclick="setFrequent('{$imeiservice.id}',this);" />
			{$lang.frequentlymsg}
		</label>
	</div>
{/if}




