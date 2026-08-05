
<div class="container"><div class="page-container">

	<div class="card card-simple-form">

  <form  method="post" name="crtransfer" id="crtransfer">

    {$token}

	  <div class="row">
		  <div class="col-lg-4 m-auto">
			  <div class="mb-4 bottom-space  text-center">
				  <h3 class="m-0">{$userdetails.currency.prefix} {$userdetails.credit.credit} {$userdetails.currency.suffix}</h3>
				  <small class="text-muted">Your {$lang.balance}</small>
			  </div>



			  <div   class="alert"></div>

			  <div class="form-group ">
				<label>{$lang.amount}</label>
				<input type="text" class="form-control " id="wamount" name="amount"
					   onkeyup="setGatewayInfo($('#gateway').val(),$('#wamount').val());" />
			  </div>
			  <div class="form-group ">
				<label>{$lang.paymentmethod}</label>
				<select name="gateway" class="form-control " id="gateway"
						onchange="setGatewayInfo(this.value,$('#wamount').val());">
				  <option value="">{$lang.select}</option>
					{foreach from=$gateway key=id item=gat}
				  <option value="{$id}">{$gat}</option>
					{/foreach}
				</select>
				<span id="note"></span>
			</div>

			<div class="form-group ">
			  <label>{$lang.order}</label>
			  <input type="text" class="form-control " name="account" />
			</div>


			  <div class="d-actionbar-mobile">
				  <button type="submit"  id="transfer" class="btn btn-primary w-100" onclick="SubmitForm('#transfer','{$actionlink}','#crtransfer','.alert','true','#loader');"
						  name="transfer" value="{$lang.request} {$lang.for} {$lang.withdrawal}" >{$lang.request} {$lang.for} {$lang.withdrawal}</button>
			  </div>

		  </div>
	  </div>



  </form>

	</div>
	</div></div>
