{if $cart}

    <div class="container container-cart-menu">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-none d-lg-block w-100 mr-3 overflow-auto">
                    <nav class="nav navbar-dark navbar-products">



                        {foreach from=$groupdetail key=id item=group}
                            <li class="nav-item {if !empty($group.sub)}dropdown position-static{/if}">
                                <a {if !empty($group.sub)}  {/if} class="nav-link {if !empty($group.sub)}dropdown-toggle{/if}"  href="{$group.seo}">
                                    {$group.name}
                                    {if !empty($group.sub)} <i class="fal fa-chevron-down"></i> {/if}
                                </a>
                                {if !empty($group.sub)}
                                    <div class="dropdown-menu">
                                        <div class="container"><div class="page-container">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="row h-100">
                                                        {foreach from=$group.sub key=sid item=subgroup name=foo}
                                                            {if $smarty.foreach.foo.index % 10 === 0}
                                                                <div class="col-auto menu-column">
                                                            {/if}
                                                            {if empty($subgroup.sub)}
                                                                <a class="dropdown-item" href="{$subgroup.seo}">{$subgroup.name}</a>
                                                            {/if}
                                                            {if $smarty.foreach.foo.index % 10 === 9 || $smarty.foreach.foo.index + 1 === $group.sub|@count}
                                                                </div>
                                                            {/if}
                                                        {/foreach}


                                                        {foreach from=$group.sub key=sid item=subgroup name=foo}
                                                            {if !empty($subgroup.sub)}
                                                                <div class="col-auto submenu-column">
                                                                    <a class="dropdown-item"  href="{$subgroup.seo}"> <strong>{$subgroup.name} <i class="fal fa-chevron-right"></i> </strong> </a>
                                                                    <div>
                                                                        {foreach from=$subgroup.sub key=sid item=subgroup name=foo}
                                                                            <a class="dropdown-item" href="{$subgroup.seo}">{$subgroup.name}</a>
                                                                        {/foreach}
                                                                    </div>
                                                                </div>
                                                            {/if}
                                                        {/foreach}


                                                    </div>
                                                </div>
                                                <div class="col-auto p-3 p-lg-5 border-left d-none d-lg-block">
                                                    <img src="{$group.image}" class="group-image"/>
                                                </div>
                                            </div>
                                        </div>
                                        </div></div>
                                {/if}
                            </li>
                        {/foreach}

                        {include file="templates/default/chunks/menu-retail.tpl"}

                    </nav>
                </div>


                <ul class="navbar-nav">
                    <li class="nav-item dropdown search-bar position-static ">
                        <span  data-toggle="dropdown" class="nav-link nav-link-search px-3 cursor-pointer">
                            <span><i class="fa fa-search"></i></span>
                        </span>
                        <div class="dropdown-menu onclick  rounded-5">
                            <div class="container"><div class="page-container">
                                <input type="text" class="form-control search-products p-2" autocomplete="off" name="searchvalue" value=""  onfocus="this.value=''"  onkeyup="searchItems(this.value);"   placeholder="{$lang.search}..." id="searchvalue"/>
                                <ul id='searchresult' class="p-0"></ul>
                                </div></div>
                        </div>
                    </li>
                </ul>




            </div>
        </div>
{/if}
