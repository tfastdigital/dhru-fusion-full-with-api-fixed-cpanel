{if $dailydeals}
<div id="tabcontent">

<h1>{$lang.dailydeals}</h1>
<div  class="data">

              {foreach from=$dailydeals key=GroupName item=Services}
                {foreach from=$Services key=id item=name}

                    <div class="item_block_dailydeals {cycle values="i_first,i_second,i_last"}">

                                <div class="item_img floatleft">
                                    <a href="{if $seo}{$name.seourl}{else}cart.php?group={$name.group_id}&item={$id}&service=product{/if}">
                                        {if $name.thumb}
                                            <div class="loadme"><img title="{$name.description}" alt="{$name.description}"  src="{$name.thumb}" border="0"/></div>
                                        {else}
                                            {if $name.image_link}
                                                {foreach from=$name.image_link item=img}
                                                    {if $img.1 eq '1'}<div class="loadme"><img title="{$name.description}" alt="{$name.description}"  src="{$img.0}" border="0" class="resize"/></div>{/if}
                                                {/foreach}
                                            {else}
                                                <div class="div_small_noimage"><span>{$lang.image}</span> <span>{$lang.not}</span> <span>{$lang.found}</span></div>
                                            {/if}
                                        {/if}
                                    </a>

                                    <a href="{if $seo}{$name.seourl}{else}cart.php?group={$name.group_id}&item={$id}&service=product{/if}" class="addtocart_btn"><span> </span>{$lang.iwantone}</a>

                                 </div>

                                  <div class="item_desc floatleft">
                                    <span> <a  href="{if $seo}{$name.seourl}{else}cart.php?group={$name.group_id}&item={$id}&service=product{/if}">{$name.service_name|strip_tags|truncate:50:"..."}</a> </span><br /><br />

                                    <div class="item_price">
                                        <div class="item_discount">
                                            <span>
                                                {if $name.credit-$name.discount eq '0'}
                                                    <span>{$lang.free} <span></span> </span>
                                                {else}
                                                    {if $name.discount}
                                                          <div>{$lang.market} {$lang.price} : <span class="discount red"><span class="prefix">{$currency.prefix}</span> {$name.credit}<span class="suffix">{$currency.suffix}</span> </span></div>
                                                    {/if}
                                                     <div>{$lang.our} {$lang.price} : <span class="ourprice"> <span class="prefix">{$currency.prefix}</span> {$name.credit-$name.discount}<span class="suffix">{$currency.suffix}</span> </span></div>
                                                    {if $name.discount}
                                                        <div>{$lang.you} {$lang.save} : <span class="saveinper"> ({math equation="100-(x - y)*100/x" x=$name.credit y=$name.discount format="%.2f"}%)</span></div>
                                                    {/if}
                                                {/if}
                                            </span>
                                        </div>
                                  </div>

                                  </div><div class="clear"></div>



                              </div>
                  {/foreach}
            {/foreach}
            <div class="clear"></div>

  </div>
</div>    <br />
{/if}
