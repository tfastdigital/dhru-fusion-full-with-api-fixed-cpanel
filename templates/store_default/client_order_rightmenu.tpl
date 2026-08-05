<div class="span3 sidebar">
<ul class="nav nav-list">
    <li class="nav-header"> {$lang.order} {$lang.detail} </li> 
    {if $userdetails.access.imeiservice}
    	<li {if $currentsubmenu eq 'imei' || $currentsubmenu eq ''} class="active"{/if} ><a href="{$site_address}imei/placeorder.html" >{$lang.imeiservice}</a></li>
    {/if}
    {if $userdetails.access.fileservice}
    	<li {if $currentsubmenu eq 'file'} class="active"{/if} ><a href="{$site_address}file/placeorder.html">{$lang.fileservice}</a></li>
    {/if}
    {if $userdetails.access.serverlogservice}
    	<li {if $currentsubmenu eq 'server'} class="active"{/if} ><a href="{$site_address}server/placeorder.html">{$lang.serverservice}</a></li>
    {/if}
  </ul>