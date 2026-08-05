<div class="span3 sidebar">


       
            {if $userdetails.reseller_can_setupstore eq '1' && $storesetup eq '1'}  
                <ul class="nav nav-list">           
                    <li class="nav-header">  {$lang.store} {$lang.setting}</li>
                     <li {if $currentsubmenu eq 'summary'} class="active"{/if} ><a href="reseller.php?action=summary">{$lang.store} {$lang.overview}</a> </li>
                    <li {if $currentsubmenu eq 'storesettings'} class="active"{/if} ><a href="reseller.php?action=storesettings">{$lang.mysite}</a> </li>
                    <li {if $currentsubmenu eq 'emailsettings'} class="active"{/if} ><a href="reseller.php?action=emailsettings">{$lang.email} {$lang.settings}</a> </li>    
                    <li {if $currentsubmenu eq 'indexcontent'} class="active"{/if} ><a href="reseller.php?action=indexcontent">{$lang.cms}</a> </li>
                    <li {if $currentsubmenu eq 'profit'} class="active"{/if} ><a href="reseller.php?action=profit">Profit</a> </li>               
              
                    {if $cartforstore}         
                        <li {if $currentsubmenu eq 'myproduct'}class="active"{/if} ><a href="reseller.php?action=myproduct">{$lang.retail} {$lang.selling}</a> </li>
                    {/if}        
                    
                    <li {if $currentsubmenu eq 'setpricelist'} class="active"{/if} ><a href="reseller.php?action=setpricelist">Set Pricing</a> </li>
                    {if $eCommerce}
                    <li {if $currentsubmenu eq 'myorders'} class="active"{/if} ><a href="reseller.php?action=myorders">{$lang.earnings} {$lang.from} {$lang.retail} {$lang.selling}</a> </li>
                    {/if}
                    <li  {if $currentsubmenu eq 'myuserorders'} class="active"{/if} ><a href="reseller.php?action=myuserorders&order=imei">{$lang.my} {$lang.user}s {$lang.orders}</a> </li>
                    {if $storepaypal}
                        <li {if $currentsubmenu eq 'fundsummary'} class="active"{/if} ><a href="reseller.php?action=fundsummary">{$lang.user} {$lang.fundssummary}</a> </li>
                    {/if}
                    <li {if $currentsubmenu eq 'rstatement'} class="active"{/if} ><a href="reseller.php?action=rstatement">{$lang.my} {$lang.statement}</a> </li>
                </ul>            
            {/if}
    
    
    <ul class="nav nav-list">
        <li class="nav-header">  {$lang.advance} {$lang.resellingsystem}</li>     
        <li {if $currentsubmenu eq 'adduser'} class="active"{/if} ><a href="reseller.php?action=adduser">{$lang.adduser}</a> </li>
        <li {if $currentsubmenu eq 'myuser'} class="active"{/if} ><a href="reseller.php?action=myuser">{$lang.myuser}</a> </li>
    </ul>    
    
    {if $userdetails.access.credit_transfer eq '1'}        
        <ul class="nav nav-list">            
            <li class="nav-header">  {$lang.regular} {$lang.resellingsystem}</li>
            <li {if $currentsubmenu eq 'transfer'} class="active"{/if} ><a href="settings.php?action=transfer&subuser=true&right=res">{$lang.crtransfer}</a> </li>
            <li {if $currentsubmenu eq 'transfer'} class="active"{/if} ><a href="reseller.php?action=mysubuser">{$lang.myuser}</a> </li>
        </ul>                
    {/if}       
    
    
       