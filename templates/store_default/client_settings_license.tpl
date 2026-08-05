<div id="tabcontent">

  <div id="formstyle_1">

 {if $details.key}
 <div style="border:dashed #ccc 1px; font-size: 15px; padding:5px;">
<strong>{$lang.license} {$lang.key} </strong> : {$details.key} </div>
 {/if}
 <br />

 <fieldset>

 <h4>{$lang.license} {$lang.details}</h4>

 <div class="form-group "><label class="form-label">{$lang.registration} {$lang.date} </label><div class="controls">: {$details.date}</div></div>
 <div class="form-group "><label class="form-label">{$lang.invoice} </label><div class="controls">: <a target="_blank"
  href="viewinvoice.php?id={$details.mi}" >#{$details.invoiceid}</a></div></div>
 <div class="form-group "><label class="form-label">{$lang.next} {$lang.invoicesdatedue} </label><div class="controls">:  {$details.expiry}</div></div>
 <div class="form-group "><label class="form-label">{$lang.billingcycle} </label><div class="controls">:
 {if $details.recurring eq '' && $details.days neq ''}
    {if $details.days eq 9999}
        -
    {else}
     {$details.days} {$lang.days}
    {/if}
 {elseif $details.recurring eq ''}
     {$lang.onetime}
 {else}
     {$details.recurring}
 {/if}
 </div></div>
 <div class="form-group "><label class="form-label">{$lang.status} </label><div class="controls">:  {$details.status}</div></div>



 </fieldset>


<hr />

 <fieldset>
<h4>{$lang.addons}</h4>
 {if $addon}

 <table width="100%" class="table table-bordered" style="border:none" cellspacing="0" cellpadding="0">
     <tr>
         <th>{$lang.addon}</th>
         <th> Reissue {$lang.status}</th>
         <th> Reissue {$lang.date}</th>
         <th>{$lang.status}</th>
     </tr>
         {foreach from=$addon key=id item=det}
            <tr>
                <td align='left'>
                    {$det.name}
                </td>
                <td>
                     {if $det.recurring eq '' && $det.days neq '' }
                        {if $det.days eq 9999}
                            {$lang.onetime}
                        {else}
                            {$det.days} {$lang.days}
                        {/if}
                     {elseif $det.recurring eq ''}
                        {$lang.onetime}
                     {else}
                         {$det.recurring}
                     {/if}
                 </td>
                 <td>

                  {if $det.recurring eq '' && $det.days neq '' }
                    {if $det.days eq 9999}
                        -
                    {else}
                        {$det.expiry}
                    {/if}
                 {elseif $det.recurring eq ''}
                    -
                 {else}
                     {$det.expiry}
                 {/if}

             </td>
             <td>{$det.status}</td>
         </tr>
         {/foreach}
 </table>

 {else}
    <span align='center'>{$lang.noaddonspurchaseyet}</span>
 {/if}

    <div style="clear:both;">&nbsp;</div>
     <form method="post" action="buyaddon.php?id={$details.order_id}" style="text-align:right">
         <input type="hidden" name="id" value="{$details.order_id}" />
         <input type="submit" name="addons" value="+ {$lang.addon}" />
     </form>
     <br />
 </fieldset>




 {if $details.downloads} <hr />
     <fieldset>
         <h4>{$lang.downloads}</h4>
            <table class="table table-bordered" style="border:none">
               {foreach from=$downloads key=id item=down}
                      <tr><td><a href="{$down.link}" target="_blank" >{$down.filename}</a></td></tr>
               {/foreach}
            </table>
     </fieldset>
 {/if}


 <hr /><div style="clear: both;">&nbsp;</div>
       <div style="">
         <fieldset>
         <h4>{$lang.remoteauthentic}</h4>
                 {if $details.validatedom}
                     <p>
                         <label>
                             {$lang.validdomain} </label><div class="controls">: {$details.domain}
                        </span>
                    </p>
                {/if}

                {if $details.validateip}
                <p>
                    <label>
                         {$lang.validips} </label><div class="controls">: {$details.validip}
                    </span>
                </p>
                {/if}

                 {if $details.validatedir}
                    <p>
                        <label>
                             {$lang.validdir} </label><div class="controls">: {$details.validdir}
                        </span>
                    </p>
               {/if}

              {if $details.allowreissue &&  $details.license_status eq 'reissued' && ($details.reissued_counter<$details.max_reissue || $details.max_reissue eq 0) }
                  <p>
                      <label></label>
                      <span>&nbsp;
                          <form method="post">
                              <input type="hidden" name="reissue" value="{$details.order_id}" />
                              <input type="submit" name="re" value="{$lang.reissuelicense}" />
                          </form>
                      </span>
                  </p>
              {/if}
         </fieldset>
     </div>

  </div>
</div>
</div>
{include file="templates/default/client_profile_rightmenu.tpl"}
