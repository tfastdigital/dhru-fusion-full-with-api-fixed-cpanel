<div id="tabcontent">

  <div id="formstyle_1">
  <div    class="alert"></div>
    <form class="form-vertical"  method="post" name="contact" id="contact">
    <input type="hidden" name="ids" value="{$ids}" />
      <fieldset>

          <div class="form-group "><label class="form-label">{$lang.title}</label><div class="controls">{$title}
          </div></div>


          <div class="form-group "><label class="form-label">{$detail}</label><div class="controls"></div></div>

          {if $loggedin}
            <div class="form-group "><label class="form-label">{$lang.name}</label><div class="controls">{$userdetails.username}</div></div>
          {else}
            <div class="form-group "><label class="form-label">{$lang.name}</label><div class="controls"><input type="text" name="name" /> *</div></div>
            <div class="form-group "><label class="form-label">{$lang.email}</label><div class="controls"><input type="text" name="email" /> *</div></div>
          {/if}

{if $customfields}
  {foreach from=$customfields key=name item=fields}
    <div class="form-group "><label class="form-label">{$fields.required} {$name}</label><div class="controls">{$fields.input}
    </div></div>
     {if $fields.description}
     <div class="form-group "><div class="controls">
        <small>{$fields.description}</small>
        </div></div>
    {/if}
  {/foreach}
{/if}

          {if $loggedin}
          {else}
          	<div class="form-group "><div class="controls">{$captcha}</div></div>
          {/if}
<div class="form-group "><div class="controls">
<button type="submit"  id="send"
onclick="SubmitForm('#send','includes/getdata/survey','#contact','.alert','true','#loader');"
 name="send" class="btn btn-primary waves-effect waves-light" value="{$lang.submit}" >{$lang.submit}</button>
</div></div>

      </fieldset>
    </form>
  </div>
</div>
</div>
{include file="templates/default/client_common_rightmenu.tpl"}
