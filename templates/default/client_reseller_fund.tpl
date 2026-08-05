<div class="container"><div class="page-container">
    <div class="card">
  <div class="table-responsive">

        <table class="table   table-striped table-hover">
          <thead>
          <tr>
            <th>{$lang.user} </th>
            <th>{$lang.amount} </th>
            <th>{$lang.date} </th>
            <th>{$lang.invoicestransid}</th>
          </tr>
          </thead>
          {foreach from=$funddetail key=id item=det}
              <tr>
              <td>{$det.user}</td>
              <td>{$det.amount}</td>
              <td>{$det.date}</td>
              <td>{$det.tid}</td>
              </tr>
          {/foreach}
        </table>

    </div>
    </div>
    </div></div>
