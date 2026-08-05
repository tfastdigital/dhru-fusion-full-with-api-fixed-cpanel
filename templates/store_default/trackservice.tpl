



<div class="container"><div class="page-container">

<div class="card card-simple-form">

    <div class="row">

<div class="col-lg-6  m-auto form-sm">



  {if $notification.success}
    <div   class="alert1 alert alert-success" >{$notification.success}</div>
  {elseif $notification.error}
    <div   class="alert1 alert alert-danger" >{$notification.error}</div>
  {/if}

<div class="row">
<div class="col-lg-6">
    {if !$eCommerce}
     <form method="post"   name="track2" id="tracker2" >
      {$token}
         <div class="form-group ">
            <label>{$lang.imei}:</label>
            <input type="text" class="form-control " size="4" name="imei"  />
         </div>
         <div class="form-group ">
            <label>{$lang.masterpin}:</label>
            <input type="text" class="form-control " size="4" name="pin"  />
         </div>
         <button class="btn btn-primary w-100" type="submit" name="view" value="{$lang.view} {$lang.status}" >{$lang.view} {$lang.status}</button>
        </form>
    {/if}
</div>


<div class="col-lg-6 mb-4 bottom-space">
{if $cart}

        <form method="post"  name="track" id="tracker" >
         {$token}
              <div class="form-group ">
                    <label> {$lang.shopping} {$lang.orderid}: </label>
                     <input  type="text" class="form-control " name="oid" size="12" />
             </div>
              <div class="form-group ">
                    <label>{$lang.username} or {$lang.email}:</label>
                     <input type="text" class="form-control " name="user" />
             </div>
           <button class="btn btn-primary w-100" type="submit" name="views" value="{$lang.track} {$lang.order}" >{$lang.track} {$lang.order}</button>
        </form>

    {/if}
</div></div>

</div>

</div>

</div>

{if $flag}
     <div class="table-responsive">
        <table class="table table-borderd table-striped">
        	{foreach from=$details key=id item=detail}
    		    <tr>
    		         <td>{$lang.imei}:</td>
    		         <td><span>{$detail.imei}</span></td>
        		     {if $detail.reply}
    		           <td> {$lang.code}:</td>
    		           <td> <span>{$detail.reply} ({$detail.status})</span></td>
        		     {else}
                        <td> </td>
                        <td>{$detail.status}</td>
        		     {/if}
    		      </tr>
    	    {/foreach}
        </table>
      </div>
{/if}

{if $invoiceid}
   <h4> {$lang.orderid}: #{$invoiceid}</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                 <tr>
        	         <th>{$lang.item}:</th>
        	         <th><span> {$lang.status}</span></th>
    		     </tr>
             </thead>
        	{foreach from=$details key=id item=detail}
		      <tr>
    	           <td>{$detail.service}</td>
    	           <td>{$detail.status}</td>
		      </tr>
    	    {/foreach}
        </table>
    </div>
{/if}

    </div></div>

