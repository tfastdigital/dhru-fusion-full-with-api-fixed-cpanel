 {include file="templates/default/productlist.tpl"}


 <div class="container mt-3">



<div class="row">


{foreach from=$imeiitems key=GroupName item=Services}
    {call name=productlist data=$Services service='imei'}
{/foreach}


{foreach from=$items key=GroupName item=Services}
    {call name=productlist data=$Services service='product'}
{/foreach}


{foreach from=$serveritems key=GroupName item=Services}
    {call name=productlist data=$Services service='server'}
{/foreach}
</div>
</div>

