
<div    class="alert" ></div>
<form  method="post" name="imeipricing" id="imeipricing">
    {$token}
    {assign var=i value=0}
    <div>
        <table class="table  table-striped">


            {foreach from=$imeiservicelist key=GroupName item=Services}
                <thead>
                <tr>
                    <th><h3>{$GroupName}</h3></th>
                    <th style="white-space: nowrap">{$lang.yourprice} <small>{if $currency.code}({$currency.code}){/if}</small></th>
                    <!-- <th class="w-100">{$lang.selling} {$lang.price}</th>-->
                    <th>{$lang.price} </th>
                    <th>Increase</th>
                    <th>{$lang.selling} {$lang.price}</th>

                </tr>
                </thead>

                <tbody>
                {foreach from=$Services key=id item=Service}
                    <tr>
                        <td><label for="{$id}">{$Service.service_name}</label></td>
                        <td>{$Service.credit-$Service.discount}
                            <input type="hidden" id="yourDis_{$id}" class="price_{$Service.newid}"
                                   value="{$Service.credit-$Service.discount}" /></td>
                        <!--    <td><input type="text" class="form-control " style="width:70px" size="4" name="newprice[{$id}]" id="new_{$id}"
                value="{$Service.resellersprice}" onblur="checkDiscount('{$id}');"/></td>
                -->
                        <td>
                            <input type="text" class="form-control inc_{$Service.newid}" style="width:70px;float: left;"
                                   size="4" name="price[{$id}]" id="prices_{$id}"
                                   value="{$storeprice[$Service.newid].increase}"
                                   onkeyup="calculateStorePrice({$Service.newid});"/>
                        </td>
                        <td>
                            <select   onchange="calculateStorePrice({$Service.newid});" name="pricetype[{$id}]"   class="form-control by_{$Service.newid}">
                                <option {if $storeprice[$Service.newid].increaseby eq 'Percent' }selected{/if}>Percent</option>
                                <option {if $storeprice[$Service.newid].increaseby eq 'Fixed' }selected{/if}>Fixed</option>
                            </select>
                        </td>
                        <td class="calsell_{$Service.newid}">{$calculated[$Service.newid]}</td>
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
    <button type="submit" class="btn btn-primary" id="save"
            onclick="SubmitForm('#save','{$action_link}','#imeipricing','.alert','true','#loader',true);" name="save" value="{$lang.save}" >{$lang.save}</button>
</form>
