<div class="container"><div class="page-container">
  <div class="card card-simple-form">
    <div class="row">
      <div class="col-lg-4 m-auto">
        <div  class="alert"></div>
        <form   method="post" name="crtransfer" id="crtransfer">
          {$token}

            <div class="form-group">
              <label>{$lang.username}</label>
              {$username}
            </div>

            {if $listuser}

              <div> <h3 class="h3 or m-0"><span class="text-muted">  OR </span></h3> </div>

              <div class="form-group">
                <select name="userlist" class="form-control frm-ctrl">
                  <option value="">{$lang.select}</option>
                  {foreach from=$listuser key=id item=user}
                    <option value="{$user.username}">{$user.username}</option>
                  {/foreach}
                </select>
              </div>
            {/if}

          <div class="form-group ">
            <label>{$lang.email}</label>
            {$email} </div>
          <div class="form-group ">
            <label>{$lang.credit}</label>
            {$credit} </div>

          <div class="d-actionbar-mobile">
            <button type="submit" class="btn btn-primary w-100"  id="transfer" onclick="SubmitForm('#transfer','{$action_link}','#crtransfer','.alert','true','#loader');" name="transfer" value="{$lang.crtransfer}" >{$lang.crtransfer}</button>
          </div>
        </form>
      </div>
  </div>
  </div>
  </div></div>
