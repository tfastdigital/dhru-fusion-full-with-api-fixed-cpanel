{if !$loggedin}
    {if $currencies_arry}
        <li class="nav-item nav-item-curlang dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">    {$currencytop.prefix} {$currencytop.suffix}  <i class="fal fa-chevron-down"></i></a>
            <div class="dropdown-menu   currency ">
                {foreach from=$currencies_arry key=k item=lop}
                    <a class="dropdown-item" href="#" onclick="javascript: setCurrencyTo({$lop.id});" > {if $lop.prefix} {$lop.prefix} {$lop.suffix} {else} {$lop.code} {/if} </a>
                {/foreach}
            </div>
        </li>
    {/if}
    {if $countrylanguage}
        <li class="nav-item  nav-item-curlang  dropdown">
            <a class="nav-link   dropdown-toggle" data-toggle="dropdown" href="#"> <span class="flag flag-{if !$smarty.get.lcode}gb{else}{$smarty.get.lcode|@strtolower}{/if}"></span>  {$currentlan}  <i class="fal fa-chevron-down"></i></a>
            <div class="dropdown-menu dropdown-menu-right   language">
                {foreach from=$countrylanguage key=k item=lop}
                    <a class="dropdown-item" href="?selectlanguage={$k}&amp;lcode={$lop}"> <span class="mr-3 flag flag-{$lop|@strtolower}"></span>  {$k}</a>
                {/foreach}
            </div>
        </li>
    {/if}
{/if}
