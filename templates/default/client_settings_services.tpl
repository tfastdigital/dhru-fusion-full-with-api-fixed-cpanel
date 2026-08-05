{$token}



        {foreach from=$servicelist key=GroupName item=Services}
<div class="table-responsive">
    <table class="table  table-striped">
            <thead>
                <tr>
                    <th class="w-100">
                        <h5 class="mt-5">{$GroupName}</h5>
                    </th>
                    <th class="text-right">{$lang.your}&nbsp;{$lang.price}&nbsp;<small>[{$currency.code}]</small></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$Services key=id item=Service}
                    <tr>
                        <td>{$Service.service_name}</td>
                        <td class="text-right">
                            <span> {$Service.credit-$Service.discount} </span>
                            {if $Service.disc gt 0}
                                {if $Service.defaultcredit neq ($Service.credit-$Service.discount)}
                                    <span class='text-danger'> {$Service.disc}%</span>
                                {/if}
                            {/if}
                        </td>
                        <td>
                            {if $Service.active eq 1}
                                <span class="" style="text-center">
                                    <label class="badge badge-success">{$lang.active}</label>
                                </span>
                            {else}
                                <span class="text-center">
                                    <label class="badge badge-danger">{$lang.inactive}</label>
                                </span>
                            {/if}
                        </td>
                    </tr>
                    {foreachelse}
                    <tr>
                        <td colspan="3" class="text-center">{$lang.norecordsfound}</td>
                    </tr>
                {/foreach}
            </tbody>
    </table>
</div>
        {/foreach}

