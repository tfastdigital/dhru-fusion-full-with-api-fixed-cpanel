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
<div id="modal12" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
    <h3>{$lang.orderdetails}</h3>
  </div>
  <div class="modal-body" style="max-height:500px;overflow-y:auto"> </div>
  <div class="modal-footer"> <a href="#" data-dismiss="modal" class="btn">{$lang.close}</a> </div>
</div>
{if $notification.success}
<div    class="alert alert-success" >{$notification.success}</div>
{elseif $notification.error}
<div    class="alert alert-error" >{$notification.error}</div>
{/if}
<div class="searchForm">
  <form method="post" name="filterorderserver" id="filterorderserver" action="reseller/myuserorders?show=server" >
    {$token}
    <select name="user" class="form-control " id="service_id" >
      <option value="">{$lang.select}</option>

		{foreach from=$myusers key=id item=user}

      <option   value="{$id}" >{$user.username}</option>

		{/foreach}

    </select>
    <input type="text" class="form-control " name="searchvalue" />
    <input type="submit" class="btn" name="search" value="{$lang.search}" />
  </form>
</div>
<div class="table-responsive">
  <table class="table border-0 table-striped">
    <thead>
      <tr>
        <th></th>
        <th width="20">#{$lang.ID}</th>
        <th><div align="left">{$lang.service}</div></th>
        <th align="center"></th>
        <th {if $status eq 'rejected'} align="right" {/if}>{if $status neq 'pending'}
          <div>{$lang.reply}</div>
          {/if}</th>
      </tr>
    </thead>
    <tbody>

    {foreach from=$serverorderslist key=id item=order}
    <tr id="h_{$id}">
      <td><a data-target="#modal12" data-toggle="modal" href="vieworder/server?store=true&id={$id}">More</a></td>
      <td>{$id}</td>
      <td>{$order.service}</td>
      <td {if $status eq 'rejected'} align="right" {/if}>{if $status neq 'pending'}{$order.reply}{/if}</td>
    </tr>
    {foreachelse}
    <tr>
      <td colspan="5" class="text-center">{$lang.norecordsfound}</td>
    </tr>
    {/foreach}
    <tr>
      <td colspan="5" align="center" class="pagination">{$paginate}</td>
    </tr>
      </tbody>

  </table>
</div>
