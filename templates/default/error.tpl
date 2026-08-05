 
 <div class="subcontainerfullwidth">
<br /><br /><br /><br /><br /><br />
     <span style="font-size:200px;color:#f4f4f4;display:block;float:left">{$errorno}</span> <span style="color:#888;font-size:20px;text-transform:uppercase;float:left;display:block;margin-top:155px">Error</span>
    
      <span style="color:#ccc;font-size:20px;margin-left:10px;text-transform:uppercase;float:left;display:block;margin-top:155px">  
            {if $errorno eq 404}
                {$lang.pagenotfound}
            {elseif $errorno eq 401}
                {$lang.unauthorized}
            {elseif $errorno eq 403}
                {$lang.forbidden}
            {elseif $errorno eq 405}
                {$lang.methodnotallowed}
            {elseif $errorno eq 406}
               {$lang.notacceptable}                         
            {elseif $errorno eq 500}
                {$lang.internalservererror}
            {elseif $errorno eq 503}
                {$lang.serviceunavailable}
            {/if}
    </span>
    <div class="clear"></div>
    
    <span style="color:#ccc;font-size:12px;display:block;text-align:right;margin-top:-50px;">{$lang.sorrywemovedbunchofstuff} </span>
 <br /><br /><br /><br /><br /><br />   
  </div>    
 
    </div>
    