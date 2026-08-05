<div id="tabcontent">

  <div>
  <br />
  <h3>{$details.service_name}</h3>
 <div style="clear:both;"></div>
  <br /> <br />
  <div    class="alert"></div>
{foreach from=$details.addons key=id item=add}

  <form method="post" id="frmadds{$id}">
   {$token}
   <input type="hidden" name="servicetype" value="product" />
    <input type="hidden" name="id" value="{$add.mid}" />
    <input type="hidden" name="quantity" value="1" />
    <input type="hidden" name="orderid" value="{$orderid}" />
 <label for="{$id}">{$add.service_name}</label>
{$add.short_info}<br />
         {if $add.paytype eq 1}
        &nbsp;&nbsp;&nbsp;&nbsp;
              <strong> {$lang.free}</strong>
         {elseif $add.paytype eq 2}
        &nbsp;&nbsp;&nbsp;&nbsp;

              {if $add.price gte 0}
                  {if $add.cartdiscount}<div><span>{$lang.market} {$lang.price} : </span>
                  <span class="{if $add.cartdiscount}discount{/if}">
                  <strong> <span class="prefix">{$currency.prefix}</span> {$add.price}<span class="suffix">{$currency.suffix}</span> </strong>
                  </span></div>{/if}

                  {if $add.price eq 0 && $add.zeropriceaction eq 3}
                    <span class="prefix">{$currency.prefix}</span> <input type="text" name="price" style="width: 100px"  />
                    <span class="suffix">{$currency.suffix}</span>
                  {else}
                  <span>{$lang.our} {$lang.price} : </span><span><span class="prefix">{$currency.prefix}</span>
                  {$add.price-$add.cartdiscount}<span class="suffix">{$currency.suffix}</span> </span>
                  {/if}

                  {if $add.cartdiscount}<span>{$lang.you} {$lang.save} :</span>
                   <span style="color:green"><span class="prefix">{$currency.prefix}</span> {$add.cartdiscount}<span class="suffix">{$currency.suffix}</span> </span>{/if}

                {/if}

        {else}
       &nbsp;&nbsp;&nbsp;&nbsp;
       <select name="recurring">
{assign var="checks" value="checked='checked'"}
{if $add.monthly gt 0}
<option value="monthly">Monthly Price <span class="prefix">{$currency.prefix}</span> {$add.monthly}<span class="suffix">{$currency.suffix}</span> </option>
{/if}
{if $add.quaterly gt 0}
<option value="quaterly">Quterly Price <span class="prefix">{$currency.prefix}</span> {$add.quaterly}<span class="suffix">{$currency.suffix}</span> </option>
{/if}
{if $add.semianualy gt 0}
<option value="semianualy">Semi-Annual Price <span class="prefix">{$currency.prefix}</span> {$add.semianualy}<span class="suffix">{$currency.suffix}</span> </option>
{/if}
{if $add.anualy gt 0}
<option value="anualy">Annual Price <span class="prefix">{$currency.prefix}</span> {$add.anualy}<span class="suffix">{$currency.suffix}</span> </option>
{/if}

{if $add.bianualy gt 0}
<option value="bianualy">Biannual Price <span class="prefix">{$currency.prefix}</span> {$add.bianualy}<span class="suffix">{$currency.suffix}</span> </option>
<input type="radio" name="add_{$id}" {$checks} value="bianualy" id="bianua" />
{/if}

{if $add.trianualy gt 0}
<option value="trianualy">Triannual Price <span class="prefix">{$currency.prefix}</span> {$add.trianualy}<span class="suffix">{$currency.suffix}</span> </option>
{/if}

</select>
        {/if}
        <div style="float: right;">
      <input type="submit" id="placeorder"
onclick="SubmitForm('#placeorder','includes/cart','#frmadds{$id}','.alert','true','#loader');" value="{$lang.addtocart}" />

        </div>
<br />
    <hr />
    </form>
{/foreach}
<div style="clear:both;"></div>
  <br />
  <div style="float: right;">
  <form method="post" action="cart/checkout">
<input type="button" id="placeorder"
value="{$lang.checkout}" />
</form>
       </div>


  </div>
</div>
</div>
{include file="templates/default/client_profile_rightmenu.tpl"}
