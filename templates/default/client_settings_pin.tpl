<div class="col-lg-4 p-0">
<div class="p-3">
	<div   class="alert alert-pin">
	</div>

		<form   method="post" name="savepassword" id="savepassword2">

			{$token}
			<div class="form-group ">
				<label>
					{$lang.currentpin}
				</label>
				{$current}
			</div>
			<div class="form-row ">
				<div class="form-group  col-lg-6">
					<label>
						{$lang.newpin}
					</label>
					{$newpassword}
				</div>
				<div class="form-group   col-lg-6">
					<label>
						{$lang.confirmpin}
					</label>
					{$confirmation}
				</div>
			</div>
			<div class="d-actionbar-mobile">
				<button type="submit"  id="chagepassword2" class="btn btn-primary" onClick="SubmitForm('#chagepassword2','{$action_link}','#savepassword2','.alert-pin','true','#loader');"  name="changepassword" value="{$lang.save}" >
					{$lang.save}
				</button>
			</div>
		</form>
	</div>
</div>
