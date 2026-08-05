<div id="tabcontent">

  <div id="formstyle_1">


 <fieldset>
     <h4>{$lang.order} {$lang.details}</h4>
     <div class="form-group "><label class="form-label">{$lang.invoice} {$lang.date} </label><div class="controls">: {$details.date}</div></div>
     <div class="form-group "><label class="form-label">{$lang.invoice} </label><div class="controls">: <a target="_blank" href="viewinvoice.php?id={$details.mi}" >#{$details.invoiceid}</a></div></div>
     <div class="form-group "><label class="form-label">{$lang.status} </label><div class="controls">:  {$details.status}</div></div>
     <div class="form-group "><label class="form-label">{$lang.trackinglink} </label><div class="controls">: <a href="{$details.link}" target="_blank">{$details.shipped_by}</a></div></div>
 </fieldset>


<hr />

 <fieldset>
 <h4>{$lang.shipping} {$lang.details}</h4>
     <div class="form-group "><label class="form-label">{$lang.name}  </label><div class="controls">: {$details.sh_firstname} {$details.sh_lastname}</div></div>
     <div class="form-group "><label class="form-label">{$lang.email} </label><div class="controls">: {$details.sh_email}</div></div>
     <p><label style="height:100px">{$lang.address} </label><div class="controls">
                            {$details.sh_address1} ,<br />
                            {$details.sh_address2} ,<br />
                            {$details.sh_city} - {$details.sh_zip} ,<br />
                            {$details.sh_state} ,<br />
                            {$details.sh_country}
                            </div></div>
      <div class="form-group "><label class="form-label">{$lang.contactno} </label><div class="controls">: {$details.sh_contact}</div></div>
      <div class="form-group "><label class="form-label">{$lang.shipped} {$lang.by} </label><div class="controls">: {$details.gateway}</div></div>
 </fieldset>



 {if $details.downloads}
 <hr />
     <fieldset>
         <h4>{$lang.downloads}</h4>
           <table class="table table-bordered" style="border:none">
               {foreach from=$downloads key=id item=down}
                      <tr><td><a href="{$down.link}" target="_blank" >{$down.filename}</a></td></tr>
               {/foreach}
            </table>
     </fieldset>
 {/if}

  </div>
</div>
</div>
{include file="templates/default/client_profile_rightmenu.tpl"}
