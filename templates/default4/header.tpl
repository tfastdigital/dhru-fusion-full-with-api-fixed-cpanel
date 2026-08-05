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
        <link rel="stylesheet" href="templates/default/css/themes/theme15.css?{$catchver}{$unique_id}" />
    {else}
        <link rel="stylesheet" href="templates/default/css/themes/{$themecolor}.css?{$catchver}{$unique_id}" />
    {/if}

    {$extrahtmlcode}


</head>




<body  class="svg-white tpl-{$tpl}  page-{if $page}{$page}{else}index{/if}  {$template} {if $cart}cart{else}no-cart{/if}">

{$livehelp_code}


{include file="templates/default/chunks/pre-loader.tpl"}
{include file="templates/default/chunks/loader.tpl"}



<header class="header-fixed header-bottom">

    <div class="header-top   d-none d-lg-block">
        <div class="container">
            <nav class="navbar-expand-lg">
                <ul class="navbar-nav">

                <a class="navbar-brand mr-auto " href="#">{if $logo} <img src="{$logo}"   />  {else}  {$companyname}  {/if}</a>

                    {include file="templates/default/chunks/currency-language.tpl"}


                    <div class="d-none d-lg-block">
                        <ul class="navbar-nav navbar-mastermenu">
                            {include file="templates/default/chunks/menu-master.tpl"}
                            {if $loggedin}
                                {call name=afterloginmenu}
                            {else}
                                {call name=beforeloginmenu}
                            {/if}
                        </ul>
                    </div>


                    {if $cart}
                        <li class="nav-item cartminiview">  </li>
                    {/if}

                    {include file="templates/default/chunks/theme-settings.tpl"}


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

            <li class="nav-item bg-transparent">
                <div class="d-none d-lg-flex align-items-center">
                    <a  class="nav-link btn bg-secondary py-1 mx-3"  style="color:white !important;"  data-keyboard="true"   data-toggle="modal" data-target="#login" href="#">
                        <span class="lg-icon">
                            <i class="fas fa-lock"></i>
                        </span> {$lang.login}
                    </a>
                </div>
            </li>
        {/function}

    </fragment>

    <div class="position-relative">
        <div class="" style="border-top: #ffffff14 solid 1px;">
            {include file="templates/default/chunks/menu-cart.tpl"}
        </div>
    </div>



</header>



<div>

    <div class="">



        <div class="w-100  min-height bg-light   ">



            {if !$currentpage|in_array:['index']}

                <div  class="bg-white   mb-4" style="border-bottom: #e5e5e5 solid 1px;">

                    <div class="container">
                        <h2 class="page-title mb-0 pt-3">
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

            <div class="page-content">


