
<div  class="alert"></div>
<div class="row">
  <div class="col-lg-12">
    <div class="row">

      <div class="col-lg-3  mb-2">
        <div>
          <h5 class="p-3">   {$lang.financial} {$lang.statement}  </h5>
          <div class="p-3">
            <span> {$lang.invoicestotal} {$lang.receipt} : {$paytotal} {$currency.code} </span> <br/>
            <span> {$lang.paid} :  {$paypaid} {$currency.code}</span> <br/>
            <span> {$lang.unpaid} :  {$paypending} {$currency.code} </span>
          </div>
        </div>
	  </div>
      <div class="col-lg-3  border-right border-left   mb-2">
        <div>
          <h5 class="p-3">  {$lang.account} {$lang.details} </h5>
          <div class="p-3">
            <span>{$lang.credit} {$lang.left} :  {$Ruser.credit.credit} {$currency.code} </span>
            <br/>
            <span> {$lang.credit} {$lang.used} : {$Ruser.credit.used} {$currency.code} </span>
            <br/>
            <span> {$lang.credit} {$lang.inprocess} : {$Ruser.credit.in_process} {$currency.code}</span>
          </div>
        </div>
      </div>

      <div class="col-lg-3 border-right  mb-2">
        <form method="post" id="frmpass">
          {$token}
          <input type="hidden" name="Userid" value="{$userid}" />
        <div>

          <h5 class="p-3"> {$lang.change} {$lang.password}  </h5>
          <div class="p-3">


            <div class="form-group ">
              <label><span >  {$lang.new} {$lang.password}  </span></label>
              <div class="input-group">
                <input type="text" class="form-control" name="password" />
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100"  id="changepass" onclick="SubmitForm('#changepass','{$changepasslink}','#frmpass','.alert','true','#loader');"
                    name="changepass" value="{$lang.save}" >{$lang.update}</button>
          </div>
        </div>
        </form>

      </div>

      <div class="col-lg-3 mb-2">
        <div class="">

            <form method="post" id="frmrs">
            <div class=""> {$Ruser.firstname} {$Ruser.lastname} ({$Ruser.country}) </div>
            <a  class="cursor-pointer"  onclick="SubmitForm('#btnd','{$changestatlink}','#frmrss','.alert','true','#loader');">
              {if $Ruser.userstatus eq 0}
                <span class="badge badge-success">Active</span>
              {else}
                <span class="badge badge-important">Inactive</span>
              {/if}
            </a> <br/>
            {if $clientsdetails.companyname}({$clientsdetails.companyname}) <br/>
            {/if}
            <div><i class="fa fa-envelope-o" aria-hidden="true"></i> {$Ruser.email}</div>
            <div><i class="fa fa-phone" aria-hidden="true"></i> {$Ruser.phonenumber}</div>

          <hr class="my-4">
          <p> {$lang.lastlogin}: {$Ruser.lastlogin|date_format:'%D,%I:%M %p'} <br />
            {$lang.last} {$lang.login} {$lang.ip} : {$Ruser.lastloginip} </p>
          <div> <a  class="cursor-pointer"  onclick="SubmitForm('#btnrs','{$resetpasslink}','#frmrs','.alert','true','#loader');">{$lang.reset} {$lang.password} & {$lang.send} {$lang.mail}</a> </div>
            </form>
        </div>
      </div>

<!--
      <div class="col-lg-6 col-md-6 mb-2">
        <div class="border p-3">
          <h5>{$lang.change} {$lang.status}</h5>
             {if $Ruser.userstatus eq '0'}
               <span class="badge badge-success">{$lang.active} </span> <br />
               <button type="button" class="btn btn-primary" name="changestatus1" value="change status">{$lang.inactive}</button>
               <button type="button" class="btn btn-danger" name="changestatus2" value="change status">{$lang.blocked}</button>
             {/if}

          {if $Ruser.userstatus eq '2'}
            <span class="badge badge-warning">{$lang.inactive} </span> <br />
            <button type="button" class="btn btn-primary" name="changestatus1" value="change status">{$lang.active}</button>
            <button type="button" class="btn btn-danger" name="changestatus2" value="change status">{$lang.blocked}</button>
          {/if}
          {if $Ruser.userstatus eq '1'}
            <span class="badge badge-danger">{$lang.blocked} </span> <br />
            <button type="button" class="btn btn-primary" name="changestatus1" value="change status">{$lang.active}</button>
            <button type="button" class="btn btn-danger" name="changestatus2" value="change status">{$lang.inactive}</button>
          {/if}

        </div>
      </div>
-->

    </div>
  </div>

</div>
</div>
<form method="post" id="frmrs">
  {$token}
  <input type="hidden" name="Userid" value="{$userid}" />
</form>
<form method="post" id="frmrss">
  {$token}
  <input type="hidden" name="Userid" value="{$userid}" />
</form>
