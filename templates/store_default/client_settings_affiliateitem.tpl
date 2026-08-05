  <div class="table-responsive">
  <table class="table table-bordered table-striped  table-hover">
    <thead>
    <tr>
      <th> {$lang.service} </th>
      <th> {$lang.price} </th>
      <th class="text-right"> {$lang.commision} </th>
    </tr>
    </thead>
     {foreach from=$servicelist key=ids item=grps}
        <thead>   
            <tr>
                <td colspan="3"><h3>{$ids}</h3></td>
            </tr>
         </thead>   
        {foreach from=$grps key=id item=serv}
            <tr>
              <td><div>{$serv.service_name}</div></td>
              <td>{$serv.credit}</td>
              <td class="text-right"> {$serv.affiliate_comission}% [{math equation=$serv.affiliate_comission*$serv.credit/100 format="%.2f"}]</td>
            </tr>
        {foreachelse}
        <tr>
          <td colspan="3" class="text-center">{$lang.norecordsfound}</td>
        </tr>
        {/foreach}
    {/foreach}    
  </table>
  </div>