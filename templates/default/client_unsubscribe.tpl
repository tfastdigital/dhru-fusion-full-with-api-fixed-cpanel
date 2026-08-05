<div class="container content-fluid">

    {if $notification.success}
        <div   class="alert1 alert alert-success" >{$notification.success}</div>
    {elseif $notification.error}
        <div   class="alert1 alert alert-danger" >{$notification.error}</div>
    {/if}
        <div id="formstyle_1">
            <div
                    class="alert alert-profile"></div>
                <form class="form-inline frm-inline" method="post" name="imeiorder_form" id="imeiorder_form" >
                        <input type="hidden" name="id" value="{$mdservice}" />

                                {$token}
<input type="hidden" name="unique" value="{$unique}" />
            <div class="table-responsive">
                <table class="table   table-striped table-hover">
{foreach from=$maillist key=mailk item=Mail}
        <tr>
            <td><input type="checkbox" name="id[{$mailk}]" value="1"
                        {if $Mail.flag eq 1} checked="checked" {/if} /></td>
            <td>{$Mail.name}</td>
        </tr>

{/foreach}
     </table>
            </div>
<button type="submit" class="btn btn-primary mb-2" id="save"
onClick="SubmitForm('#save','{$action_link}','#imeiorder_form','.alert','true','#loader','','',function(data){ submitCallback(data); })"
name="save" value="{$lang.save}">{$lang.save}</button>

                </form>
        </div>
</div>
