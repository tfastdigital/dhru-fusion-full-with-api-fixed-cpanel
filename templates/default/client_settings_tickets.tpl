<div class="table-responsive">
    <table class="table  table-striped">
        <thead>
        <tr>
            <th>#{$lang.ID}</th>
            <th>{$lang.date}</th>
            <th class="w-100">{$lang.subject}</th>
            <th class="text-left">{$lang.status}</th>

        </tr>
        </thead>
        <tbody>
        {foreach from=$ticketlist key=id item=t}
        <tr>
            <td>#{$id}</td>
            <td>{$t.date}</td>
            <td><a href="{$t.seo}" data-toggle="tooltip"
                   data-original-title="click to view ticket details">{$t.subject}</a></td>
            <td class="text-left">{if $t.sid eq '1'}<label
                        class="badge badge-success">{$lang.open}</label>{/if}{if $t.sid eq '3'}<label
                        class="badge badge-primary">{$lang.answered}</label>{/if}{if $t.sid eq '2'}<label
                        class="badge badge-secondary">{$lang.close}</label>{/if}{if $t.sid eq '4'}<label
                        class="badge badge-info">{$lang.customer} {$lang.reply}</label>{/if}</td>

        </tr>
        {foreachelse}
        <tr>
            <td colspan="4" class="text-center">{$lang.norecordsfound}</td>
        </tr>
        </tbody>
        {/foreach}

    </table>
</div>
