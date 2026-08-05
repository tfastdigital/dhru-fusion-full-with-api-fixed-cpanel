<div class="container"><div class="page-container">

    <div class="card">

        {if $notification.success}
            <div  class="alert alert-success">{$notification.success}</div>
        {elseif $notification.error}
            <div   class="alert alert-danger">{$notification.error}</div>
        {/if}
        <form class="form-search" method="post">
            <div class="row">


                <div class="col-lg-6 mb-4  bottom-space">

                    <div class="d-flex">

                        <div class="form-group w-100 mb-0">
                            <div class="input-group">
                                <select name="search" class="form-control no-chosen">
                                    <option value="">{$lang.select}</option>
                                    <option value="1">{$lang.addfunds}</option>
                                    <option value="2">{$lang.creditapply}</option>
                                    <option value="3">{$lang.neworderplaces}</option>
                                    <option value="4">{$lang.subscription}</option>
                                    {if $userdetails.usertype eq '1'}
                                        <option value="5">{$lang.newusercreated}</option>
                                        <option value="6">{$lang.credittransfer}</option>
                                        <option value="7">{$lang.creditrebated}</option>
                                    {/if}
                                    <option value="8">{$lang.onlysellcredit}</option>
                                </select>
                                <div class="input-group-append">
                                    <input type="submit" class="btn btn-secondary" name="find" value="{$lang.search}"/>
                                </div>
                            </div>
                        </div>




                    </div>

                </div>


                <div class="col-lg-6  mb-2 text-right">
                    <a target="_blank" class="btn  btn-light p-2 mb-2" href="{$downloadlink}">
                        <i class="fal fa-file-excel"  aria-hidden="true"></i> {$lang.exporttoexcel}
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table  table-striped table-hover">
                <thead>
                <tr>
                    <th>{$lang.date}</th>
                    <th>{$lang.description}</th>
                    <th class="text-center">{$lang.type}</th>
                    <th>{$lang.amount}</th>
                    <th>{$lang.balance}</th>
                    <th>{$lang.relid}</th>

                </tr>
                </thead>
                <tbody>



                {foreach from=$statement key=id item=stat}
                <tr>
                    <td>{$stat.date}</td>
                    <td>{if $stat.description|@stristr:"withdrawal"}
                            {$stat.description}
                        {else}
                            {if $stat.relid neq 0}
                                {if $stat.invoice}
                                    <a href="{$stat.seoinvoice}" target="_blank">{$stat.description}</a>
                                {else}
                                    <a data-toggle="modal" data-target="#modal-ajax"
                                       data-whatever="{$lang.order} {$lang.details}"
                                       href="{$stat.seo}?standalone=true"> {$stat.description} </a>
                                {/if}
                            {else}
                                {$stat.description}
                            {/if}
                        {/if}
                        {if $stat.usernote}
                            <div><small>Note : {$stat.usernote}</small></div>
                        {/if}
                    </td>
                    <td class="text-center"> {if $stat.type eq 'DR'}
                            <label class="badge badge-danger">{$stat.type}</label>
                        {else}
                            <label class="badge badge-success">{$stat.type}</label>
                        {/if} </td>
                    <td> {$stat.amount} </td>
                    <td>{$stat.balance}</td>
                    <td> {if $stat.description|@stristr:"withdrawal"}
                            {$stat.relid}
                        {else}
                            {if $stat.relid neq 0}
                                {if $stat.invoice}
                                    <a href="{$stat.seoinvoice}" target="_blank">{$stat.relid}</a>
                                {else}
                                    <a data-toggle="modal" data-target="#modal-ajax"
                                       data-whatever="{$lang.order} {$lang.details}"
                                       href="{$stat.seo}?standalone=true"> {$stat.relid} </a>
                                {/if}
                            {else}
                                {$stat.relid}
                            {/if}
                        {/if} </td>
                </tr>
                {foreachelse}
                </tbody>
                <tr>
                    <td colspan="7" class="text-center text-muted">{$lang.norecordsfound}</td>
                </tr>
                {/foreach}
            </table>
        </div>
        <div align="center" class="pagination">{$paginate}</div>

    </div>

    </div></div>
