<!DOCTYPE html>
<!--[if lt IE 10]> <html  lang="en" class="iex"> <![endif]-->
<!--[if (gt IE 10)|!(IE)]><!-->
<html lang="en" class="no-js js">
<!--<![endif]-->
<head>

    {include file="templates/default/chunks/header-head.tpl"}

    {assign var=unique_id value=10|mt_rand:20000}

    {if $loggedin}
        {assign var=theme value=$userdetails.themesettings|json_decode:1}
    {/if}

    <link rel="stylesheet" href="templates/{$template}/css/custom.css?{$catchver}{$unique_id}" />

    {if $theme.mode eq 'dark'}
        <link rel="stylesheet" href="templates/default/css/themes/dark.css?{$catchver}{$unique_id}" />
    {elseif $themecolor eq 'default'}
        <link rel="stylesheet" href="templates/default/css/themes/theme2.css?{$catchver}{$unique_id}" />
    {else}
        <link rel="stylesheet" href="templates/default/css/themes/{$themecolor}.css?{$catchver}{$unique_id}" />
    {/if}


    {$extrahtmlcode}

</head>




<body  class="svg-white {$template} tpl-{$tpl}  page-{if $page}{$page}{else}index{/if}  {if $cart}cart{else}no-cart{/if}"">

{$livehelp_code}


{include file="templates/default/chunks/pre-loader.tpl"}
{include file="templates/default/chunks/loader.tpl"}


<header class="header-bottom">
    <div class="page-width">

        <fragment>
            {function name=afterloginmenu}

                <li class="nav-item dropdown d-block d-lg-none">
                    <a  class="nav-link d-block d-lg-none dropdown-toggle" href="#"> {$lang.products}  <i class="fal fa-chevron-down"></i></a>
                    {$listproducts}
                </li>

                {include file="templates/default/chunks/menu-reseller.tpl"}

                {include file="templates/default/chunks/menu-profile.tpl"}

            {/function}

            {function name=beforeloginmenu}

                <li class="nav-item">
                    <div class="d-none d-lg-flex align-items-center">
                        <a  class="nav-link"    data-keyboard="true"   data-toggle="modal" data-target="#login" href="#">
                            <span class="lg-icon">
                                <i class="fas fa-lock"></i>
                            </span> {$lang.login}
                        </a>
                    </div>
                </li>
            {/function}

        </fragment>
        <div class="header-middle position-relative">
        <div class="container">
            <nav class="navbar-expand-lg navbar-xl p-lg-0">
                <button class="navbar-toggler" type="button" data-toggle="modal" data-target="#navbarToggler1" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fal fa-bars"></i>
                </button>
                <a class="navbar-brand mr-auto" href="#">{if $logo} <img src="{$logo}"   />  {else}  {$companyname}  {/if}</a>

                {if $adds.1 && $resellerstore}
                    <div style="max-width: 500px;margin: auto">{$adds.1}</div>
                {/if}

                <div class="d-none d-lg-block">

                    <nav class="nav navbar-light">

                        <li class="mr-auto">   </li>
                        {include file="templates/default/chunks/currency-language.tpl"}
                        {include file="templates/default/chunks/theme-settings.tpl"}
                    </nav>


                    <ul class="navbar-nav navbar-mastermenu">

                        {include file="templates/default/chunks/menu-master.tpl"}

                        {if $loggedin}
                            {call name=afterloginmenu}
                        {else}
                            {call name=beforeloginmenu}
                        {/if}

                        {if $cart}
                            <li class="nav-item cartminiview">  </li>
                        {/if}

                    </ul>
                </div>



            </nav>
        </div>
    </div>
    </div>

    <div class="page-width header-cart">
        <div class="gradiant">
            {include file="templates/default/chunks/menu-cart.tpl"}
        </div>
    </div>
</header>





<div class="bg-white page-width">

    <div>
    <div class="w-100  min-height">
                {if !$currentpage|in_array:['index']}

                    <div class="container">
                        <ul class="breadcrumb">
                            {if $nav} <i class="fal fa-home"></i>  {$nav} {else} <br/> {/if}
                        </ul>
                    </div>

                    <div class="container">
                        <h2 class="page-title">
                            {$pagetitle}
                        </h2>
                    </div>

                {/if}
