<div class="container"><div class="page-container">
    <div class="card">
        <div class="text-right">Point Balance :
            {if $crbalance}
                <span class="text-success">{$crbalance}</span>
            {else}
                <span class="text-danger">-{$drbalance}</span>
            {/if}
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{$lang.order}</th>
                    <th>{$lang.date}</th>
                    <th>{$lang.time}</th>
                    <th class="text-right">{$lang.point}</th>
                    <th  class="w-100"></th>
                </tr>
                </thead>
                <tbody>

                {foreach from=$statement key=id item=stat}
                    <tr>
                        <td class="no-wrap">{$stat.orderid}</td>
                        <td class="no-wrap">{$stat.date}</td>
                        <td  class="no-wrap">{$stat.time}</td>
                        <td class="text-right">{if $stat.cr gt 0}<span style="color: green">{$stat.cr}</span> {else}
                                <span style="color: red">-{$stat.dr}</span> {/if}</td>
                        <td></td>

                    </tr>
                    {foreachelse}
                    <tr>
                        <td colspan="4" class="text-center">{$lang.norecordsfound}</td>
                    </tr>
                {/foreach}
                </tbody>

            </table>
        </div>
        <div class="pagination">{$paginate}</div>
    </div>

    </div></div>
