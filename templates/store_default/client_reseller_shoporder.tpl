
<div id="tabcontent">
    <form  method="post" name="store" id="store">
        <div   class="alert"></div>
        <table class="table table-bordered">
          <tr>
            <th>{$lang.user} </th>
            <th>{$lang.product} </th>
            <th>{$lang.date} </th>
            <th>{$lang.my} {$lang.earnings}</th>
          </tr>
          {foreach from=$myorders key=id item=order}
           <tr>
              <td>{$order.user}</td>
              <td>{$order.service} [#{$order.order_id}]</td>
              <td>{$order.date}</td>
              <td>{$order.commission|string_format:"%.2f"} [{$order.disc|string_format:"%.2f"}%]</td>
            </tr>
          {/foreach}
        </table>
    </form>
    </div>

</div>
