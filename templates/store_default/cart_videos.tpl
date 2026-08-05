<div class="row">
    {foreach from=$videos key=GroupName item=img}
        {if !empty($img)}
            <div class="col-lg-6" style="height:300px">
                <iframe style="position:absolute;left:0;right:0;top:0;bottom:0;height:100%;width:100%"  src="https://www.youtube.com/embed/{$img}" frameborder="0" allowfullscreen></iframe>
            </div>
        {/if}
    {/foreach}
</div>
