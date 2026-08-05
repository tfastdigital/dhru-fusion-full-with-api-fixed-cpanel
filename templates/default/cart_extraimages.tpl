
<div class="row" id="gallery1">

    {foreach from=$images key=GroupName item=img}
        {if !empty($img)}
           <div class="col-lg-4 mb-4 bottom-space"> <a href="{$img}" ><img src="{$img}" class="thumb"/></a> </div>
        {/if}
    {/foreach}

</div>
