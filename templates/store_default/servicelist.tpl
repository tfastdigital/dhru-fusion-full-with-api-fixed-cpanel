

<div class="container"><div class="page-container">
	{if $service_name}
         {if $image_link} <img src="{$image_link}" /> {/if}
  	{/if}

  <div>

  <div>
    {if $info}
        {$info}
    {/if}
  </div>


<div class="mt-3 mb-4 bottom-space">
    <div>{if $searchload} {else} {if $displayprice eq 1}  <h3><span class="prefix">{$currency.prefix}</span> {$credit}<span class="suffix">{$currency.suffix}</span> </h3>{/if}{/if}</div>
    {if $searchload}
    {else}
        <div> <span class="badge badge-info"> {$lang.deliverytime} : {$time}</span> </div>
    {/if}
</div>


  {if $listdetails}
      {if $brandmodel}
            <h1>{$lang.supporedphone}:</h1>
            <div class="table-responsive">
                {foreach from=$brandmodel key=brand item=model}
                    <table  class="table table-bordered table-striped">
                        <tr><th><span class="h">{$brand}</span> </th><th></th> </tr>
                        <tr><td>{foreach from=$model key=id item=detail} {$detail.1} |  {/foreach}</td> <td></td> </tr>
                    </table>
                {/foreach}
           </div>
      {/if}
      {if $countryprov}
           <h1>{$lang.supporednetwork}:</h1>
           <div class="table-responsive">
          <table class="table  table-striped">
            {foreach from=$countryprov key=country item=prov}
            <tr>
              <td>{$country}</td>
              <td> {foreach from=$prov key=id item=detail}{$detail.1} <br />{/foreach} </td>
              <td> </td>
            </tr>
            {/foreach}
          </table>
          </div>
      {/if}

  {else}

      {if $listdata}
          <div class="row">
            <div class="col-lg-6"> {$setcurrency} </div>
            <div class="col-lg-6">
              <form method="get" action="" name="filtergroupfrm" >
                <select name="group" class="form-control " onchange="filtergroupfrm.submit()">
                    <option>-{$lang.selectgroup}- </option>
                    {foreach from=$imeiservicegroup key=id item=name}
                          <option value="{$id}" {if $group eq $id}selected="selected"{/if} > {$name.name}</option>
                    {/foreach}
                </select>
              </form>
            </div>
          </div>
          <div class="table-responsive">

          {foreach from=$imeiservicelist key=GroupName item=Services}
              <table class="table table-bordered table-striped">
                <tr>
                  <th width="50%"><strong>{$GroupName}</strong></th>
               {if $displayprice eq 1}<th width="15%" >{$lang.price}</th>{/if}
                  <th width="15%" >{$lang.type}</th>
                  <th width="15%" align="right"> {$lang.deliverytime}</th>
                </tr>
                {foreach from=$Services key=id item=Service}
                    <tr>
                      <td>{if $Service.icon}{$Service.icon}{/if}
                        {if $seo} <a href="{$Service.seourl2}">{$Service.service_name}</a> {else} <a href="productsandservices.php?action=getdetail&service={$id}&parentid=1006">{$Service.service_name}</a> {/if}
                        </td>
          {if $displayprice eq 1}<td>{if $Service.discount} <span class="discount red"> <span class="prefix">{$currency.prefix}</span> {$Service.credit}<span class="suffix">{$currency.suffix}</span> </span> {/if}<span class="prefix">{$currency.prefix}</span> {$Service.credit-$Service.discount}<span class="suffix">{$currency.suffix}</span> </td>{/if}
                      <td>{$Service.type}</td>
                      <td>{$Service.time}</td>
                    </tr>
                {foreachelse}
                    <tr>
                      <td colspan="4" class="text-center">{$lang.norecordsfound}</td>
                    </tr>
                {/foreach}
              </table>
          {/foreach}
          </div>
      {else}
        <div  class="text-center p-5">{$lang.norecordsfound}</div>
      {/if}

  {/if}

  {if $retail eq '1'}

    <div class="mt-4">
        <a class="btn p-3 btn-warning" href="{$seourl}">
            {$lang.buy} {$lang.now}
        </a>
    </div>
  {/if}

</div>
    </div></div>
