{if $items}
<div class="more-items">
{if $viewmode eq 'list'}
        {assign var='class' value='display-list'}
   {else}
        {assign var='class' value='item'}
   {/if}
 {foreach from=$items key=GroupName item=Services}
            {foreach from=$Services key=id item=name}

            <div class="{$class}">

                            <div class="item_img">
                                <a href="{if $seo}{$name.seourl}{else}cart.php?group={$name.group_id}&item={$name.id}&service={$type}&parentid=1008{/if}">
                                {if $name.thumb}
                                    <img title="{$name.description}" alt="{$name.description}"  src="{$name.thumb}" border="0"/>
                                {else}
                                    {if $name.image_link}
                                        {foreach from=$name.image_link item=img}
                                            {if $img.1 eq '1'}<img title="{$name.description}" alt="{$name.description}"  src="{$img.0}" border="0" class="resize"/>{/if}
                                        {/foreach}
                                    {else}
                                        <div class="div_small_noimage"><span>{$lang.image}</span> <span>{$lang.not}</span> <span>{$lang.found}</span></div>
                                    {/if}
                                {/if}
                                </a>

                             </div>

                              <div class="item_desc">
                                <span> <a  href="{if $seo}{$name.seourl}{else}cart.php?group={$name.group_id}&item={$name.id}&service={$type}&parentid=1008{/if}">{$name.service_name|strip_tags|truncate:50:"..."}</a> </span>
                                {if $viewmode eq 'list'}
                                    <p>{$name.short_info|strip_tags|truncate:400:"..."}</p>
                                {/if}
                              </div>

<div class="item_price">
<div class="item_discount">
    <span>
        {if $name.credit-$name.discount eq '0'}
            <span class="free"> {$lang.free} <span></span></span>
        {else}
            {if $name.discount && $name.discount gte 0}
                <span class="discount red">
                <span class="prefix">{$currency.prefix}</span> {$name.credit}<span class="suffix">{$currency.suffix}</span> </span><br />
            {/if}
            <span class="prefix">{$currency.prefix}</span> {$name.credit-$name.discount}<span class="suffix">{$currency.suffix}</span>
        {/if}
    </span>
  {if $name.discount}
                            <span class="saveinper"><span>{math equation="100-(x - y)*100/x" x=$name.credit y=$name.discount format="%.1f"}% {$lang.off} </span></span>
                        {/if}
</div>
</div>


                  {if $name.hot}
                  	<div class="hot"><span>{$lang.hot} <span></span> </span></div>
                  {/if}




          {if $type eq 'product'}
                 <div class="item_ratings"><span class="rating_{$name.rating}"></span></div>
                <div class="compare">
                  <form class="form-inline frm-inline" method="post" name="" id="{$id}" >
                    <input type="hidden" name="serviceid" value="{$name.id}" />
                      <div class="custom-control custom-checkbox">
                          <input type="checkbox" name="compr" {$name.compare} value="{$id}" onclick="addToCompare('{$name.id}');" class="custom-control-input" id='add_{$name.id}'>
                          <label class="custom-control-label" for="add_{$name.id}"> {$lang.addtocompare} </label>
                      </div>
                    {*<input type="checkbox" name="compr" id='add_{$name.id}' value="{$id}" {$name.compare}    onclick="addToCompare('{$name.id}');" />
                    <label for="add_{$name.id}">{$lang.addtocompare}</label>*}
                  </form>
                  <div class="compare_item"></div>
                </div>

                <div class="item-property">
                    <a href="{if $seo}{$name.seourl}{else}cart.php?group={$name.group_id}&item={$name.id}&service=product&parentid=1008{/if}" class="addtocart_btn"><i class="fa fa-shopping-cart fa-2x"></i></a>
                </div>
           {/if}


            </div><br />
            {/foreach}

        {foreachelse}
            {/foreach}

</div>
{else}
FINISHED
{/if}
