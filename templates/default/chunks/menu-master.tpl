{foreach from=$mastermenucateArr key=id item=menu}
    {if $menu.locked eq 1 || $resellerstore}
        <li class="nav-item {if !empty($menu.sub)}dropdown{/if} menu-item-{$id}">
            <a  class="nav-link {if !empty($menu.sub)}dropdown-toggle{/if}" {if $menu.newwindow eq 1}target="_blank"{/if}  href="{if $menu.external eq 1}{$menu.link}{else}{$menu.seolink}{/if}">
                {$menu.name}
                {if !empty($menu.sub)} <i class="fal fa-chevron-down"></i> {/if}
            </a>
            {if !empty($menu.sub)}
                <div class="dropdown-menu">
                    {foreach from=$menu.sub key=menuid item=submenu name=foo}
                        <a class="dropdown-item" {if $submenu.newwindow eq 1}target="_blank"{/if}  href="{if $submenu.external eq 1}{$submenu.link}{else}{$submenu.seolink}{/if}">{$submenu.name}</a>
                    {/foreach}
                </div>
            {/if}
        </li>
    {/if}
{/foreach}
