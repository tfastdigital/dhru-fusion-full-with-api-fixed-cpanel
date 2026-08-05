{literal}
<script>
		function cehckAll(ob)
		{
			 checked = ob.checked;
			 $(':checkbox').each(function(){ $(this).attr('checked', checked); });
		}
	</script>
{/literal}

<div class="container"><div class="page-container">
    <div class="card">

<form  method="post" name="store" id="store">
  {$token}
  <div    class="alert alert-product"></div>

  <input type="hidden" name="action" value="resellershopserv" />
  <input type="hidden" name="gid" value="{$gid}" />
  <div class="table-responsive">
    <table class="table  table-striped">
      <thead>
        <tr>
          <th><input type="checkbox" name="checkall" value="1" onclick="cehckAll(this);" /></th>
          <th> {$lang.product} </th>
          <th>{$lang.your} {$lang.commission}</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <td  colspan="4">
                <div>
                    <select name="groups" class="form-control   mb-2" onchange="javascript: getContect('#tab4','widget/resellerservice/shop?show=shop&grp='+this.value,'#tabcontent1',true,'#loader');">
                		{foreach from=$myproduct key=GroupName item=pro}
                            <option {if $grps eq $GroupName} selected {/if}>{$GroupName}</option>
                		{/foreach}
                    </select>
                </div>
            </td>

        </tr>
          {foreach from=$pservicelist key=GroupName item=pro}
              {foreach from=$pro key=id item=Service}
                  <tr>
                    <td><input type="checkbox" {if $Service.allowreseller}   checked="checked" {/if} name="ids[{$Service.id}]" value="{$Service.id}"  /></td>
                    <td><a href="{$Service.seourl}">{$Service.service_name}</a></td>
                    <td><span class="prefix">{$currency.prefix}</span> {$Service.commission}<span class="suffix">{$currency.suffix}</span> </td>
                    <td></td>
                  </tr>
              {/foreach}
          {/foreach}
        </tbody>
    </table>
  </div>
  <button type="submit" id="placeorder"  class="btn btn-primary"
onclick="SubmitForm('#placeorder','includes/getdata/reseller.save','#store','.alert-product','true','#loader',true);"
value="{$lang.submit}" >{$lang.submit}</button>
</form>

    </div>
    </div></div>

{literal}
    <style>
        .chosen-container.chosen-container-single{display:none}
        select.form-control{display:block !important}
    </style>
{/literal}
