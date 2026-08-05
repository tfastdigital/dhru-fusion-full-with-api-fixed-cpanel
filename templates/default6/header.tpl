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
        <link rel="stylesheet" href="templates/default/css/themes/theme18.css?{$catchver}{$unique_id}" />
    {else}
        <link rel="stylesheet" href="templates/default/css/themes/{$themecolor}.css?{$catchver}{$unique_id}" />
    {/if}

    {$extrahtmlcode}


</head>




<body  class="svg-white tpl-{$tpl}  {$template} page-{if $page}{$page}{else}index{/if}  {if $cart}cart{else}no-cart{/if}">

{$livehelp_code}


{include file="templates/default/chunks/pre-loader.tpl"}
{include file="templates/default/chunks/loader.tpl"}


<header class="header header-fixed header-bottom">

    <div class="header-top   d-none d-lg-block">
        <div class="container">
            <nav class="navbar-expand-lg py-2">
                <ul class="navbar-nav navbar-mastermenu">

                <a class="navbar-brand mr-auto " href="#">{if $logo} <img src="{$logo}"   />  {else}  {$companyname}  {/if}</a>

                    {include file="templates/default/chunks/currency-language.tpl"}
                    {if !$loggedin}
                        {include file="templates/default/chunks/menu-master.tpl"}
                    {/if}
                    {call name=beforeloginmenu}


                    {include file="templates/default/chunks/theme-settings.tpl"}

                    {if $cart}
                        <li class="nav-item cartminiview">  </li>
                    {/if}

                </ul>
            </nav>
        </div>
    </div>

    <div class="header-middle d-none d-lg-block">

        <div class="container">
            <nav class="navbar-expand-lg">
                <ul class="navbar-nav navbar-mastermenu">
                    {if $loggedin}
                        {include file="templates/default/chunks/menu-master.tpl"}
                        {call name=afterloginmenu}
                    {/if}
                </ul>
            </nav>
        </div>

    </div>

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
            {if !$loggedin}
                <li class="nav-item">
                <div class="d-none d-lg-flex align-items-center">
                    <a  class="nav-link"    data-keyboard="true"   data-toggle="modal" data-target="#login" href="#">
                        {$lang.login}
                    </a>
                </div>
            </li>
            {/if}
        {/function}

    </fragment>

    <div class="position-relative">
        <div>
            {include file="templates/default/chunks/menu-cart.tpl"}
        </div>
    </div>

</header>


<div class="bg-secondary header-bottom-bg p-0" style="height: 3px"></div>

<div>

    <div class="">



        <div class="w-100  min-height">



            {if !$currentpage|in_array:['index']}

                <div>
                    <div class="container">
                        <h2 class="page-title pb-0 mb-0 mt-1">
                            {$pagetitle}
                        </h2>
                    </div>
                    <div class="container">
                        <ul class="breadcrumb">
                            {if $nav} <i class="fal fa-home"></i>  {$nav} {else} <br/> {/if}
                        </ul>
                    </div>

                </div>

            {/if}

            <div class="bg-white  page-content">
