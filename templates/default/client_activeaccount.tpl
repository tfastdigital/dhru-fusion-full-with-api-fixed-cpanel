<div id="tabcontent">

  <div id="formstyle_1">
  <div   class="alert"></div>
  {if $notification.success}
    <div   class="alert1 alert alert-success" >{$notification.success}</div>
  {elseif $notification.error}
    <div   class="alert1 alert alert-error" >{$notification.error}</div>
  {/if}

  {if $activated}
{else}
  {if $sentverify}
    <form method="post" name="verify" id="editprofile" >
      <fieldset>
      {$token}

     <p>
            <label>{$lang.mobverificode}:</label>
            <span><input type="text" name="code" /></span>
     </p>
     <p>
            <label>&nbsp;</label>
            <span>
<input type="submit" id="verify" name="activate" value="{$lang.verify}" />
            </span>
     </p>
      </fieldset>
    </form>
  {else}
    <form method="post" name="verify" id="editprofile" >
      <fieldset>
      {$token}

     <p>
            <label>{$lang.username}:</label>
            <span><input type="text" name="username" /></span>
     </p>
     <p>
            <label>{$lang.email}:</label>
            <span><input type="text" name="email" /></span>
     </p>
     <p>
            <label>{$lang.mobileno}:</label>
            <span><input type="text" name="mobile" /><br />
            <small>{$lang.mobilenumber}</small></span>
     </p>
     <p>
            <label>&nbsp;</label>
            <span>
<input type="submit" id="verify" name="ver" value="{$lang.verify}" />
            </span>
     </p>
      </fieldset>
    </form>
  {/if}
    {/if}
  </div>
</div>
</div>
{include file="templates/default/client_common_rightmenu.tpl"}
