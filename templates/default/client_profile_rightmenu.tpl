<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 sidebar d-none">
<ul class="list-group">

            <li class="list-group-item {if  $currentsubmenu eq 'profile'} active{/if}" ><a href="settings/profile">{$lang.editprofile}</a> </li>

            <li class="list-group-item {if  $currentsubmenu eq 'password'} active{/if}" ><a href="settings/password">{$lang.changepassw}</a> </li>
           {if !$eCommerce}
            <li class="list-group-item {if  $currentsubmenu eq 'pin'} active{/if}" ><a href="settings/pin">{$lang.masterpin}</a> </li>
           {/if}
            <li class="list-group-item {if  $currentsubmenu eq 'question'} active{/if}" ><a href="settings/question">{$lang.changeque}</a> </li>
            {if $creditcards && !$ccdetails}
                <li class="list-group-item {if  $currentsubmenu eq 'ccard'} active{/if}" ><a href="settings/ccard">{$lang.creditcard}</a> </li>
            {/if}
             {if !$eCommerce}
            <li class="list-group-item {if  $currentsubmenu eq 'mailnotification'} active{/if}" ><a href="settings/mailnotification">{$lang.email} {$lang.performance}</a> </li>
            {/if}
             {if $userdetails.customize_email eq 1 && !$eCommerce}
                <li class="list-group-item {if  $currentsubmenu eq 'customize'} active{/if}"><a href="settings/customize" >{$lang.customize} {$lang.email}</a> </li>
            {/if}


    <li class="list-group-item {if  $currentsubmenu eq 'logins'} active{/if}" ><a href="settings/logins">{$lang.loginsecur}</a> </li>
    {if $userdetails.apiaccesskey &&  !$eCommerce}
    	<li class="list-group-item {if  $currentsubmenu eq 'api'} active{/if}" ><a href="settings/api">{$lang.apiaccess}</a> </li>
    {/if}
    <li class="list-group-item {if  $currentsubmenu eq 'invoice'} active{/if}" ><a href="settings/invoice">{$lang.myinvoice}</a> </li>
    <li class="list-group-item {if  $currentsubmenu eq 'mail'} active{/if}" ><a href="settings/mail">{$lang.mymail}</a> </li>
    <li class="list-group-item {if  $currentsubmenu eq 'statement'} active{/if}" ><a href="settings/statement">{$lang.statement}</a> </li>
{if $userdetails.access.credit_transfer eq '1' &&  !$eCommerce}
    <li class="list-group-item {if  $currentsubmenu eq 'transfer'} active{/if}" ><a href="settings/transfer">{$lang.crtransfer}</a> </li>
{/if}

{if $userdetails.usertype neq '3' && $voucher eq '1'
    && $userdetails.rechargeblock neq '1' && !$eCommerce}
	<li class="list-group-item {if  $currentsubmenu eq 'voucher'} active{/if}" ><a href="settings/voucher">{$lang.recharge} {$lang.voucher}</a> </li>
{/if}

{if $ticketservice && $resellerstore}
    <li class="list-group-item {if  $currentsubmenu eq 'ticket'} active{/if}" ><a href="settings/ticket">{$lang.mytickets}</a> </li>
    <li  class="list-group-item" ><a href="support">{$lang.submit} {$lang.ticket}</a></li>
{/if}

{if $cart}
    <li class="list-group-item {if  $currentsubmenu eq 'myorder'} active{/if}" ><a href="ordershopping/myorder">{$lang.my} {$lang.orders}</a> </li>
{/if}

{if $resellerstore && !$eCommerce}
    <li class="list-group-item {if  $currentsubmenu eq 'myservice'} active{/if}" ><a href="settings/myservice">{$lang.service} {$lang.status}</a> </li>
{/if}

{if $affiliate && $configaffiliate}
    <li class="list-group-item {if  $currentsubmenu eq 'affiliate'} active{/if}" ><a href="settings/affiliate">{$lang.affiliate} {$lang.system}</a> </li>
{/if}

{if $withdrawal_req and $resellerstore && !$eCommerce}
    <li class="list-group-item {if  $currentsubmenu eq 'withdrawal'} active{/if}" ><a href="settings/withdrawal">{$lang.withdrawal} {$lang.request}</a> </li>
{/if}

{if $userdetails.usertype neq '3' and  $resellerstore and $cart && !$eCommerce}
    <li class="list-group-item {if  $currentsubmenu eq 'subscription'} active{/if}" ><a href="settings/subscription" >{$lang.subscription}</a> </li>
{/if}

{if $giftcerti and $resellerstore}
    <li class="list-group-item {if  $currentsubmenu eq 'gift'} active{/if}" ><a href="settings/gift">{$lang.create} {$lang.giftcerti}</a> </li>
{/if}

{if $installapp && !$eCommerce}
    <li class="list-group-item {if  $currentsubmenu eq 'apps'} active{/if}" ><a href="settings/apps">{$lang.installapp}</a> </li>
{/if}
</ul>
</div>
