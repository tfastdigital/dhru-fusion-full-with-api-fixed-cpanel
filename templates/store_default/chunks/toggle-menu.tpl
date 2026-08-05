
<div class="modal hide modal-menu" tabindex="-1" id="navbarToggler1" role="dialog">
    <div class="modal-dialog d-flex h-100" role="document">
        <div class="modal-content h-100 rounded-0">

            <div class="modal-header d-block p-2">
                <div class="d-flex w-100   justify-content-start align-items-center">

                    {if $userdetails.email}
                        <a href="" data-dismiss="modal" style="font-size: 20px;padding: 10px;color:white"> <i class="fal fa-arrow-left"></i> </a>
                        <div>
                            <img src="https://secure.gravatar.com/avatar/{$userdetails.email|md5}?s=50&d=identicon"/>
                        </div>
                        <div>
                            <strong> {$userdetails.firstname}  {$userdetails.lastname}</strong>
                            {if $clientgroup}
                            <a  href="{$groupmobilelink}" data-whatever="{$lang.priceslot}" data-toggle="modal"
                                data-target="#modal-ajax">({$clientgroup})</a>
                            {/if}<br/>
                            <span> {$userdetails.email}</span>
                        </div>
                    {else}

                        <div class="w-100">
                            <h3 class="py-3"><a href="" data-dismiss="modal" style="font-size: 20px;padding: 10px;color:white"> <i class="fal fa-arrow-left"></i> </a> <span class="navbar-brand p-0"> {$companyname} </span></h3>
                            <div class="d-flex w-100">
                                {if $registration_type neq 3}
                                    <a class="nav-link  flex-grow-1  text-white  nav-registration   border-0"    href="register"> {$lang.registration}</a>
                                {/if}
                                <a  class="nav-link   flex-grow-1  nav-login    border-0"  data-dismiss="modal"  data-keyboard="true"   data-toggle="modal" data-target="#login" href="#"> {$lang.login} </a>
                            </div>
                        </div>

                    {/if}

                </div>
            </div>

            <div class="modal-body overflow-auto h-100 p-0">

                <ul>

                    {if $loggedin}
                        {include file="templates/default/chunks/menu-master.tpl"}

                        {call name=afterloginmenu}
                    {else}
                        {if $cart}
                            <li class="nav-item dropdown">
                                <a  class="nav-link d-block d-lg-none dropdown-toggle" href="#"> Products <i class="fal fa-chevron-down"></i></a>
                                {$listproducts}
                            </li>
                            {if $retailmenu && !$eCommerce}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#mastergroups">
                                        {$lang.retail} {$lang.service}
                                        <i class="fal fa-chevron-down"></i>
                                    </a>
                                    <div class="dropdown-menu collapse">
                                        {if  $imeicatlog}<a  class="dropdown-item"  href="{$cartimeilink}">{$lang.imei}</a>{/if}
                                        {if $defserver eq 1 && $servercatlog}<a  class="dropdown-item"  href="{$cartserverlink}">{$lang.server}</a>{/if}
                                        {if $defremote eq 1 && $remotecatlog}<a  class="dropdown-item"  href="{$cartremotelink}">{$lang.remote}</a>{/if}
                                    </div>
                                </li>
                            {/if}
                        {/if}

                        {include file="templates/default/chunks/menu-master.tpl"}

                        {call name=beforeloginmenu}
                    {/if}

                </ul>

            </div>


        </div>
    </div>
</div>


