{literal}
<script>
function showOrderdetail(id,h_id){
    $.post( urlprefix+'vieworder/imei?store=true&id='+id , function (data, textStatus) {
        $(h_id).html(data);
    });
}
function hideOrderdetail(id,h_id){
    $.post( urlprefix+'vieworder/imei?store=true&disply=mini&id='+id , function (data, textStatus) {
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

<div class="mg">
  {if $notification.success}
  <div    class="alert alert-success" >{$notification.success}</div>
  {elseif $notification.error}
  <div    class="alert alert-error" >{$notification.error}</div>
  {/if}
  <div class="searchForm">
    <form method="post" name="filterorderimei" id="filterorderimei" action="reseller/myuserorders?show=imei" >
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
  <table class="table">
    <tr>
        <th></th>
      <th width="20">#{$lang.ID} </th>
      <th>{$lang.service}</th>
      <th>{$lang.imei}</th>
      <th>{$lang.reply}</th>
    </tr>
    {foreach from=$imeiorderslist key=id item=order}
        <tr id="h_{$id}">
        <td><a data-target="#modal12" data-toggle="modal" href="vieworder/imei?store=true&id={$id}">More</a></td>
          <td>{$id}</td>
          <td>{$order.service}</td>
          <td>{$order.imei}</td>
          <td align="right">{$order.reply}</td>

        </tr>
    {foreachelse}
    <tr>
      <td colspan="6" align="center">{$lang.norecordsfound}</td>
    </tr>
    {/foreach}
    <tr>
      <td colspan="6" align="center" class="pagination">{$paginate}</td>
    </tr>
  </table>
  </div>
