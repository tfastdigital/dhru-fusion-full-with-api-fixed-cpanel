<div class="container"><div class="page-container">

    {if $standalone}
<div class="table-responsive">
<table class="table border-0 table-striped">
	<thead>
  <tr>
    <th>#{$lang.ID}</th>
    <th>{$lang.date}</th>
    <th class="dashboard-view">{$lang.duedate}</th>
    <th class="dashboard-view">{$lang.datepaid}</th>
    <th class="text-right">{$lang.invoicestotal}</th>
    <th class="text-center dashboard-view">{$lang.status}</th>
    <th class="dashboard-view">{$lang.action}</th>

  </tr>
		</thead>

	<tbody>

  {foreach from=$invoicelist key=id item=inv}
  <tr onclick="javascript:window.location='{$inv.seo}'" style="cursor:pointer">
    <td> #{$inv.id} </td>
    <td> {$inv.date} </td>
    <td  class="dashboard-view"> {$inv.duedate} </td>
    <td  class="dashboard-view"> {$inv.datepaid} </td>
    <td class="text-right"> {$inv.total}  </td>
    <td class="text-center dashboard-view"> {if $inv.status eq  'Paid'} <span class="badge badge-success">{$lang.paid}</span> {else} <span class="badge badge-danger">{$inv.status}</span> {/if} </td>
    <td class="dashboard-view"><a   href="{$inv.seo}"> {$lang.view}  </a></td>

  </tr>
  {foreachelse}
       <tr><td colspan="7"> <div class="text-muted text-center"> {$lang.noresultfound}</div></td></tr>
  {/foreach}
  {if $view neq 'paid'}
  <tr>
    <td colspan="5" class="text-right"> <div><span class="text-muted"> {$lang.totaloutstandingbalance}</span> : <span class="badge badge-danger">{$invtotals}</span></div>  </td>
    <td colspan="2" class="dashboard-view"></td>
  </tr>
  {/if}
		</tbody>
</table>
</div>
{else}
<div class="">

  <div class="card">

  <ul class="nav nav-pills flex-nowrap mb-4 bottom-space">
    <li class="nav-item" onclick="getContect('#tab','{$invoicepaid}?standalone=true','#paid',true,'#loader');"> <a class="nav-link  active" data-toggle="tab" href="#paid"> {$lang.paid} </a> </li>
    <li class="nav-item" onclick="getContect('#tab','{$invoiceproforma}?standalone=true','#unpaid',true,'#loader');"> <a  class="nav-link"   data-toggle="tab" href="#unpaid" id="tab4"> {$lang.proforma} </a> </li>
     <li class="nav-item" onclick="getContect('#tab','{$invoicepending}?standalone=true','#pendingpayment',true,'#loader');"> <a  class="nav-link"   data-toggle="tab" href="#pendingpayment" id="tab5"> {$lang.pending} {$lang.payment} </a> </li>
     <li class="nav-item" onclick="getContect('#tab','{$invoicevoid}?standalone=true','#invoicevoid',true,'#loader');"> <a  class="nav-link"   data-toggle="tab" href="#invoicevoid" id="tab8"> Void  </a> </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane    fade show active" id="paid" role="tabpanel" aria-labelledby="paid">
        <script>
          getContect('#tab','{$invoicepaid}?standalone=true','#paid',true,'#loader')
      </script>
    </div>
    <div class="tab-pane    fade" id="unpaid" role="tabpanel" aria-labelledby="unpaid">  </div>

    <div class="tab-pane    fade" id="pendingpayment" role="tabpanel" aria-labelledby="pendingpayment">  </div>
    <div class="tab-pane   fade" id="invoicevoid" role="tabpanel" aria-labelledby="invoicevoid">  </div>
  </div>

  </div>

</div>
{/if}

  </div></div>
