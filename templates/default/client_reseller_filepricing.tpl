
<div    class="alert" ></div>
<form  method="post" name="imeipricing" id="imeipricing">
	<div class="table-responsive">
  {$token}
  {assign var=i value=0}
  {foreach from=$fileservicelist key=GroupName item=Services}

        <table class="table table-bordered table-striped">
		<thead>
          <tr>
            <th><input type="checkbox" name="chekall" id="{$GroupName|regex_replace:'/[^a-zA-Z0-9]/':''}"
            onclick="SelectChildren('{$GroupName|regex_replace:'/[^a-zA-Z0-9]/':''}');"/></th>
            <th><h3>{$GroupName}</h3></th>
            <th>{$lang.yourprice} <small>{if $currency.code}({$currency.code}){/if}</small></th>
            <th>{$lang.default} {$lang.price} <small>{if $currency.code}({$currency.code}){/if}</small></th>
            <th>{$lang.newprice}</th>
          </tr>
			</thead>
			<tbody>
          {foreach from=$Services key=id item=Service}
              <tr>
                <td><input type="checkbox" name="fservice[{$id}]" value="{$id}"
                id="{$id}" {$Service.resellersu} class="{$GroupName|regex_replace:'/[^a-zA-Z0-9]/':''}"/></td>
                <td><label for="{$id}">{$Service.service_name}</label></td>
                <td>{$Service.credit-$Service.discount|string_format:"%.{$precision}f"}<input type="hidden" id="yourDis_{$id}" value="{$Service.credit-$Service.discount}" /></td>
                <td>{$Service.resellersprice|string_format:"%.{$precision}f"}</td>
                <td><input type="text" size="18" class="form-control " name="newprice[{$id}]" id="new_{$id}" value="{$Service.resellersuserdiscount}" onblur="checkDiscount('{$id}');"/></td>
              </tr>
          {foreachelse}
              <tr>
                <td colspan="4">{$lang.norecordsfound}</td>
              </tr>
          {/foreach}
				</tbody>
        </table>
  {/foreach}

		</div>

	<button type="submit"  id="save" class="btn btn-primary"
onclick="SubmitForm('#save','{$action_link}','#imeipricing','.alert','true','#loader',true);"
name="save" value="{$lang.save}" >{$lang.save}</button>

<button type="submit"  class="btn btn-secondary"
id="saves" onclick="SubmitForm('#saves','{$action_link1}','#imeipricing','.alert','true',
'#loader',true);" name="save" value="{$lang.reset} {$lang.price}" >{$lang.reset} {$lang.price}</button>

</form>
</div>
