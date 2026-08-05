
<div class="container"><div class="page-container">
<div  class="card">
  <form method="post">
	<div class="d-flex justify-content-end">
        <div>
            {$myuserdtl}
        </div>
        <div class="mx-2">
    		<select name="search" class="form-control  mb-2 mr-sm-2 no-chosen ">
    		  <option value="">{$lang.select}</option>
    		  <option value="1">{$lang.addcredit}</option>
    		  <option value="2">{$lang.rebatecredit}</option>
    		</select>
        </div>
        <div>
		  <input type="submit" class="btn btn-secondary" name="find" value="{$lang.search}" />
        </div>
	</div>
  </form>
  <div class="table-responsive mt-3">
    <table class="table  table-striped">
      <thead>
        <tr>
          <th>{$lang.date}</th>
          <th>{$lang.description}</th>
          <th>{$lang.type}</th>
          <th>{$lang.amount}</th>
          <th>{$lang.relid}</th>
          <th>{$lang.user}</th>

        </tr>
      </thead>
      <tbody>

      {foreach from=$statement key=id item=stat}
      <tr>
        <td>{$stat.date}</td>
        <td>{$stat.description}</td>
        {if $stat.status eq  'DR'}
        <td><span class="label label-success">{$stat.type}</span></td>
        {else}
        <td><span class="label label-important">{$stat.type}</span></td>
        {/if}
        <td> {$stat.amount} </td>
        <td>{$stat.relid}</td>
        <td>{$stat.reluser}</td>

      </tr>
      {foreachelse}
      <tr>
        <td colspan="6" class="text-center">{$lang.norecordsfound}</td>
      </tr>
      {/foreach}
        </tbody>

    </table>
  </div>
  <div   class="pagination">{$paginate}</div>
</div>
  </div></div>
