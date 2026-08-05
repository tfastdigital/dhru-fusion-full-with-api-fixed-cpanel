
	<div class="container"><div class="page-container">

		<div class="card">

		{if $notification}
		<div  class="alert1 alert {$class}">
				{$msg}
			</div>
		{else}
		<div   class="alert"> </div>
		{/if}

		<form   method="post" id="rateing" name="rateing">
			<div class="table-responsive">
			<table class="table border-0 table-hover-disable">
				<tr>
					<td> <h4> {$lang.step}1 </h4></td>
					<td class="w-100">
						<h6> {$lang.generateqr}</h6>
						<div class="form-inline frm-inline">

								<input placeholder="{$lang.your} {$lang.login} {$lang.password}" class="form-control  mb-2 mr-sm-2" type="password" name="pass" />
								<button type="submit"   class="btn btn-primary mb-2" name="generateqr" value="{$lang.generate} QR {$lang.code}" >
									{$lang.generate} QR {$lang.code}
								</button>
							</div>

						{if $pass} <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl={$appstring}&choe=UTF-8" /> {/if}
					</td>
					<td>
					</td>
				</tr>

				<tr>
					<td> <h4> {$lang.step}2 </h4></td>
					<td colspan="2">
						<h6>  {$lang.installapp} </h6>
						<a href="{if $andlink}{$andlink}{else}https://play.google.com/store/apps/details?id=com.dhru.fusionclient&hl=en{/if}" target="_blank">
							 <i class="fab fa-android big-icon"></i>
						</a>
					</td>
				</tr>

				<tr>
					<td> <h4> {$lang.step}3 </h4> </td>
					<td colspan="2">
						<h6> {$lang.serverdetails}  </h6>
						<div> <small class="text-muted"> {$lang.enterserverdetails}  <strong>{$lang.or}</strong> {$lang.scanaboveqrcodefromapp} </small>   </div>
						<div class="container"><div class="py-3">
							<div class="row">
								<div class="col-lg-4 pl-0">
									<div class="border">
										<img class="steps" src="images/screen2.jpg" />
									</div>
								</div>
								<div class="col-lg-4 pl-0">
									<div class="border">
										<img class="steps"   src="images/screen1.jpg" />
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
			</table>
		 </div>
		</form>

		</div>
		</div></div>
