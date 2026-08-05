
{foreach from=$addon key=id item=add}

    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="addon[{$id}]"   class="custom-control-input" id="chk{$id}">
        <label class="custom-control-label" for="chk{$id}"> {$add.service_name} </label>
    </div>

{*<input type="checkbox" name="addon[{$id}]" value="1" id="{$id}" /> <label for="{$id}">{$add.service_name}</label>*}

         {if $add.paytype eq 1}
        &nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp;
              <strong> {$lang.free}</strong>
         {elseif $add.paytype eq 2}
        &nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp;
              {if $add.price gte 0}

                  {if $add.cartdiscount}<div><span>{$lang.market} {$lang.price} : </span> <span class="{if $servicedtl.cartdiscount}discount{/if}"> <strong> <span class="prefix">{$currency.prefix}</span> {$servicedtl.price}<span class="suffix">{$currency.suffix}</span> </strong></span></div>{/if}

                  {if $add.price eq 0 && $add.zeropriceaction eq 3}
                    <span class="prefix">{$currency.prefix}</span> <input type="text" name="price" style="width: 100px"  /><span class="suffix">{$currency.suffix}</span>
                  {else}
                  <span>{$lang.our} {$lang.price} : </span><span><span class="prefix">{$currency.prefix}</span> {$add.price-$add.cartdiscount}<span class="suffix">{$currency.suffix}</span> </span>
                  {/if}

                  {if $add.cartdiscount}<span>{$lang.you} {$lang.save} :</span>  <span style="color:green"><span class="prefix">{$currency.prefix}</span> {$add.cartdiscount}<span class="suffix">{$currency.suffix}</span> </span>{/if}

                {/if}

        {else}
        &nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp;
{assign var="checks" value="checked='checked'"}
{if $add.monthly gt 0}
<input type="radio" name="add_{$id}" {$checks} value="monthly" id="mon" /> <label for="mon">Monthly Price <span class="prefix">{$currency.prefix}</span> {$add.monthly}<span class="suffix">{$currency.suffix}</span> </label> &nbsp;
{assign var="checks" value=""}
{/if}
{if $add.quaterly gt 0}
<input type="radio" name="add_{$id}" {$checks} value="quaterly" id="qua" /> <label for="qua">Quterly Price <span class="prefix">{$currency.prefix}</span> {$add.quaterly}<span class="suffix">{$currency.suffix}</span> </label> &nbsp;
{assign var="checks" value=""}
{/if}
{if $add.semianualy gt 0}
<input type="radio" name="add_{$id}" {$checks} value="semianualy" id="sem" /> <label for="sem">Semi-Annual Price <span class="prefix">{$currency.prefix}</span> {$add.semianualy}<span class="suffix">{$currency.suffix}</span> </label> &nbsp;
{assign var="checks" value=""}
{/if}
{if $add.anualy gt 0}
<input type="radio" name="add_{$id}" {$checks} value="anualy" id="anua" /> <label for="anua">Annual Price <span class="prefix">{$currency.prefix}</span> {$add.anualy}<span class="suffix">{$currency.suffix}</span> </label> &nbsp;
{assign var="checks" value=""}
{/if}
{if $add.bianualy gt 0}
<input type="radio" name="add_{$id}" {$checks} value="bianualy" id="bianua" /> <label for="bianua">Biannual Price <span class="prefix">{$currency.prefix}</span> {$add.bianualy}<span class="suffix">{$currency.suffix}</span> </label>&nbsp;
{assign var="checks" value=""}
{/if}
{if $add.trianualy gt 0}
<input type="radio" name="add_{$id}" {$checks} value="trianualy" id="trianua" /> <label for="trianua">Triannual Price <span class="prefix">{$currency.prefix}</span> {$add.trianualy}<span class="suffix">{$currency.suffix}</span> </label>&nbsp;
{assign var="checks" value=""}
{/if}
        {/if}
<br />

{/foreach}
