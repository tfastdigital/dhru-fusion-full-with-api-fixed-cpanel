
<div class="col-lg-4 p-0">

    <div class="p-3">

<div  class="alert"></div>
  <form method="post" name="adduser" id="adduser">
      {$token}
      <div class="form-group ">
          <label>{$lang.system} {$lang.fromname}</label>
          {$fromname}
      </div>
      <div class="form-group ">
          <label>{$lang.system} From {$lang.email}</label>
          {$smtp_mail}
      </div>
      <div class="form-group ">
          <label>{$lang.mailsignature}</label>
          {$adminsignature}
      </div>

      <div class="mt-4">
      <button type="submit" id="emailsetings" class="btn btn-primary"
              onclick="SubmitForm('#createuser','{$action_link}','#adduser','.alert','true','#loader',true);"
              name="emailsetings"
              value="{if $smtpenable}Send Mail & Save{else}{$lang.save}{/if}">{if $smtpenable}Send Mail & Save{else}{$lang.save}{/if}</button>
      </div>

  </form>
</div>
</div>
</div>
