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
        <link rel="stylesheet" href="templates/default/css/themes/theme7.css?{$catchver}{$unique_id}" />
    {else}
        <link rel="stylesheet" href="templates/default/css/themes/{$themecolor}.css?{$catchver}{$unique_id}" />
    {/if}

    {$extrahtmlcode}


</head>




<body  class="svg-white tpl-{$tpl}  {$template}  page-{if $page}{$page}{else}index{/if}  {if $page eq 'index'}header-bottom{/if}">

{$livehelp_code}


{include file="templates/default/chunks/pre-loader.tpl"}
{include file="templates/default/chunks/loader.tpl"}

{if $loggedin}
<header class="header header-bottom">

    <div class="header-top   d-none d-lg-block">
        <div class="container">
            <nav class="navbar-expand-lg">
                <ul class="navbar-nav">

                <a class="navbar-brand mr-auto text-white">{if $logo} <img src="{$logo}"   />  {else}  {$companyname}  {/if}</a>




                    <div class="d-none d-lg-block">
                        <ul class="navbar-nav navbar-mastermenu">


                                {call name=afterloginmenu}

                        </ul>
                    </div>

                    {include file="templates/default/chunks/theme-settings.tpl"}

                </ul>
            </nav>
        </div>
    </div>

    <fragment>
        {function name=afterloginmenu}

            {include file="templates/default/chunks/menu-master.tpl"}

            {include file="templates/default/chunks/menu-reseller.tpl"}

            {include file="templates/default/chunks/menu-profile.tpl"}



        {/function}



    </fragment>

</header>

{/if}



        <div class="w-100  min-height">



            {if !$currentpage|in_array:['index']}

                <div  class="bg-gray mb-4 pb-3">


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

                </div>

            {/if}

            <div class="bg-white  page-content">
