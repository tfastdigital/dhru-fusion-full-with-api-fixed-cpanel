
<div class="span3 sidebar">
<ul class="nav nav-list">
  <li class="nav-header"> {$lang.quicksignupusing} </li>
  {if $registration_type neq 3}
    {if $allow_mygsm}
    	<li><a href="loginoption.php?action=mygsmid">
            <img src="templates/default/images/mygsmid.jpg" border="0" /></a>
        </li>
    {/if}
    {if $allow_google && $googleclientid}
    	<li>
               <img src="templates/default/images/google.png"  style="cursor:pointer;"
               onclick="javascript: location.href='/loginoption.php?action=googlep';"
               border="0" />
        </li>
    {/if}
    {if $allow_yahoo}
    	<li><a href="loginoption.php?action=yahoo">
        <img src="templates/default/images/yahoo.png" border="0" /></a></li>
    {/if}
    {if $allow_facebook}
    	<li><a href="loginoption.php?action=facebook">
        <img src="templates/default/images/facebook.png" border="0" /></a></li>
    {/if}

  {/if}
 </ul>
