
<form method="post" action="cart.php"   autocomplete="off">

    <input type="hidden" name="service" value="imei">
    <input type="hidden" name="item" id="item" value="">

    <div class="mt-3 mb-4 bottom-space">
        <select name="group" id="group"  class="form-control " onChange="getservicelist(this.value);">
            <option value="">-Select Group-</option>
            {foreach from=$itemlist key=id item=group}
                <option value="{$id}">{$group.group_name}</option>
            {/foreach}
        </select>
    </div>


    <div class="mt-3 mb-4 bottom-space">

        {foreach from=$itemlist key=id item=groups}
            <div class="servicedropdown" id="item{$id}">
                <select     class="form-control " onChange="serviceselected(this.value);">
                    <option value="">-Select Service-</option>
                    {foreach from=$groups.item key=id item=item}
                        <option value="{$id}">{$item}</option>
                    {/foreach}
                </select>
            </div>
        {/foreach}

    </div>


    <button class="btn btn-primary unlock-btn" type="submit">Unlock Now</button>

</form>


{literal}
    <script>
        function  getservicelist(value){
            $('.servicedropdown').hide();
            $('#item'+value).show();
        }
        function  serviceselected(value){
            $('.unlock-btn').hide()
            if(value){
                $('.unlock-btn').show();
                $('#item').val(value);
            }
        }
    </script>
    <style>
        .servicedropdown,.unlock-btn{
            display: none;
        }
    </style>
{/literal}
