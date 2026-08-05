<div    class="alert alert-suggest" > </div>
<form  method="post" name="contact" id="contact">
	<input type="hidden" name="_serviceid" value="{$_serviceid}" />
    <div class="form-row ">
    	<div class="form-group  col-lg-6">
    		<label>
    			{$lang.name}
    		</label>
    			<input type="text" class="form-control "   name="name" />
    	</div>
    	<div class="form-group  col-lg-6">
    		<label>
    			{$lang.email}
    		</label>
    			<input type="text" class="form-control "   name="email" />
    	</div>
    </div>
	<div class="form-group ">
		<label>
			{$lang.price}
		</label>
        <div class="input-group">
		<input type="text" class="form-control "   name="price" />
          <div class="input-group-append">
		      <span class="input-group-text">{$currency.code}</span>
          </div>
        </div>
	</div>
	<div class="form-group ">
		<label>
			{$lang.comments}
		</label>
		<textarea name="comment" class="form-control "  rows="4" cols="40"></textarea>
		<div class="text-muted"> {$lang.suggestedpriceinfo}</div>
	</div>
	{if $loggedin}
	{else}
	<div class="form-group input-captcha">
		{$captcha}
	</div>
	{/if}
	<button type="submit" class="btn btn-primary" id="send"  name="send" value="{$lang.submit}" onclick="SubmitForm('#send','includes/getdata/support.php','#contact','.alert-suggest','true','#loader');"> {$lang.submit} </button>
</form>
