
<div class="span3 sidebar service" style="bottom: 10px; display: none; top: 0px; position: fixed; overflow-y: auto; padding: 90px 30px; left: 0px; width: 20%;z-index:9999">

<ul class="nav nav-list">

    {if $defimei eq 1}

                {assign var='l' value='0'}
                {foreach from=$imeiservicelist key=GroupName item=Services}
                    <li><a href="javascript:void(0)" onclick="window.location.hash='g{$l++}'"> {$GroupName} </a></li>
                {/foreach}


    {/if}
    {if $deffile eq 1}

                {assign var='j' value='0'}
                {foreach from=$fileservicelist key=GroupName item=Services}
                    <li><a href="javascript:void(0)" onclick="window.location.hash='g{$j++}'"> {$GroupName} </a></li>
                {/foreach}


    {/if}
    {if $defserver eq 1}
                {assign var='k' value='0'}
                {foreach from=$serverservicelist key=GroupName item=Services}
                    <li><a href="javascript:void(0)" onclick="window.location.hash='g{$k++}'"> {$GroupName} </a></li>
                {/foreach}


    {/if}

 </ul>
