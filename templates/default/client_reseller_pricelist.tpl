
<div class="container"><div class="page-container">

    <div class="card">
        <ul class="nav nav-pills flex-nowrap">
            {if $userdetails.access.imeiservice}
                <li class="nav-item " onclick="getContect('#tab','{$imeilink}','#services',true,'#loader',true);">
					<a data-toggle="tab" class="nav-link  active" href="#imei-services">
						<span> {$lang.imeiservice} </span>
					</a>
                </li>
            {/if}
            {if $userdetails.access.fileservice}
                <li class="nav-item " onclick="getContect('#tab','{$filelink}','#services',true,'#loader',true);">
					<a data-toggle="tab" class="nav-link " href="#file-services">
						<span>{$lang.fileservice}</span>
					</a>
                </li>
            {/if}
            {if $userdetails.access.serverlogservice}
                <li class="nav-item " onclick="getContect('#tab','{$serverlink}','#services',true,'#loader',true);">
					<a data-toggle="tab" class="nav-link " href="#server-services">
						<span>{$lang.serverservice}</span>
					</a>
                </li>
            {/if}
            {if $userdetails.access.remoteservice}
                <li class="nav-item " onclick="getContect('#tab','{$remotelink}','#services',true,'#loader',true);">
					<a data-toggle="tab" class="nav-link " href="#remote-services">
						<span>{$lang.remote} {$lang.service}</span>
					</a>
                </li>
            {/if}
        </ul>


        <div class="tab-content p-3">

			<div   class="alert"></div>

            <div class="tab-pane  fade active show" id="imei-services">

					<form method="post" class="float-right"  id="frminc">
						{$token}

						<div class="form-row align-items-center">
							<h6 class="form-group">
								IMEI {$lang.profit} {$lang.margin}
							</h6>
							<div class="form-group mx-2">
								<input type="text" size="5" style="width: 100px" class="form-control" name="increaseval"
									   value="{$userdetails.increaseval}"/>
							</div>
							<div class="form-group">
								<select name="increaseby"  style="width: 100px" class="form-control no-chosen">
									<option {if $userdetails.increaseby eq 'Percent'} selected {/if} >Percent</option>
									<option {if $userdetails.increaseby eq 'Fixed'} selected {/if} >Fixed</option>
								</select>
							</div>
							<div class="form-group ml-2">
								<button name="save" class="btn btn-primary" id="isave"
										onclick="SubmitForm('#isave','{$imeisavelink}','#frminc','.alert','true','#loader',true);"
										type="submit" value="Save">{$lang.save}</button>
							</div>
						</div>
					</form>


			</div>
			<div class="tab-pane fade" id="file-services">
				<form method="post" class="float-right"  id="filefrminc">
					{$token}

					<div class="form-row align-items-center">
						<h6 class="form-group">
							{$lang.file} {$lang.profit} {$lang.margin}
						</h6>
						<div class="form-group mx-2">
							<input type="text" size="5"  style="width: 100px" class="form-control" name="increaseval"
								   value="{$userdetails.fileincrease}"/>
						</div>
						<div class="form-group">
							<select name="increaseby"  style="width: 100px" class="form-control no-chosen">
								<option {if $userdetails.fileincreaseby eq 'Percent'} selected {/if} >Percent</option>
								<option {if $userdetails.fileincreaseby eq 'Fixed'} selected {/if} >Fixed</option>
							</select>
						</div>
						<div class="form-group ml-2">
							<button name="save" class="btn btn-primary" id="fsave"
									onclick="SubmitForm('#fsave','{$filepersave}','#filefrminc','.alert','true','#loader',true);"
									type="submit" value="Save">{$lang.save}</button>
						</div>
					</div>
				</form>
			</div>
			<div class="tab-pane  fade" id="server-services">
				<form method="post" class="float-right"  id="serverfrminc">
					{$token}

					<div class="form-row align-items-center">
						<h6 class="form-group">
							{$lang.server} {$lang.profit} {$lang.margin}
						</h6>
						<div class="form-group mx-2">
							<input type="text" size="5"  style="width: 100px" class="form-control" name="increaseval"
								   value="{$userdetails.serverincrease}"/>
						</div>
						<div class="form-group">
							<select name="increaseby"  style="width: 100px" class="form-control no-chosen">
								<option {if $userdetails.serverincreaseby eq 'Percent'} selected {/if} >Percent</option>
								<option {if $userdetails.serverincreaseby eq 'Fixed'} selected {/if} >Fixed</option>
							</select>
						</div>
						<div class="form-group ml-2">
							<button name="save" class="btn btn-primary" id="ssave"
									onclick="SubmitForm('#ssave','{$serverpersave}','#serverfrminc','.alert','true','#loader',true);"
									type="submit" value="Save">{$lang.save}</button>
						</div>
					</div>

				</form>
			</div>
			<div class="tab-pane  fade" id="remote-services">
				<form method="post" class="float-right"  id="remotefrminc">
					{$token}

					<div class="form-row align-items-center">
						<h6 class="form-group">
							{$lang.remote} {$lang.profit} {$lang.margin}
						</h6>
						<div class="form-group mx-2">
							<input type="text" size="5"  style="width: 100px" class="form-control" name="increaseval"
								   value="{$userdetails.remoteincrease}"/>
						</div>
						<div class="form-group">
							<select name="increaseby"  style="width: 100px" class="form-control no-chosen">
								<option {if $userdetails.remoteincreaseby eq 'Percent'} selected {/if} >Percent</option>
								<option {if $userdetails.remoteincreaseby eq 'Fixed'} selected {/if} >Fixed</option>
							</select>
						</div>
						<div class="form-group ml-2">
							<button name="save" class="btn btn-primary" id="rsave"
									onclick="SubmitForm('#rsave','{$remotepersave}','#remotefrminc','.alert','true','#loader',true);"
									type="submit" value="Save">{$lang.save}</button>
						</div>
					</div>
				</form>
			</div>

			<div id="services">
				<script>
					getContect('#tab', '{$imeilink}', '#services', true, '#loader',true);
				</script>
			</div>


        </div>



    </div>
	</div></div>

