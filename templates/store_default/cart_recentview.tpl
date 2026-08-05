{if $itemsds}
<div style="border:1px solid #ccc;padding:0 0 0px 0;margin-bottom:12px;" class="cart">

     <li class="nav-header">{$lang.recently} {$lang.viewed} {$lang.products}</li>


  {foreach from=$itemsds key=id item=items}

        <li style="text-align:center;padding:10px 0;margin:10px;">
           <a href="{$site_address}cart?group={$items.group_id}&item={$items.mdid}&service=product&parentid=1008">

             {if $items.thumb}
                <img title="{$items.description}" alt="{$items.description}"  src="{$items.thumb}" border="0"/>
            {else}
                {if $items.image_link}
                    <div class="loadme"><img class="resize" title="{$items.description}" alt="{$items.description}"  src="{$items.image_link}" border="0"/></div>
                {else}
                    <div class="div_small_noimage"><span>{$lang.image}</span> <span>{$lang.not}</span> <span>{$lang.found}</span></div>
                {/if}
            {/if}


              <div class="clear"></div>
                <span style="" class="servicename"> {$items.service_name}</span>
              </a>
        </li>
  {/foreach}
 </div>
{/if}
