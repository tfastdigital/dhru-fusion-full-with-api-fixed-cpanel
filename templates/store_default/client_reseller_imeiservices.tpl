 <div id="tabcontent1">
  {literal}

	<script>
		function cehckAll(ob)
		{
				 checked = ob.checked;
				 $(':checkbox').each(function(){ $(this).attr('checked', checked); });
		}
    </script>
{/literal}
<form  method="post" name="store" id="store">
  {$token}
  <input type="hidden" name="action" value="resellerimeiserv" />
  <input type="hidden" name="gid" value="{$gid}" />
  <div  class="alert alert-imei"></div>

    <div class="table-responsive" style="min-height:500px">
  <table class="table  table-striped">
	 <thead>
    <tr>
      <th><input type="checkbox" name="checkall" value="1" onclick="cehckAll(this);" /></th>
      <th> {$lang.service} </th>
      <th>{$lang.your} {$lang.commission}</th>
      <th ></th>
    </tr>
	</thead>
	<tbody>
    <tr>
      <td colspan="4"> <div> {$GroupName}
        <select name="groups" class="form-control " onchange="javascript: getContect('#tab1','widget/resellerservice/imei?grp='+this.value,'#tabcontent1',true,'#loader',true);">
			{foreach from=$imeiservicelist key=GroupName item=pro}
				<option {if $grp eq $GroupName} selected {/if}>{$GroupName}</option>
			{/foreach}
        </select>
        </div>
	</td>

    </tr>
    {foreach from=$iservicelist key=did item=Det}
		{foreach from=$Det key=id item=Service}
		<tr>
		  <td><input type="checkbox" {if $Service.allowreseller} checked="checked" {/if} name="ids[{$Service.id}]" value="{$Service.id}"  /></td>
		  <td>{$Service.service_name}</td>
		  <td><span class="prefix">{$currency.prefix}</span> {$Service.commission|string_format:"%.{$precision}f"}<span class="suffix">{$currency.suffix}</span> </td>
		  <td></td>
		</tr>
		{/foreach}
    {foreachelse}
    <tr>
      <td colspan="4" class="text-center">{$lang.norecordsfound}</td>
    </tr>
    {/foreach}
	</tbody>
  </table>
</div>

    <div class="d-actionbar-mobile">
	<button type="submit"  id="placeorder" class="btn btn-primary"
onclick="SubmitForm('#placeorder','includes/getdata/reseller.save.php','#store','.alert-imei','true','#loader');"
value="{$lang.submit}" >{$lang.submit}</button>
    </div>

</form>
</div>
