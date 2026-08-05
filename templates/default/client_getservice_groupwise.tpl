<ul class="searchservice">
    {foreach from=$servicelistarray key=MID item=items}

        {foreach from=$items key=ID item=item}

            <li  class="s{$item.group_id} item-block pull-left service-list" onclick="getServicedetailsIMEI('{$ID}','#serviceDetails','.alert',true,'#loader','','','#information');serviceDetails('{$ID}');"><span class="searchme">{$item.service_name}</span></li>

        {/foreach}

    {/foreach}

</ul>
