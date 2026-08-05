<div class="span3 sidebar">
<ul class="nav nav-list">

    <li class="nav-header"> {$lang.order} {$lang.detail} </li>
    {if $userdetails.access.imeiservice}
    	<li {if $currentsubmenu eq 'imei'}class="active"{/if} ><a href="orders.php?action=imei&status={$status}" >{$lang.imeiservice}</a></li>
    {/if}
    {if $userdetails.access.fileservice}
    	<li {if $currentsubmenu eq 'file'}class="active"{/if} ><a href="orders.php?action=file&status={$status}">{$lang.fileservice}</a></li>
    {/if}
    {if $userdetails.access.serverlogservice}
    	<li {if $currentsubmenu eq 'server'}class="active"{/if} ><a href="orders.php?action=server&status={$status}">{$lang.serverservice}</a></li>
    {/if}    
    <li  {if $currentpage eq 'export'} class="active"{/if} ><a href="export.php">{$lang.export}</a></li>
  </ul>