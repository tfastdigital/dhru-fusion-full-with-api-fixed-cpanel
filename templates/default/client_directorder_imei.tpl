{literal}
<script type="text/javascript">
    getServicedetailsIMEI({/literal}'{$mdservice}'{literal},'#loadDetails','.alert1',true,'#loader','',true,'','',{/literal}'{$charge}'{literal});
</script>
{/literal}
<div class="container"><div class="page-container">
    <div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="row">
            <div   class="alert alert-cart"></div>
            <div class="col-lg-12">
                    <h4 class=""> {$service}  <small style="font-size:15px">({$lang.invoicestotal} {$lang.orders} :   {$nos})</small> </h4>
                    {if $orderinfo}
                        {$orderinfo}
                    {/if}
                    <form   method="post" name="imeiorder_form" id="imeiorder_form">
                        <input type="hidden" name="uid" value="{$uid}" />
                        {if $charge eq '1'}
                            <input type="hidden" name="servicetype" value="{$servicetype}" />
                            <input type="hidden" name="id" value="{$md5id}" />
                        {/if}
                        {$token}
                        <div id="loadDetails"></div>

                    </form>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
