<div class="text-center">
    {if $adds_index.4 or $adds_login.4 or $adds_productdetails.4}
        <div style="text-align: center;padding:10px 0;margin-bottom:10px">{$adds_index.4} {$adds_login.4} {$adds_productdetails.4}</div>
    {/if}

    {if $adds.4}
        <div style="margin-bottom:20px">
            {$adds.4}
        </div>
    {/if}
</div>

</div>
</div>
<div>

    {if $loggedin}
        {include file="templates/default/chunks/footer-links.tpl"}
    {/if}

</div>



    {include file="templates/default/chunks/footer-modals.tpl"}


</body></html>
