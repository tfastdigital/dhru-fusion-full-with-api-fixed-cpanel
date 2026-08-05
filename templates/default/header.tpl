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

    {if $theme.mode eq 'dark'}
        <link rel="stylesheet" href="templates/default/css/themes/dark.css?{$catchver}{$unique_id}" />
    {elseif $themecolor eq 'default'}
        <link rel="stylesheet" href="templates/default/css/themes/theme8.css?{$catchver}{$unique_id}" />
    {else}
        <link rel="stylesheet" href="templates/default/css/themes/{$themecolor}.css?{$catchver}{$unique_id}" />
    {/if}

    <link rel="stylesheet" href="templates/default/css/gsm-style.css?v={$unique_id}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    {$extrahtmlcode}

</head>

<body  class="gsm-theme {$template} tpl-{$tpl} page-{if $page}{$page}{else}index{/if} {if $cart}cart{else}no-cart{/if}">
 
{$livehelp_code}

{$svgbg}

{include file="templates/default/chunks/pre-loader.tpl"}
{include file="templates/default/chunks/loader.tpl"}

<!-- Define Menu Functions (Hidden but available) -->
<div style="display:none">
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
                <div class="d-none d-lg-flex align-items-center  pl-3">
                    <a  class="nav-link   btn p-2 px-3  bg-secondary"    data-keyboard="true"   data-toggle="modal" data-target="#login" href="#">
                        <span class="lg-icon">
                            <i class="fas fa-lock"></i>
                        </span> {$lang.login}
                    </a>
                </div>
            </li>
        {/function}
    </fragment>
</div>

<div class="d-flex-wrapper">
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="brand-logo">
            {if $logo} <img src="{$logo}" style="max-height: 40px;" /> {else} <span style="color:white">GSM PANEL</span> {/if}
        </div>
        <ul class="sidebar-menu">
             <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
             </li>
             {include file="templates/default/chunks/menu-master.tpl"}
             
             {if $loggedin}
                 <!-- Additional Logged In Menu Items if needed -->
             {/if}
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content w-100">
        <!-- Top Header -->
        <header class="top-header">
             <div class="d-flex align-items-center">
                 <button class="btn btn-link d-lg-none mr-3" onclick="$('.sidebar').toggleClass('active')">
                    <i class="fas fa-bars"></i>
                 </button>
                 <h4 class="mb-0" style="color: var(--text-main)">{$pagetitle|default:'Dashboard'}</h4>
             </div>
             
             <div class="d-flex align-items-center">
                {include file="templates/default/chunks/currency-language.tpl"}
                
                {if $loggedin}
                    <div class="dropdown ml-3">
                        <a href="#" class="text-white dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-user-circle fa-lg mr-1"></i> {$userdetails.firstname}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="client_profile">Profile</a>
                            <a class="dropdown-item" href="logout">Logout</a>
                        </div>
                    </div>
                {else}
                     <a  class="btn btn-primary ml-3" data-keyboard="true" data-toggle="modal" data-target="#login" href="#">
                        {$lang.login}
                    </a>
                {/if}
             </div>
        </header>

        {include file="templates/default/chunks/toggle-menu.tpl"}

        <div class="container-fluid">
            {if !$currentpage|in_array:['index']}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-4">
                         {if $nav} <li class="breadcrumb-item text-muted">{$nav}</li> {/if}
                    </ol>
                </nav>
            {/if}

            <div>
