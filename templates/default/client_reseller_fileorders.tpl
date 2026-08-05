{literal}
<script>
function showOrderdetail(id,h_id){
    $.post(urlprefix+'vieworder/file?store=true&id='+id , function (data, textStatus) {
        $(h_id).html(data);
    });
}
function hideOrderdetail(id,h_id){
    $.post(urlprefix+'vieworder/file?store=true&disply=mini&id='+id , function (data, textStatus) {
        $(h_id).html(data);
    });
}
$("a[data-target*='modal']").click(function(ev) {
    		var cur = $(this).attr('data-target');
    		ev.preventDefault();
    		var target = $(this).attr("href");
            getContect('#tab',target,cur+" .modal-body",true,'#loader',true);
    	});
</script>
{/literal}

<div id="modal12" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
        <h3>{$lang.orderdetails}</h3>
    </div>
    <div class="modal-body" style="max-height:500px;overflow-y:auto">

    </div>
    <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn">{$lang.close}</a>
    </div>
</div>

  {if $notification.success}
  	<div    class="alert alert-success" >{$notification.success}</div>
  {elseif $notification.error}
  	<div    class="alert alert-error" >{$notification.error}</div>
  {/if}
  <div class="searchForm">
    <h6>{$lang.filterlist}</h6>
    <form method="post" name="filterorderfile" id="filterorderfile" action="reseller/myuserorders?show=file" >
      {$token}
      <select name="user" id="service_id" >
      <option value="">{$lang.select}</option>
         {foreach from=$myusers key=id item=user}
            <option   value="{$id}" >{$user.username}</option>
         {/foreach}
      </select>
      <input type="text" name="searchvalue" />
      <input type="submit" class="btn" name="search" value="{$lang.search}" />
    </form>
  </div>
  <table class="table table-bordered">
    <tr>
        <th></th>
      <th width="20">#{$lang.ID}</th>
      <th><div align="left">{$lang.service}</div></th>
      <th><div align="left">{$lang.file}</div></th>
      <th {if $status eq 'rejected'} align="left" {/if}>{if $status neq 'pending'}<div align="right">{$lang.reply}</div>{/if}</th>

    </tr>
    {foreach from=$fileorderslist key=id item=order}
        <tr id="h_{$id}">
         <td><a data-target="#modal12" data-toggle="modal" href="vieworder/file?store=true&id={$id}"><i class="icon-plus"></i></a></td>
          <td>{$id}</td>
          <td>{$order.service}</td>
          <td>{$order.file}</td>
          <td {if $status eq 'rejected'} align="right" {/if}>{if $status neq 'pending'}{$order.reply}{/if}</td>

        </tr>
        {foreachelse}
        <tr >
          <td colspan="6">{$lang.norecordsfound}</td>
        </tr>
    {/foreach}
      <tr>
      <td colspan="6" align="center" class="pagination">{$paginate}</td>
    </tr>
  </table>

