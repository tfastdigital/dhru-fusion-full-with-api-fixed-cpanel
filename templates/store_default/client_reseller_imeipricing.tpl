<div   class="alert"></div>
<form method="post" name="imeipricing" id="imeipricing">
    {$token}
    {assign var=i value=0}
    <div class="table-responsive">
        <table class="table table-align-center table-striped">
            {foreach from=$imeiservicelist key=GroupName item=Services}
                <thead>
                <tr>
                    <td><input type="checkbox" name="chekall" id="{$GroupName|regex_replace:'/[^a-zA-Z0-9]/':''}"
                               onclick="SelectChildren('{$GroupName|regex_replace:'/[^a-zA-Z0-9]/':''}');"/></td>
                    <td class="w-100"><h3>{$GroupName}</h3></td>
                    <td>{$lang.yourprice}   <small>{if $currency.code}({$currency.code}){/if}</small></td>
                    <td>{$lang.default} {$lang.price} <small>{if $currency.code}({$currency.code}){/if}</small></td>
                    <td>{$lang.newprice}</td>
                </tr>
                </thead>
                <tbody>
                {foreach from=$Services key=id item=Service}
                    <tr>
                        <td><input type="checkbox" name="iservice[{$id}]" value="{$id}"
                                   id="{$id}" {$Service.resellersu}
                                   class="{$GroupName|regex_replace:'/[^a-zA-Z0-9]/':''}"/></td>
                        <td><label for="{$id}">{$Service.service_name}</label></td>
                        <td>{$Service.credit-$Service.discount|string_format:"%.{$precision}f"}
                            <input type="hidden" id="yourDis_{$id}"
                                   value="{$Service.credit-$Service.discount|string_format:"%.{$precision}f"}"/></td>
                        <td>{$Service.resellersprice|string_format:"%.{$precision}f"}</td>
                        <td><input type="text" class="form-control " name="newprice[{$id}]"
                                   id="new_{$id}" value="{$Service.resellersuserdiscount}"
                                   onblur="checkDiscount('{$id}');"/></td>
                    </tr>
                    {foreachelse}
                    <tr>
                        <td colspan="4">{$lang.norecordsfound}</td>
                    </tr>
                {/foreach}
                </tbody>
            {/foreach} </table>
    </div>
    <button type="submit" id="save" class="btn btn-primary"
            onclick="SubmitForm('#save','{$action_link}','#imeipricing','.alert','true','#loader',true);"
            name="save" value="{$lang.save}">{$lang.save}</button>
    <button type="submit" class="btn btn-secondary"
            id="saves" onclick="SubmitForm('#saves','{$action_link1}','#imeipricing','.alert','true',
            '#loader',true);" name="save" value="{$lang.reset} {$lang.price}">{$lang.reset} {$lang.price}</button>
</form>
