<div class="container"><div class="page-container">
  <form   method="post" name="addcredit" id="addcredit">
    {if $error}
    <div   class="alert alert1 alert-danger">{$error}</div>
    {else}
    <div    class="alert"></div>
    {/if}
    {$token}

    {if $NoUser}


	  <div class="row">
		  <div class="col-lg-6">
			<div class="form-group ">
			  <label><span class="badge badge-success"> + {$lang.addcredit}  </span></label>
			 <div class="input-group">
			  	{$credit}
			 </div>
			</div>
			<div class="form-group ">
				<label> <span class="badge badge-danger">  - {$lang.rebatecredit} </span>  </label>
			  {$rebate}
			</div>
			<div class="form-group ">
			  <label> {$lang.note}</label>
				<textarea name="note" class="form-control "></textarea>
			</div>
			 <button type="submit" class="btn btn-primary"  id="addcredit1" onclick="SubmitForm('#addcredit1','{$action_link}','#addcredit','.alert','true','#loader');" name="addcredit" value="{$lang.save}" >{$lang.save}</button>
		  </div>

		  <div class="col-lg-6">
			  <div class="jumbotron">
				   {if $UserFound}

					   <div>
						   <i class="fal fa-user" aria-hidden="true"></i> {$username}
						   &nbsp;&nbsp;&nbsp;&nbsp;
						   <i class="fal fa-envelope" aria-hidden="true"></i> {$email}
					   </div>

					<div class="form-group ">
					  <h1>{$balance}</h1>
					  {$lang.availablebalance}
					</div>
					{else}
					<div class="form-group ">
					  <h1 class=" h1">{$myuserdtl}</h1>
					  <label>{$lang.user}</label>
					</div>
					{/if}
				</div>
		  </div>
	  </div>



    {else}
    {$lang.youhavenouser}
    {/if}
  </form>
	</div></div>
