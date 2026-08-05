<div class="container"><div class="page-container">
	<div class="card">
		<form class="form-horizontal"  method="post" name="savepassword" id="frmcloseac" >
			<div class="alert"> </div>
			{$token}
			<div class="form-group">
				{$closeaccountnotes}
			</div>
			<div class="form-group">
				<label>
					<input type="checkbox" name="iagree" value="1" />
					{$lang.iagreecloseac}
				</label>
			</div>

			<input type="button" class="btn btn-primary" id="chagepassword" onclick="SubmitForm('#chagepassword','{$action_link}','#frmcloseac','.alert','true','#loader');" name="changepassword" value="{$lang.close} {$lang.account}" />

		</form>
	</div>
	</div></div>
