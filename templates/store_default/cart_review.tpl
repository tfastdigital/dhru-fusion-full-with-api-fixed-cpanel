		{foreach from=$review key=id item=det}
    		<div>
    			{if $det.rate}
    			{else}
    		      	{assign var=$det.rate value='0'}
    			{/if}
    			<blockquote>
					{$det.comment}
				   <small>{$det.name} ({$det.date})</small>
    				{if $det.rate}
        				{literal}
        				<script>
                            $(document).ready(function() {
                                $('#allrate{/literal}{$id}{literal}').rating('javascript:void(0)', {maxvalue:5, curvalue:{/literal}{$det.rate}{literal}});
                            });
                        </script>
        				{/literal}
    				{/if}
    				<div>
    					<div id="allrate{$id}" class="ratinga">
    						&nbsp;
    					</div>
    				</div>
    			</blockquote>
    		</div>
		{/foreach}
		{if $notification.error}
    		<div    class="alert alert-danger">
    			{$notification.error}
    		</div>
		{else}
		{/if}
		<form   method="post" id="rateing" name="rateing">
			{if $sid}
			<input type="hidden" name="sid" value="{$sid}" />
			{elseif $lid}
			<input type="hidden" name="lid" value="{$lid}" />
			{else}
			<input type="hidden" name="pid" value="{$pid}" />
			{/if}
			<div   class="alert alertv"> </div>
            <div class="form-row ">
    			<div class="form-group  col-lg-6">
    				<label>
    					{$lang.name}
    				</label>
    					{$name}
    			</div>
    			<div class="form-group  col-lg-6">
    				<label>
    					{$lang.email}
    				</label>
    					{$email}
    			</div>
            </div>
			<div class="form-group ">
				<label>
					{$lang.comment}
				</label>
					<textarea rows="4" class="form-control " cols="40" name="comment"></textarea>
			</div>
			<div class="form-group ">
    			{literal}
    				<script>
                        $(document).ready(function() {
                            $('#rates').rating('#estart', {maxvalue:5, increment:.5 ,curvalue: 4});
                        });
                    </script>
    			{/literal}
    			<div id="rates"  class="rating">
    				&nbsp;
    			</div>
            </div>
			<input type="hidden" name="estart" value="4" id="estart" />
			{if $captcha}
    			<div class="form-group  input-captcha">
  					{$captcha}
    			</div>
			{/if}
			<button type="submit"  id="regi" class="btn btn-primary w-100"  onclick="SubmitFormJSON('#regi','{$reviewlink}','#rateing','.alertv','true','#loader');" name="comment" value="{$lang.save}" >
				{$lang.save}
			</button>
		</form>
