{if $resellerstore}

    {if $loggedin}

        {foreach from=$mastermenucateArr key=k item=lop}
            {if $lop.display eq 1 &&  $lop.afterloginshow eq 1 && $lop.locked eq 0}
                <li class="nav-item {if $lop.sub|@count>0} dropdown {/if}">
                    <a class="nav-link {if $lop.sub|@count>0}dropdown-toggle{/if}" {if $lop.sub|@count>0}  data-toggle="dropdown" {/if}
                            {if $lop.newwindow eq 1} target="_blank" {/if} href="{$lop.seolink}">{$lop.name}
                            {if $lop.sub|@count>0}<i class="fal fa-chevron-down"></i>{/if}
                    </a>
                    {if $lop.sub|@count>0}
                        <div class="dropdown-menu">
                            {foreach from=$lop.sub key=k1 item=lop2}
                                <a class="dropdown-item"  {if $lop2.newwindow eq 1} target="_blank" {/if} href="{$lop2.seolink}">{$lop2.name} </a>
                            {/foreach}
                        </div>
                    {/if}
                </li>
            {/if}
        {/foreach}

    {else}

        {foreach from=$mastermenucateArr key=k item=lop}
            {if $lop.display eq 1 && $lop.req_login eq 0  && $lop.locked eq 0}
                <li class="nav-item {if $lop.sub|@count>0} dropdown {/if}">
                    <a class="nav-link {if $lop.sub|@count>0}dropdown-toggle{/if}" {if $lop.sub|@count>0}  data-toggle="dropdown" {/if}
                            {if $lop.newwindow eq 1} target="_blank" {/if} href="{$lop.seolink}">{$lop.name}
                            {if $lop.sub|@count>0}<i class="fal fa-chevron-down"></i>{/if}
                    </a>
                    {if $lop.sub|@count>0}
                        <div class="dropdown-menu">
                            {foreach from=$lop.sub key=k1 item=lop2}
                                <a class="dropdown-item"  {if $lop2.newwindow eq 1} target="_blank" {/if} href="{$lop2.seolink}">  {$lop2.name} </a>
                            {/foreach}
                        </div>
                    {/if}
                </li>
            {/if}
        {/foreach}

    {/if}

{else}

    {foreach from=$storenavigation key=k item=lop}
        <li class="nav-item"><a class="nav-link"  href="/{$lop.urlname}.html">{$lop.title} </a> </li>
    {/foreach}

{/if}

