
<div class="container"><div class="page-container">
    <div class="card card-simple-form">
        <div class="row">
        <div class="col-lg-3 m-auto">
            <div  class="alert"></div>
          <form  method="post" name="voucher" id="voucher">
            {$token}
             <div>
                <div class="form-group">
                  <label>{$lang.recharge} {$lang.code}</label>
                  {$code}
                </div>
            </div>
              <div class="d-actionbar-mobile">
                <button type="submit" class="btn btn-primary w-100" id="transfer" onclick="SubmitForm('#transfer','{$action_link}','#voucher','.alert','true','#loader');" name="transfer" value="{$lang.recharge}" >{$lang.recharge}</button>
              </div>
          </form>
        </div>
</div>
    </div>
    </div></div>
