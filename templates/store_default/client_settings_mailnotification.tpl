
<div class="container"><div class="page-container">
  <div class="card">
    <div  class="alert"></div>
  <form method="post" id="frmnotify">
    {$token}
    <div class="table-responsive">
      <table class="table  border-0 table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th class="w-100"> {$lang.name} </th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$maillist key=id item=mail}
          <tr>
            <td> <div class="checkbox"> <label> <input type="checkbox" {if $mail.flag eq 1} checked="checked" {/if} value="{$mail.id}" name="id[{$id}]" /> <i class="helper"></i> </label>  </div> </td>
            <td>{$mail.name}</td>
          </tr>
          {foreachelse}
          <tr>
            <td colspan="3" class="text-center">{$lang.norecordsfound}</td>
          </tr>
          {/foreach}
        </tbody>
      </table>
    </div>
    <div class="d-actionbar-mobile">
      <button class="btn btn-primary" type="submit" name="save" id="save" value="{$lang.save}" onclick="SubmitForm('#save','{$actionmailnotification}','#frmnotify','.alert','true','#loader');" >{$lang.save}</button>
    </div>
  </form>
  </div>
  </div></div>
