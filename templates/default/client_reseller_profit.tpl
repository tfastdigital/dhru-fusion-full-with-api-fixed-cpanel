<div class="container"><div class="page-container">
 <div class="card">
  <div class="table-responsive">
    <table class="table border-0 table-striped">
      <thead>
        <tr>
          <th>{$lang.date}</th>
          <th>{$lang.user}</th>
          <th>{$lang.type}</th>
          <th class="w-100">{$lang.service}</th>
          <th>{$lang.profit}</th>
        </tr>
      </thead>
      <tbody>

      {foreach from=$listprofit key=id item=stat}
      <tr>
        <td class="no-wrap">{$stat.date}</td>
        <td class="no-wrap">{$stat.user}</td>
        <td class="no-wrap">{$stat.type}</td>
        <td>{$stat.service}</td>
        <td  class="no-wrap">{$stat.amount}</td>
      </tr>
      {foreachelse}
      <tr>
        <td  class="text-center" colspan="5">{$lang.norecordsfound}</td>
      </tr>
      {/foreach}
      </tbody>

    </table>
  </div>
  <div  class="pagination">{$paginate}</div>
</div>
  </div></div>
