  <div id="tabcontent" class="bundle" style="position:relative">

{foreach from=$bundle key=sid item=items}

    <br />
    <h4 style="border-bottom:#ccc solid 1px;padding-bottom:5px">{$lang.combodeal}</h4><br />
        <div style="float:left;">
            {foreach from=$items key=id item=name name=safalo}
                <table><tr><td>
                    <div class="item_block" style="width:120px;min-height:110px">

                        <div>
                            <a target="_blank" href="{if $seo}{$name.seourl}{else}cart.php?group={$name.group_id}&item={$id}&service=imei&parentid=1008{/if}">
                                {if $name.thumb}
                                    <img title="{$name.description}" alt="{$name.description}"  src="{$name.thumb}" border="0"/>
                                {else}
                                    {if $name.image_link}
                                        <div class="loadme"><img class="resize" title="{$name.description}" alt="{$name.description}"  src="{$name.image_link}" border="0"/></div>
                                    {else}
                                        <div class="div_small_noimage"><span>{$lang.image}</span> <span>{$lang.not}</span> <span>{$lang.found}</span></div>
                                    {/if}
                                {/if}
                            </a>
                         </div>
                 </div>

                 </td>

                 <td style="padding:10px;vertical-align:top">

                        <div class="item_desc">
                            <span> <a  href="{if $seo}{$name.seourl}{else}cart.php?group={$name.group_id}&item={$id}&service=imei&parentid=1008{/if}">{$name.service_name|strip_tags|truncate:50:"..."}</a> </span>
                            {if $viewmode eq 'list'}
                                <p>{$name.short_info|strip_tags|truncate:400:"..."}</p>
                            {/if}
                          </div>

                        <div  class="item_price">
                            {if $name.credit-$name.discount eq '0'}
                                <span>{$lang.free} <span></span> </span>
                            {else}
                                {if $name.discount}
                                    <span>{$lang.market} {$lang.price} :</span> <span class="discount red"> <span class="prefix">{$currency.prefix}</span> {$name.credit}<span class="suffix">{$currency.suffix}</span> </span> <br />
                                {/if}
                                <span>{$lang.our} {$lang.price} :</span>  <strong><span class="prefix">{$currency.prefix}</span> {$name.credit-$name.discount}<span class="suffix">{$currency.suffix}</span>  </strong> {if $name.discount}{/if}
                            {/if}
                            {assign var="credito" value=$name.credit}
                            {assign var="discounto" value=$name.discount}
                            {assign var="totals" value="`$totals+$credito-$discounto`"}
                            {assign var="width" value="`$width+155`"}
                        </div>

                 </td></tr></table>
                   <div class="clear"></div>
                 {if $smarty.foreach.safalo.last}
                 {else}
                    <div style="font-size: 20px;width:120px;text-align:center"> +</div>
                {/if}
          {/foreach}
        </div>

   <div style="float:left;">

       <table style="height:{$width}px;width:100%" class="ribbon" cellpadding="0" cellspacing="0">
           <tr><td class="ribbonleft"></td></tr>
           <tr><td style="vertical-align:middle">
                    <div style="line-height:20px;padding-left:30px;font-size:16px;">
                        {$lang.regular} {$lang.price} : <span class="discount"><span class="prefix">{$currency.prefix}</span> {$totals}<span class="suffix">{$currency.suffix}</span> </span> <br />
                        {$lang.discounted} {$lang.price} : <span class="discount_text"><span class="prefix">{$currency.prefix}</span> {$price}<span class="suffix">{$currency.suffix}</span> </span> <br />
                        {$lang.yousave} : {math equation="(100*x)/y" x=$totals y=$price format="%.2f"} %
                    </div>
                </td>
           </tr>
           <tr><td class="ribbonright"></td></tr>
       </table>
    </div>
    <div class="clear"></div>
  </div>
{/foreach}
<div class="clear"></div>
