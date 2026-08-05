<script type="text/javascript" src="templates/default/js/passwordstrangth.js"></script>

	{literal}
	<script type="text/javascript">
    $(function () {
        $('input[name="password"]').passStrengthify();
    });
</script>
	<style>
    .passStrengthify{display:block !important}
    .controls input[type="password"]{width:200px !important}
</style>
	{/literal}

<div class="col-lg-4 p-0">

	<form   method="post" name="savepassword" class="p-3" id="savepassword" >
		{if $notification}
		<div   class="alert1 alert">
			{$msg}
		</div>
		{/if}
		<div   class="alert alert-password">
		</div>
		{$token}
		<div class="form-group">
			<label>
				{$lang.currentpass}
			</label>
			{$current}
		</div>
		<div class="form-row ">
			<div class="form-group  col-lg-6">
				<label>
					{$lang.newpass}
				</label>
				{$newpassword}
			</div>
			<div class="form-group  col-lg-6">
				<label>
					{$lang.confirmpass}
				</label>
				{$confirmation}
			</div>
		</div>
		{if $pin eq 1}
		<div class="form-group">
			<label>
				{$lang.masterpin}
			</label>
			<input type="password" name="pin" id="pin" maxlength="4"  />
		</div>
		{/if}
		<div class="d-actionbar-mobile">
			<button type="submit" class="btn btn-primary" id="chagepassword" onclick="SubmitForm('#chagepassword','{$action_link}','#savepassword','.alert-password','true','#loader');" name="changepassword" value="{$lang.save}" >
				{$lang.save}
			</button>
		</div>
	</form>
</div>
