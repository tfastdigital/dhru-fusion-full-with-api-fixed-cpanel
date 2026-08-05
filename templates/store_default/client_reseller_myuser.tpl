<div class="container"><div class="page-container">

    <div class="card">

        <form   class="form-search" method="post">
            <div class="form-inline">
                <input type="text" name="search" class="form-control ml-auto mb-2 mr-sm-2"/>
                <input type="submit" class="btn btn-secondary mb-2" name="find" value="{$lang.search}"/>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table  table-striped">
                <thead>
                <tr>
                    <th>{$lang.username}</th>
                    <th class="text-center">{$lang.balance}</th>
                    <th class="text-center">{$lang.unpaid} {$lang.amount}</th>
                    <th class="text-center">{$lang.status}</th>
                    <th>{$lang.action}</th>
                </tr>
                </thead>
                <tbody>

                {foreach from=$listuser key=id item=user}
                    <tr>
                        <td>
                            <a href="{$user.link}">{$user.username} [{$user.email}]</a>
                        </td>
                        <td class="text-center">{$cur_prefix}{$user.credit}</td>
                        <td class="text-center"><a href="{$user.statuslink}">{$cur_prefix}{$user.unpaid}</a></td>
                        <td class="text-center"> {$user.status2}  </td>
                        <td>
                            <a href="{$user.link}">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            <a href="{$user.seo}">View</a>
                        </td>
                    </tr>
                    {foreachelse}
                    <tr>
                        <td colspan="5" class="text-center">{$lang.norecordsfound}</td>
                    </tr>
                {/foreach}
                </tbody>

            </table>
        </div>
        <div class="pagination">{$paginate}</div>
    </div>

    </div></div>
