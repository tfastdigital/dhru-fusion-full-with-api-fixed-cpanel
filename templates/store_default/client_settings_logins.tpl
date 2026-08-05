
<div class="px-lg-3">
<div  class="alert alert-logins"> </div>
</div>



{if $smarty.request.towstep}

<div>
  <div  class="alert alert-activeaccount mt-3"> </div>
</div>

      <div class="">

          {if $sndkey}
            <form  method="post" id="frm-disabled-account">
              {$token}
              <div class="p-3">
                <button type="submit"  class="btn btn-danger"  name="disable" id="disabled-account"
                        onClick="SubmitForm('#disabled-account','{$action_linkdisable}','#frm-disabled-account','.alert','true','#loader','','',function(data) {
                                 SubmitCallback(data); });"
                        value="{$lang.disable}" > {$lang.disable} </button>
              </div>
            </form>
          {else}

        <form   method="post"   name="savelogin" id="frm_action_linkotp" >
          {$token}
          <div class="form-group ">
            <table   id="sndkey" class="table border-0 table-hover-disable">
              <tr>
                <td>
                  <h3> {$lang.step}1 </h3>
                   <small class="text-muted"> {$lang.installapp} </small>
                </td>
                <td>
                  <div class="form-group d-flex">
                    <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" class="p-3" target="_blank">  <i  class="fab fa-android big-icon"></i>   </a>
                    <a href="https://itunes.apple.com/en/app/google-authenticator/id388497605?mt=8" target="_blank" class="p-3"> <i  class="fab fa-apple big-icon"></i>    </a>
                  </div>
                </td>
              </tr>
              <tr>
                <td><h3> {$lang.step}2 </h3> <small class="text-muted">  {$lang.add} {$lang.account} </small>   </td>
                <td>
                  <div class="row">
                    <div class=" col-lg-4"> <img class="steps mw-100" src="images/auth1.png" /> </div>
                    <div class=" col-lg-4"> <img class="steps mw-100" src="images/auth2.png" /> </div>
                    <div class=" col-lg-4"> <img class="steps mw-100" src="images/auth3.png" /> </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <h3>{$lang.step}3</h3>
                  <small class="text-muted">   Scan QR {$lang.code} and {$lang.activateaccount} </small>
                </td>
                <td><form    method="post" id="rateing" name="rateing">
                    <div>

                      <div class="form-group">
                        <div>
                          <img  src="https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth://totp/{$server}?secret={$secret}" alt="QR Code"  />
                        </div>
                      </div>



                      <div class="form-group mb-0 p-0 col-lg-4 col-md-12">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="{$lang.enter} OTP " name="otp" />
                          <div class="input-group-append">
                            <button type="submit" id="activateaccount"  onClick="SubmitForm('#activateaccount','{$action_linkotp}','#frm_action_linkotp','.alert-activeaccount','true','#loader','','',function(data) { SubmitCallback(data); });" class="btn btn-primary" name="validateotp" value="{$lang.activateaccount}" > {$lang.activateaccount} </button>
                          </div>
                        </div>
                      </div>



                    </div>
                  </form></td>
              </tr>
            </table>
          </div>

        </form>
          {/if}


      </div>

<script>
  function SubmitCallback(data) {
    if (data === 'success') {
      getContect('#tab',"{$secondauthlink}?standalone=true","#step2varification",true,'#loader');
    }
  }
</script>


{else}

  <div class="p-3">

<div class="row">
  <div class="col-lg-6">

  <form   method="post"   name="savelogin" id="savelogin">
  {$token}
  <div class="form-group ">
    <label> {$lang.iprange} </label>
    {$iprange} <small>{$lang.youcanaddip}</small> </div>
  <div>
    <div class="">
      <button type="submit" class="btn btn-primary waves-effect waves-light w-auto"  id="chagelogin" onclick="SubmitForm('#chagelogin','{$action_link}','#savelogin','.alert-logins','true','#loader',true);"  name="changelogin" value="{$lang.save}" > {$lang.save} </button>
      <button type="submit" class="btn btn-secondary w-auto"  id="reset" onclick="SubmitForm('#reset','{$action_link2}','#savelogin','.alert','true','#loader');" name="reset" value="{$lang.reset}" > {$lang.reset} </button>
    </div>
  </div>


</form>

  </div>

  <div class="col-lg-6">
    {if $allowlogincountry}

      <div class="rounded">

      <form method="post" id="frmlcountry">
        {$token}

        <div class="table-responsive">
          <table class="table border-0 table-striped">
        <thead>
          <tr>
            <th>{$lang.allowed} {$lang.country}</th>
            <th class="text-right">{$lang.action}</th>
        </tr>
        </thead>
        <tbody>
          <tr style="background: #e0e2e6 !important;">
            <td>{$country}</td>
            <td class="text-right">
              <button type="button" name="addcntr" id="btnadd"
      onclick="SubmitForm('#btnadd','{$action_logincountry}','#frmlcountry','.alert-logins','true','#loader');"
         class="btn btn-primary">+ {$lang.add}</button>
            </td>
          </tr>

        {foreach from=$allowedcountry key=name item=fields}
        <tr id="{$fields}">
          <td>{$fields}</td>
          <td class="text-right"><span class="cursor-pointer" onclick="removeLoginCountry('{$fields}');"> <i class="fal fa-trash"></i> </span> </td>
        </tr>
        {/foreach}

        </tbody>

      </table>
        </div>
      </form>

      </div>

    {/if}
  </div>
</div>
  </div>
  {/if}



