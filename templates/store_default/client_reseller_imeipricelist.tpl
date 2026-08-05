
<form method="post" name="pricing" id="pricing">
    {$token}
    {assign var=i value=0}
    <div>
        <table class="table table-align-center table-striped">


            {foreach from=$imeiservicelist key=GroupName item=Services}
                <thead>
                <tr>
                    <th class="w-100"><h5 class="p-0 mt-5">{$GroupName}</h5></th>
                    <th class="text-right no-wrap">{$lang.yourprice} <small>{if $currency.code}({$currency.code}){/if}</small></th>
                    <th class="text-center no-wrap">{$lang.price} </th>
                    <th  class="text-center no-wrap">Increase</th>
                    <th class="text-right no-wrap">{$lang.selling} {$lang.price}</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$Services key=id item=Service}
                    <tr>
                        <td ><label for="{$id}">{$Service.service_name}</label></td>
                        <td  class="text-right">{$Service.credit-$Service.discount}
                            <input type="hidden" id="yourDis_{$id}" class="price_{$Service.newid}"
                                   value="{$Service.credit-$Service.discount}"/></td>

                        <td  class="text-center">
                            <input style="width: 100px" type="text" class="form-control inc_{$Service.newid}"
                                   size="4" name="price[{$id}]" id="prices_{$id}"
                                   value="{$storeprice[$Service.newid].increase}"
                                   onkeyup="calculateStorePrice({$Service.newid});"/>
                        </td>
                        <td  class="text-center">
                            <select style="width: 100px" onchange="calculateStorePrice({$Service.newid});" name="pricetype[{$id}]"
                                    class="form-control no-chosen by_{$Service.newid}">
                                <option {if $storeprice[$Service.newid].increaseby eq 'Percent' }selected{/if}>Percent
                                </option>
                                <option {if $storeprice[$Service.newid].increaseby eq 'Fixed' }selected{/if}>Fixed
                                </option>
                            </select>
                        </td>
                        <td class="text-right calsell_{$Service.newid}">{$calculated[$Service.newid]}</td>
                    </tr>
                    {foreachelse}
                    <tr>
                        <td colspan="4">{$lang.norecordsfound}</td>
                    </tr>
                {/foreach}
                </tbody>
            {/foreach}
        </table>
    </div>

    <div class="mt-5">
    <button type="submit" class="btn btn-primary" id="save"
            onclick="SubmitForm('#save','{$action_link}','#pricing','.alert','true','#loader',true);" name="save"
            value="{$lang.save}">{$lang.save}</button>
    </div>
</form>
