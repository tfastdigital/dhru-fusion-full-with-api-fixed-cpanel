
<form method="post" id="frms">
  <input type="hidden" name="userid" value="{$userid}" />
  <div   class="alert"></div>
  {$token}


<div class="form-inline frm-inline">
	<input placeholder="{$lang.payment}" type="text" name="payment"  class="form-control  mb-2 mr-sm-2"/>
	<input type="text" placeholder="{$lang.note}" name="note" class="form-control  mb-2 mr-sm-2"> </input>
	<button type="submit"  class="btn btn-primary mb-2" id="addcredit"  onclick="SubmitForm('#addcredit','{$reselleruseraddpaylink}','#frms','.alert','true','#loader');" name="addcredit" value="{$lang.save}" >{$lang.save}</button>
</div>

</form>
</div>
<div class="table-responsive">
  <table class="table  table-striped">
	  <thead>
    <tr>
      <th>{$lang.date}</th>
      <th>{$lang.note}</th>
      <th>{$lang.status}</th>
      <th>{$lang.amount}</th>
    </tr>
		  </thead>
	  <tbody>
    {foreach from=$statement key=id item=stat}
    <tr>
      <td>{$stat.date}</td>
      <td>{$stat.note}</td>
      <td><div> {if $stat.status eq 'DR'} <span class="textred">{$stat.status}</span> {else} <span class="textgreen">{$stat.status}</span> {/if} </div></td>
      <td> {$stat.amount} {$currency.code} </td>
    </tr>
    {foreachelse}
    <tr>
      <td colspan="4">{$lang.norecordsfound}</td>
    </tr>
    {/foreach}
		  </tbody>
  </table>
</div>
