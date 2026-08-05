{if $cart && $retailmenu && !$eCommerce}

        {if  $imeicatlog}
            <li  class="nav-item nav-item-retail dropdown position-static">
                <a class="nav-link dropdown-toggle" href="{$cartimeilink}"><span>{$lang.imei} {$lang.services}</span> <i class="fal fa-chevron-down"></i></a>
                <div class="dropdown-menu">
                    <div class="container"><div class="page-container">
                        <div class="row h-100">
                            {foreach from=$imeicatlog key=id item=name2 name=foo}
                                {if $smarty.foreach.foo.index % 10 === 0}
                                    <div class="col-auto menu-column">
                                {/if}
                                <a class="dropdown-item"  href="{$name2.seourl}"><span>{$name2.name}</span></a>
                                {if $smarty.foreach.foo.index % 10 === 9 || $smarty.foreach.foo.index + 1 === $imeicatlog|@count}
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                        </div></div>
                </div>
            </li>
        {/if}

        {if $defserver eq 1 && $servercatlog}
            <li  class="nav-item  nav-item-retail dropdown position-static">
                <a class="nav-link  dropdown-toggle" href="{$cartserverlink}"><span> {$lang.server} {$lang.services}</span> <i class="fal fa-chevron-down"></i></a>
                <div class="dropdown-menu">
                    <div class="container"><div class="page-container">
                        <div class="row h-100">
                            {if $servercatlog}
                                {foreach from=$servercatlog key=id item=name2 name=foo}
                                    {if $smarty.foreach.foo.index % 10 === 0}
                                        <div class="col-auto menu-column">
                                    {/if}
                                    <a  class="dropdown-item"   href="{$name2.seourl}"><span>{$name2.name}</span></a>
                                    {if $smarty.foreach.foo.index % 10 === 9 || $smarty.foreach.foo.index + 1 === $servercatlog|@count}
                                        </div>
                                    {/if}
                                {/foreach}
                            {/if}
                        </div>
                        </div></div>
                </div>
            </li>
        {/if}


        {if $defremote eq 1 && $remotecatlog}
            <li  class="nav-item  nav-item-retail dropdown position-static">
                <a class="nav-link  dropdown-toggle" href="{$cartremotelink}"><span>{$lang.remote} {$lang.services}</span> <i class="fal fa-chevron-down"></i></a>
                <div class="dropdown-menu">
                    <div class="container"><div class="page-container">
                        <div class="row h-100">
                            {if $remotecatlog}
                                {foreach from=$remotecatlog key=id item=name2 name=foo}
                                    {if $smarty.foreach.foo.index % 10 === 0}
                                        <div class="col-auto menu-column">
                                    {/if}
                                    <a  class="dropdown-item"   href="{$name2.seourl}"><span>{$name2.name}</span></a>
                                    {if $smarty.foreach.foo.index % 10 === 9 || $smarty.foreach.foo.index + 1 === $remotecatlog|@count}
                                        </div>
                                    {/if}
                                {/foreach}
                            {/if}
                        </div>
                        </div></div>
                </div>
            </li>
        {/if}

 {/if}

