<title>{if $seo_pagetitle}{$seo_pagetitle}{else}{$pagetitle}{/if}</title>
<meta charset="{$charset}" />
<meta http-equiv="content-type" content="text/html; charset={$charset}" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="Description" content="{$description}" />
<meta name="keywords" content="{$keywords}" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<script>
    var urlprefix = '';
    {if !$seofriendly}
        urlprefix = './index.php/';
    {/if}
</script>

{if $assiteurl}
    <base href="{$assiteurl}" />
{/if}

<link rel="icon" href="{$faviconicon}">

<link rel="stylesheet" href="templates/default/css/bootstrap.min.css" />
<link rel="stylesheet" href="templates/default/css/chosen.min.css" />

<script src="templates/default/js/jquery-3.2.1.min.js"></script>
<script src="templates/default/js/popper.min.js" ></script>
<script src="templates/default/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="templates/default/js/theme.js?{$catchver}"></script>
<script type="text/javascript" src="includes/js/custom.js?{$catchver}"></script>
<script src="templates/default/js/chosen.jquery.min.js"></script>
<script src="templates/default/js/Chart.bundle.min.js"></script>
<script src="templates/default/js/bootstrap-datepicker.min.js"></script>
<script src="templates/default/js/jquery.lightSlider.min.js"  type="text/javascript"></script>
<script src="templates/default/js/table-cell-selector.js"  type="text/javascript"></script>
<script src="templates/default/js/wow.min.js"  type="text/javascript"></script>
<script type="text/javascript" src="includes/js/imei.js"></script>

<script type="text/javascript" src="templates/default/js/jquery.steps.min.js"></script>

<link type="text/css" rel="stylesheet" href="templates/default/css/lightSlider.css" />
<link rel="stylesheet" href="templates/default/css/bootstrap-datepicker.min.css" />
<link rel="stylesheet" href="templates/default/css/animate.min.css" />
<link href="templates/default/css/typekit-offline.css" rel="stylesheet" />


<link rel="stylesheet" href="templates/default/css/all.css"/>
<link href="includes/icons/menu-icon.css" rel="stylesheet" type="text/css"/>
<link href="includes/icons/flags/flags.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="templates/default/css/theme.css?{$catchver}" />
