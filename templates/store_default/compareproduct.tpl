{literal}
<script>
jQuery(document).ready(function(){
     $('tr.itemrow').each(function(){
        var length=$(this).find('td').length;
        checkValue(this,length);
    });

    function checkValue(tr,length){
        var i=1;
        $(tr).children().each(function(){
            if($(this).text()=='Yes'){
                $(this).addClass('yes');
             }
             if($(this).text()=='No'){
                $(this).addClass('no');
             }
            var next=$(this).next();
            if($(this).text()!='-'){
                if($(this).text()==$(next).text()){
                  i++;
                  $(this).remove();
                  $(next).addClass('mergecell');
                  $(next).attr('colspan',i);
                }
                else{
                    i=1;
                }
            }
        });
     }
});
</script>

<style>
.data td,.data th{text-align:center;border-right: #e9e9e9 solid 1px;padding: 10px !important;border-bottom: #e9e9e9 solid 1px;}
.data th{background: none !important;}
.data th{border-bottom: #ccc solid 1px !important;}
.featurename{text-align: right !important;}
.mergecell{text-align: center;font-weight: bold;background-color:#fafafa}
.data th:last-child{border-right:none !important}
.data td:last-child{border-right:none !important}
.data tr:last-child td{border-bottom:none !important}

</style>

{/literal}




<div class="container"><div class="page-container">

{if $features}
  <table class="data" width="100%" border="0" cellpadding="10" cellspacing="0">
    <tr>
        <th class="featurename"></th>
          {foreach from=$products key=id item=product}
            <th align="center"><a href="{if $seo}{$product.seourl}{else}cart.php?group={$product.group_id}&item={$product.mid}&service=product{/if}">{$product.service_name}</a> <a href="viewcompare.php?clear={$id}" title="Remove"> &times; </a></th>
          {/foreach}
    </tr>

    <tr>
      <td class="featurename"><strong>{$lang.price}</td>
          {foreach from=$products key=id item=product}
              <td style="font-size:16px;"><strong>
              	{if $product.discount} <span class="discount red"><span class="prefix">{$currency.prefix}</span> {$product.credit}<span class="suffix">{$currency.suffix}</span> </span> <span class="prefix">{$currency.prefix}</span> {$product.credit-$product.discount}<span class="suffix">{$currency.suffix}</span>
                {else}
                	<span class="prefix">{$currency.prefix}</span> {$product.credit-$product.discount}<span class="suffix">{$currency.suffix}</span>
                {/if}
            	</td>
          {/foreach}
    </tr>

    {foreach from=$features key=id item=feature}
        <tr class="itemrow">
          <td class="featurename">{$id}</td>
              {foreach from=$feature key=sid item=item}
                {if $item|strtoupper eq 'YES'}
                    <td>Yes</td>
                {elseif $item|strtoupper eq 'NO'}
                     <td>No</td>
                {else}
                    <td>{$item}</td>
                {/if}
              {/foreach}
        </tr>
    {/foreach}

  </table>
  <br />
  <form method="post" >
    <div align="right">
      <input type="submit" name="clearall" class="btn" value="{$lang.clear} {$lang.all}" />
    </div>
  </form>
  {else}
  <p align="center" style="padding:20px">{$lang.noitemcompare}</p>
  {/if}
    </div></div>
<div class="clear"></div>
