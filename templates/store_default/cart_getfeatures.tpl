
<div>
  <form method="post" name="" id="compares">
  <table class="table border-0  product-features">
    <input type="hidden" name="serviceid" value="{$serviceid}" />
        <thead>
            <tr>
                <th>Feature</th>
                <th>Value</th>
                <th></th>
            </tr>
        </thead>
    {foreach from=$features key=name item=fields}
        <tr>
          <td><span> {$fields.name}: </span></td>
          <td>{$fields.value}</td>
          <td></td>
        </tr>
    {/foreach}
      </table>

  </form>
</div>

