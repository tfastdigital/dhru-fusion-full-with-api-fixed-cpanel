{include file="templates/default/productlist.tpl"}

<div class="container"><div class="page-container">
        {if  $service eq 'imei'}
            <h2 class="page-title inner-page-title">{$lang.imei} {$lang.services}</h2>
            <div class="row">
                {foreach from=$imeicatlog key=id item=name name=foo}
                    {call name=grouplist data=$name service='imei'}
                {/foreach}
            </div>
        {/if}

        {if  $service eq 'server'}
            <h2 class="page-title  inner-page-title">{$lang.server} {$lang.services}</h2>
            <div class="row">
                {foreach from=$servercatlog key=id item=name name=foo}
                    {call name=grouplist data=$name service='server'}
                {/foreach}
            </div>
        {/if}


        {if  $service eq 'remote'}
            <h2 class="page-title inner-page-title">{$lang.remote} {$lang.services}</h2>
            <div class="row">
                {foreach from=$remotecatlog key=id item=name name=foo}
                    {call name=grouplist data=$name service='remote'}
                {/foreach}
            </div>
        {/if}
    </div></div>
