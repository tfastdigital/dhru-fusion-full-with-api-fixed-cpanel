{literal}
    <script>
        $("a[data-target*='modal']").click(function(ev) {
    		var cur = $(this).attr('data-target');
    		ev.preventDefault();
    		var target = $(this).attr("href");
            getContect('#tab',target,cur+" .modal-body",true,'#loader');
    	});
    </script>
{/literal}


  {if $notification.success}
    <div   class="alert alert-success" >{$notification.success}</div>
  {elseif $notification.error}
    <div   class="alert alert-error" >{$notification.error}</div>
  {/if}




<div class="table-responsive">
  <table class="table   table-striped table-hover">
	 <thead>
        <tr>
          <th>#{$lang.ID}</th>
          <th>{$lang.date}</th>
          <th class="text-center">{$lang.payment} {$lang.status}</th>
          <th class="text-center">{$lang.fulfillment} {$lang.status}</th>
          <th class="text-right">{$lang.amount}</th>
          <th class="text-center">{$lang.action}</th>
         </tr>
	 </thead>
	  <tbody>
        {foreach from=$productorderslist key=id item=order}
            <tr id="h_{$id}" >
              <td>#{$order.id}</td>
                <td>{$order.date} <br /><small>{$order.time}</small></td>
              <td class="text-center">
               <label class="badge badge-{$order.badge}">{$order.paymenstatus}</label>
              </td>
                <td class="text-center">{$order.orderstatus}</td>

                <td class="text-right">{$order.total} {$userdetails.currency.code}</td>

                <td class="text-center">
              <a data-target="#modal-ajax" data-whatever="{$lang.order} {$lang.details} #{$order.id}" data-toggle="modal" href="{$order.seo}?standalone=true"><i class="fal fa-eye"></i></a>
              </td>
            </tr>
        {foreachelse}
            <tr >
              <td colspan="6" class="text-center">{$lang.norecordsfound}</td>
            </tr>
        {/foreach}
      </tbody>
  </table>
</div>

