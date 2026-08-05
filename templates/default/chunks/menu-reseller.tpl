{if $userdetails.usertype eq '1' || $advancesr gt 0}
    {if !$eCommerce}
        <li class="nav-item dropdown mr-auto">
            <a  class="nav-link  dropdown-toggle  {if $navselect eq 'reseller'} active {/if}" href="#"> {$lang.reseller} <i class="fal fa-chevron-down"></i></a>
            <div class="dropdown-menu my-account">
                {if $userdetails.reseller_can_setupstore eq '1' && $storesetup eq '1'}
                    <h6 class="dropdown-header"> {$lang.store} {$lang.setting}</h6>
                    <a class="dropdown-item" href="{$storesummarylink}">{$lang.store} {$lang.overview}</a>
                    <a class="dropdown-item" href="{$storelink}">{$lang.mysite}</a>
                    <a class="dropdown-item" href="{$emailsettinglink}" >{$lang.email} {$lang.settings}</a>
                    <a class="dropdown-item" href="{$indexcontentlink}">{$lang.cms}</a>
                    <a class="dropdown-item" href="{$profitlink}">{$lang.profit}</a>
                    {if $cartforstore}
                        <a class="dropdown-item" href="{$storesummarylink}">{$lang.retail} {$lang.selling}</a>
                    {/if}
                    <a class="dropdown-item" href="{$setpricelink}">{$lang.set} {$lang.pricing}</a>
                    <a class="dropdown-item" href="{$myorderslink}">{$lang.earnings} {$lang.from} {$lang.retail} {$lang.selling}</a>
                    <a class="dropdown-item" href="{$myuserorderslink}">{$lang.my} {$lang.user}s {$lang.orders}</a>
                    {if $storepaypal}
                        <a class="dropdown-item" href="{$fundsummarylink}">{$lang.user} {$lang.fundssummary}</a>
                    {/if}
                    <a class="dropdown-item" href="{$rstatementlink}">{$lang.my} {$lang.statement}</a>
                {/if}
                <h6 class="dropdown-header">{$lang.advance} {$lang.resellingsystem}</h6>
                <a class="dropdown-item" href="{$adduserlink}">{$lang.adduser}</a>
                <a class="dropdown-item" href="{$myuserlink}">{$lang.myuser}</a>
                {if $userdetails.access.credit_transfer eq '1'}
                    <h6 class="dropdown-header">{$lang.regular} {$lang.resellingsystem}</h6>
                    <a class="dropdown-item" href="{$transfersublink}">{$lang.crtransfer}</a>
                    <a class="dropdown-item" href="{$mysubuserlink}">{$lang.myuser}</a>
                {/if}
            </div>
        </li>
    {/if}
{/if}
