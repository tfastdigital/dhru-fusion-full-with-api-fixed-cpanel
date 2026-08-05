<div class="container"><div class="page-container">

  <div class="card">

<div class="table-responsive">
  <table class="table   table-striped">
      <thead>
    <tr>
      <th>#{$lang.ID}</th>
      <th>{$lang.username}</th>
      <th>{$lang.action}</th>
    </tr>
      </thead>
    {foreach from=$listuser key=id item=user}
        <tr >
          <td>{$user.id}</td>
          <td>{$user.username} [{$user.email}]</td>
          <td>{$user.status} </td>
        </tr>
    {foreachelse}
        <tr >
          <td colspan="5" class="text-center">{$lang.norecordsfound}</td>
        </tr>
    {/foreach}
  </table>
</div>
</div>
  </div></div>
