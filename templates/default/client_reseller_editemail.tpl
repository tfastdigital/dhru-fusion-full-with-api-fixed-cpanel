
<div   class="alert"></div>
<form  method="post" name="editemail" id="editemail">
  <input type="hidden" name="id"  value="{$id}"/>
    {$token}
    <div class="form-group ">
      <label>{$lang.fromname}</label>
      {$fromname}
    </div>
    <div class="form-group ">
      <label>{$lang.fromemail}</label>
      {$fromemail}
    </div>
    <div class="form-group ">
      <label>{$lang.subject}</label>
      {$subject}
    </div>
    <div class="form-group ">
      <label>{$lang.message}</label>
      {$message}
    </div>
    <button type="submit" class="btn btn-primary"  id="save" onclick="SubmitForm('#save','{$action_link}','#editemail','.alert','true','#loader',true);"  name="save" value="{$lang.save}" >{$lang.save}</button>
    <button type="submit"  id="reset" class="btn btn-secondary"  name="reset" value="{$lang.reset} {$lang.to} {$lang.default}" >{$lang.reset} {$lang.to} {$lang.default}</button>
</form>
