<div class="col-lg-4">
<form   method="post"  name="savequestion" id="savequestion">
		<div   class="alert alert-question">
		</div>
		{$token}

		{if $currentque}
    		<div class="form-group ">
    			<label>
    				{$currentque}
    			</label>

    				{$currentans}

    		</div>
		{/if}
		<div class="form-group ">
			<label>
				{$lang.select_} {if $currentque} {$lang.new} {/if} {$lang.question}
			</label>

				{$question}

		</div>
		<div class="form-group ">
			<label>
				{$lang.youranswer}
			</label>

				{$answer}

		</div>

	<div class="d-actionbar-mobile">
		<button type="submit" class="btn btn-primary w-100" id="chageque" onclick="SubmitForm('#chageque','{$action_link}','#savequestion','.alert-question','true','#loader');" name="chageque" value="{$lang.save}" >
			{$lang.save}
		</button>
	</div>
	</form>
</div>
