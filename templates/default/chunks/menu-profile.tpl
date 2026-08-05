<li class="nav-item dropdown profile">

    <div class=" d-none d-lg-block">
            <div>
                <a   class="nav-link dropdown-toggle" href="{$profilelink}">
                    <div class="d-flex justify-content-between align-items-center">

                        <div class="lg-icon avatar-icon d-lg-none d-xl-block m-0">
                            <span class="avatar-img"> <img src="https://secure.gravatar.com/avatar/{$userdetails.email|md5}?s=25&d=identicon" /> </span>
                        </div>

                        <div style="line-height: 1.2rem">

                            {$userdetails.firstname}  {$userdetails.lastname}
                            {if $clientgroup}
                                <span>({$clientgroup})</span>
                            {/if} <i class="fal fa-chevron-down"></i>
                            {if  $addfund && ($resellerstore || $userdetails.usertype eq 0)}
                                 <div class="user-balance text-{if $userdetails.credit.credit < 100}danger{else}success{/if}"> <small>{$userdetails.currency.prefix} {$userdetails.credit.credit|string_format:"%.2f"} <span id="ccredit" style="display: none;" class="d-none">{if $userdetails.allowoverdrive}{($userdetails.overdrive+$userdetails.credit.credit)|string_format:"%.2f"}{else}{$userdetails.credit.credit|string_format:"%.2f"}{/if}</span> </small>  </div>
                            {/if}
                        </div>


                    </div>
                </a>
            </div>
    </div>

    <a  class="nav-link d-block d-lg-none dropdown-toggle" href="#"> {$lang.myaccount} <i class="fal fa-chevron-down"></i></a>

    <div class="dropdown-menu  dropdown-menu-right  my-account">

        <a class="dropdown-item" href="{$profilelink}">{$lang.myprofile}</a>

        {if $addfund}
            {if $resellerstore}
                <a  href="{$addfundslink}" class="dropdown-item"> {$lang.addfund}  </a>
            {/if}
        {/if}


        {if $userdetails.apiaccesskey && !$eCommerce}
            <a class="dropdown-item" href="{$apilink}">{$lang.apiaccess}</a>
        {/if}
        <a class="dropdown-item" href="{$invoicelink}">{$lang.myinvoice}</a>
        <a class="dropdown-item" href="{$maillink}">{$lang.mymail}</a>
        <a class="dropdown-item" href="{$statementlink}">{$lang.my} {$lang.statement}</a>
        {if $userdetails.access.credit_transfer eq '1' && !$eCommerce}
            <a class="dropdown-item" href="{$transferlink}">{$lang.crtransfer}</a>
        {/if}

        {if $userdetails.usertype neq '3' && $voucher eq '1' && $userdetails.rechargeblock neq '1' }
            <a class="dropdown-item" href="{$voucherlink}">{$lang.recharge} {$lang.voucher}</a>
        {/if}
        {if !$eCommerce}
            <a class="dropdown-item" href="{$mailnotificationlink}">{$lang.email} {$lang.preference}</a>
        {/if}

        {if $ticketservice && $resellerstore}
            <a class="dropdown-item" href="{$ticketlink}">{$lang.mytickets}</a>
        {/if}


        {if $resellerstore && !$eCommerce}
            <a class="dropdown-item" href="{$myservicelink}">{$lang.service} {$lang.status}</a>
        {/if}
        {if $affiliate && $configaffiliate}
            {*<a class="dropdown-item" href="settings/affiliate">{$lang.affiliate} {$lang.system}</a>*}
        {/if}

        {if $withdrawal_req and $resellerstore && !$eCommerce}
            <a class="dropdown-item" href="{$withdrawallink}">{$lang.withdrawal} {$lang.request}</a>
        {/if}
        {if $userdetails.customize_email eq 1 && !$eCommerce}
            <a class="dropdown-item" href="{$customizelink}" >{$lang.customize} {$lang.email}</a>
        {/if}
        {if $userdetails.usertype neq '3' and  $resellerstore and $cart}
            <a class="dropdown-item" href="{$subscriptionlink}" >{$lang.subscription}</a>
        {/if}
        {if $defreward}
            <a class="dropdown-item" href="{$rewardlink}" >{$lang.pointstatement}</a>
        {/if}
        {if $giftcerti and $resellerstore}
            <a class="dropdown-item" href="{$giftlink}">{$lang.giftcerti}</a>
        {/if}
        {if $creditcards && !$ccdetails}
            <a class="dropdown-item" href="{$ccardlink}">{$lang.create} {$lang.creditcard}</a>
        {/if}
        {if $installapp}
            <a class="dropdown-item" href="{$appslink}">{$lang.installapp}</a>
        {/if}
        {if $idverification}
            <a class="dropdown-item" href="{$idverificationlink}">{$lang.ID} {$lang.verification}</a>
        {/if}



        <h6 class="dropdown-divider"></h6>


        <a class="dropdown-item" data-toggle="modal" data-target="#modal-ajax" data-whatever="{$lang.loginlog}"
           data-size="modal-md" href="{$lastloginlink}">
            <span>{$lang.lastlogin}</span>
            <br/>
            <small class="text-muted">
                {$userdetails.lastlogin|date_format:'%D, %I:%M %p'} <br/>
                {$lang.ip} : {$userdetails.lastloginip}
            </small>
        </a>

        <a class="dropdown-item text-danger"  href="{$logoutlink}">{$lang.logout}</a>



    </div>
</li>
