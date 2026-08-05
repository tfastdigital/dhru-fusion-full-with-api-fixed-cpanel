<div id="tabcontent">

    <form  method="post" name="store" id="store">
     {$token}
    <input type="hidden" name="action" value="resellerimeiserv" />
        <div class="table-responsive" style="min-height:500px">
        <div    class="alert"></div>
        <table class="table   table-striped">
          <tr>
            <th>&nbsp;</th>
            <th width="70%">{$lang.service} </th>
            <th align="right" >{$lang.commission}</th>
          </tr>
          {foreach from=$imeiservicelist key=GroupName item=pro}
            {foreach from=$pro key=id item=Service}
          <tr>
          <td><input type="checkbox" {if $Service.allowreseller} checked="checked" {/if} name="ids[{$Service.id}]" value="{$Service.id}"  /></td>
          <td>{$Service.service_name}</td>
          <td align="right"><span class="prefix">{$currency.prefix}</span> {$Service.commission|string_format:"%.{$precision}f"}<span class="suffix">{$currency.suffix}</span> </td>
          </tr>
             {/foreach}
{foreachelse}
    <tr>
      <td colspan="3" align="center">{$lang.norecordsfound}</td>
    </tr>
          {/foreach}
        </table>

        <div class="d-actionbar-mobile">
   <button  class="btn btn-primary" type="submit" id="placeorder"
onclick="SubmitForm('#placeorder','includes/getdata/reseller.save.php','#store','.alert','true','#loader');"
value="{$lang.submit}" />
        </div>

        </div>

    </form>
    </div>
