{if $loggedin}
    {assign var=theme value=$userdetails.themesettings|json_decode:1}

    <li class="nav-item dropdown">

        <a  data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">
            <i class="fal fa-cog"></i>
        </a>

        <div class="dropdown-menu  dropdown-menu-right">

            <div>

                {if $template eq 'default' || $template eq 'default2' || $template eq 'default3' || $template eq 'default4' || $template eq 'default5' || $template eq 'default6'}

                <h6>{$lang.thememode}</h6>
                <div class="d-flex w-100 justify-content-center">
                    <div>
                        <div class="border rounded {if $theme.mode eq 'light'} active {/if}  thememode p-2 m-1"  data-value="light">
                            <img src="templates/default/images/light.png" style="min-width:150px">
                        </div>
                    </div>

                    <div>
                        <div class="border rounded  {if $theme.mode eq 'dark'} active {/if}  thememode p-2 m-1"  data-value="dark">
                            <img src="templates/default/images/dark.png"  style="min-width:150px">
                        </div>
                    </div>
                </div>

                    <h6 class="dropdown-divider"></h6>

                {/if}



                {if !$eCommerce}


                    <h6>{$lang.orderstyle}</h6>
                    <div class="d-flex w-100 justify-content-center">

                        <div class="border rounded  {if $theme.orderstyle eq '1'} active {/if}  ordertheme p-2 m-1" data-value="1">
                            <img src="templates/default/images/style1.png"  style="min-width:100px">
                        </div>
                        <div class="border rounded {if $theme.orderstyle eq '2'} active {/if}  ordertheme p-2  m-1"   data-value="2">
                            <img src="templates/default/images/style2.png"  style="min-width:100px">
                        </div>
                        <div class="border rounded {if $theme.orderstyle eq '3'} active {/if}  ordertheme p-2  m-1"   data-value="3">
                            <img src="templates/default/images/style3.png"  style="min-width:100px">
                        </div>
                    </div>
                {/if}
            </div>

        </div>
    </li>
{/if}
