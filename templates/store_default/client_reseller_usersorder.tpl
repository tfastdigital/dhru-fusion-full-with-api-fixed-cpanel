


<div class="tabbable">
    <ul class="nav  nav-tabs">
    {if $myuser.imeiservice eq 1}
        <li class="active"><a href="#tab1" data-toggle="tab">{$lang.imei} {$lang.order}</a></li>
    {/if}
    {if $myuser.fileservice eq 1}
        <li><a href="#tab2" data-toggle="tab">{$lang.file} {$lang.order}</a></li>
    {/if}
    {if $myuser.serverservice eq 1}
        <li><a href="#tab3" data-toggle="tab">{$lang.server} {$lang.order}</a></li>
    {/if}
    </ul>

    <div class="tab-content">
        <div id="tab1" class="tab-pane {if $myuser.imeiservice eq 1}active{/if}">

<table class="table table-bordered" id="history">
    <tr>
    <th></th>
    <th>#{$lang.ID}</th>
      <th>
        <div align="left">
            <select name="status2" id="status2" onchange="setSubmitstatus(this);">
                <option value="all">{$lang.all}</option>
                <option value="available" {if 'available' eq $smarty.post.status} selected="selected" {/if}>{$lang.available}</option>
                <option value="rejected" {if 'rejected' eq $smarty.post.status} selected="selected" {/if}>{$lang.rejected}</option>
                <option value="pending" {if 'pending' eq $smarty.post.status} selected="selected" {/if}>{$lang.pending}</option>
              </select>
        </div>
      </th>
      <th>
          <div align="left">
                  <select name="serviceid" id="service_id" onchange="setSubmitservice(this);" style="width:350px">
                    <option value="">{$lang.all}</option>
                    {foreach from=$imeiservicelist key=id item=Services}
                        <option value="{$id}" {if $id eq $smarty.post.serviceid} selected="selected" {/if}>{$Services}</option>
                    {/foreach}
                  </select>
          </div>
      </th>
      <th>
          <div align="left">
            <form method="post" name="filterorderimei" id="filterorderimei" action="{$searchaction}" >
              {$token}
              <input type="text" name="searchvalue" value="{$lang.search} {$lang.imei}" onfocus="if(this.value=='{$lang.search} {$lang.imei}') this.value=''" onblur="if(this.value=='') this.value='{$lang.search} {$lang.imei}'"/>
            </form>
          </div>
      </th>
      <th align="left"> {if $status neq 'pending'}{$lang.code}{/if}</th>
      {if $status neq 'rejected'}
      	<th align="right">{$lang.action}</th>
      {/if}
    </tr>
    {foreach from=$imeiorderslist key=id item=order}
        <tr id="h_{$id}" class="{$order.status_code}_status">
           <td><a data-target="#modal12" data-toggle="modal" href="vieworder/imei?id={$id}"><i class="icon-plus"></i></a></td>
          <td><a data-target="#modal12" data-toggle="modal" href="vieworder/imei?id={$id}">{$id}</a></td>
          <td align="left"><a data-target="#modal12" data-toggle="modal" href="vieworder/imei?id={$id}"><div style="text-align:left">{$order.status}</div></a></td>
          <td><a data-target="#modal12" data-toggle="modal" href="vieworder/imei?id={$id}">{$order.service}</a></td>
          <td><a data-target="#modal12" data-toggle="modal" href="vieworder/imei?id={$id}">{$order.imei}</a></td>
          <td align="left">{if $order.reply eq 'Pending' or $order.reply eq 'In Process'} - {else} {assign var="length" value=$order.reply|strlen} {if $length gt 15}<div class="reply"><span  class="truncatespan">{$order.reply}</span><span class="fullspan">{$order.reply}</span></div>   {else} {$order.reply} {/if}{/if}</td>
          {if $status neq 'rejected'}
            <td align="right">{$order.action}</td>
          {/if}
        </tr>
    {foreachelse}
    <tr>
      <td colspan="6" align="center">{$lang.norecordsfound}</td>
    </tr>
    {/foreach}
  </table>

        </div>

        <div id="tab2" class="tab-pane">

   <table class="table table-bordered">
    <tr>
    <th></th>
    <th>#{$lang.ID}</th>
      <th>
        <div align="left">
            <select name="status2" id="status2" onchange="setSubmitstatus(this);">
                <option value="all">{$lang.all}</option>
                <option value="available" {if 'available' eq $smarty.post.status} selected="selected" {/if}>{$lang.available}</option>
                <option value="rejected" {if 'rejected' eq $smarty.post.status} selected="selected" {/if}>{$lang.rejected}</option>
                <option value="pending" {if 'pending' eq $smarty.post.status} selected="selected" {/if}>{$lang.pending}</option>
              </select>
        </div>
      </th>
      <th><div align="left">
        <select name="serviceid" id="service_id" onchange="setSubmitservice(this);">
          <option value="">{$lang.all}</option>
             {foreach from=$fileservicelist key=id item=Services}
                <option   value="{$id}" value="{$id}" {if $id eq $smarty.post.serviceid} selected="selected" {/if}>{$Services}</option>
             {/foreach}
        </select>
      </div></th>
      <th><div align="left">
         <form method="post" name="filterorderfile" id="filterorderfile" >
              {$token}
              <input type="text" name="searchvalue" value="{$lang.search} {$lang.file}" onfocus="if(this.value=='{$lang.search} {$lang.file}') this.value=''" onblur="if(this.value=='') this.value='{$lang.search} {$lang.file}'"/>
        </form>
      </div></th>
      <th {if $status eq 'rejected'} align="left" {/if}>{if $status neq 'pending'}<div align="left">{$lang.reply}</div>{/if}</th>
      {if $status neq 'rejected'}
        <th align="right">{$lang.action}</th>
      {/if}
    </tr>
    {foreach from=$fileorderslist key=id item=order}
        <tr id="h_{$id}">
        <td><a data-target="#modal0" data-toggle="modal" href="vieworder/file?id={$id}"><i class="icon-plus"></i></a></td>
        <td><a data-target="#modal0" data-toggle="modal" href="vieworder/file?id={$id}">{$id}</a></td>
          <td align="center"><a data-target="#modal0" data-toggle="modal" href="vieworder/file?id={$id}"><div style="text-align:left">{$order.status}</div></a></td>
          <td><a data-target="#modal0" data-toggle="modal" href="vieworder/file?id={$id}">{$order.service}</a></td>
          <td><a data-target="#modal0" data-toggle="modal" href="vieworder/file?id={$id}">{$order.file}</a></td>
          <td align="left">{if $order.reply eq 'Pending' or $order.reply eq 'In Process'} - {else} {$order.reply}{/if}</td>
          {if $status neq 'rejected'}
            <td align="right" >{$order.action}</td>
          {/if}
        </tr>
        {foreachelse}
        <tr >
          <td colspan="5">{$lang.norecordsfound}</td>
        </tr>
    {/foreach}
  </table>

        </div>

        <div id="tab3" class="tab-pane">


    <table class="table table-bordered">
    <tr>
        <th></th>
        <th>#{$lang.ID}</th>
      <th>
        <div align="left">
            <select name="status2" id="status2" onchange="setSubmitstatus(this);">
                <option value="all">{$lang.all}</option>
                <option value="available" {if 'available' eq $smarty.post.status} selected="selected" {/if}>{$lang.available}</option>
                <option value="rejected" {if 'rejected' eq $smarty.post.status} selected="selected" {/if}>{$lang.rejected}</option>
                <option value="pending" {if 'pending' eq $smarty.post.status} selected="selected" {/if}>{$lang.pending}</option>
              </select>
        </div>
      </th>
      <th><div align="left">
         <select name="serviceid" id="service_id"  onchange="setSubmitservice(this);">
            <option value="">{$lang.all}</option>
                {foreach from=$serverservicelist key=id item=Services}
                	<option   value="{$id}" value="{$id}" {if $id eq $smarty.post.serviceid} selected="selected" {/if}>{$Services}</option>
                {/foreach}
        </select>
      </div></th>
      <th {if $status eq 'rejected'} align="left" {/if}>{if $status neq 'pending'}<div>{$lang.reply}</div>{/if}</th>
      <th align="right">{if $status neq 'rejected'}{$lang.action}{/if}</th>
    </tr>
    {foreach from=$serverorderslist key=id item=order}
    <tr id="h_{$id}">
       <td><a data-target="#modal0" data-toggle="modal" href="vieworder/server?id={$id}"><i class="icon-plus"></i></a></td>
       <td><a data-target="#modal0" data-toggle="modal" href="vieworder/server?id={$id}">{$id}</a></td>
      <td align="center"><a data-target="#modal0" data-toggle="modal" href="vieworder/server?id={$id}"><div style="text-align:left">{$order.status}</div></a></td>
      <td><a data-target="#modal0" data-toggle="modal" href="vieworder/server?id={$id}">{$order.service}</a></td>
      <td {if $status eq 'rejected'} align="left" {/if}>{if $status neq 'pending'}{$order.reply}{/if}</td>
      {if $status neq 'rejected'}<td align="right" >{$order.action}</td>{/if}
    </tr>
    {foreachelse}
    <tr>
      <td colspan="5">{$lang.norecordsfound}</td>
    </tr>
    {/foreach}
  </table>
        </div>
    </div>
</div>



