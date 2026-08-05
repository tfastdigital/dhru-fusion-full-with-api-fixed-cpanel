<div class="dashboard-content pt-4">

    {literal}
    <script type="text/javascript">
        $(function() {
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
            $('#from,#to').datepicker({ format: 'yyyy-mm-dd'}).on('changeDate', function(e){
                $(this).datepicker('hide');
            });
        });
    </script>
    {/literal}

    <!-- Search Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{$lang.search}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <form method="post" name="filterorderimei" id="filterorderimei" action="{$searchaction}">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="text" autocomplete="off" data-date-format="yyyy-mm-dd" name="from" placeholder="{$lang.from} {$lang.date}" id="from" class="form-control mb-2" />
                            </div>
                            <div class="form-group col-12">
                                <input type="text" name="to" autocomplete="off" id="to" data-date-format="yyyy-mm-dd" placeholder="{$lang.to} {$lang.date}" class="form-control mb-2" />
                            </div>
                        </div>
                        {if $serverservice neq 2 && $serverservice neq 1 }
                            <textarea class="form-control mb-3" name="searchvalue" placeholder="{$lang.search} {$lang.imei}"></textarea>
                        {/if}
                        <button type="submit" class="btn btn-success w-100" name="searchbulk">{$lang.search}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Modal -->
    <div id="modalverification" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{$lang.verify} {$lang.orderdetails}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span> </button>
                </div>
                <div class="modal-body"> </div>
            </div>
        </div>
    </div>

    <!-- Bulk Verification Modal -->
    <div id="modalverificationbulk" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">{$lang.bulk} {$lang.verify}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span> </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="bulkids" id="buld-ids">
                    <textarea placeholder="Reason" name="verifyreason" class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 text-white">Order History</h4>
        <div>
            <button class="btn btn-light btn-sm mr-2" data-toggle="modal" data-target="#myModal">
                <i class="fas fa-search"></i> {$lang.search}
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-file-export"></i> {$lang.export}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{$viewexportlink}">Export View</a>
                    <a class="dropdown-item" href="{$exportlink}?standalone=true" data-toggle="modal" data-target="#modal-ajax">Advance Export</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    {if $notification.success}
        <div class="alert alert-success border-0 shadow-sm mb-4">{$notification.success}</div>
    {elseif $notification.error}
        <div class="alert alert-danger border-0 shadow-sm mb-4">{$notification.error}</div>
    {/if}

    <!-- Orders Table Card -->
    <div class="card">
        <div class="card-body p-0">
            {if $withtab}
            {else}
                <form method="get" id="filterorderimei2" action="{$statuslink}">
                    <input type="hidden" name="serviceid" id="serviceids" value="{$smarty.get.serviceid}"/>
                    <input type="hidden" name="status" id="status" value="{$sts}"/>
                    <input type="hidden" name="searchvalue" id="searchvalue" value=""/>
                    {$token}
                </form>
            {/if}

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tcs-table">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" width="80">#ID</th>
                            <th width="150">
                                <select name="status2" class="form-control form-control-sm border-0 bg-transparent font-weight-bold" id="status2" onChange="setSubmitstatus(this);">
                                    <option value="all">{$lang.status}: All</option>
                                    <option value="available" {if 'available' eq $status}selected{/if}>Available</option>
                                    <option value="rejected" {if 'rejected' eq $status}selected{/if}>Rejected</option>
                                    <option value="pending" {if 'pending' eq $status}selected{/if}>Pending</option>
                                </select>
                            </th>
                            <th>
                                <select name="serviceid" id="service_id" class="form-control form-control-sm border-0 bg-transparent font-weight-bold" onchange="setSubmitservice(this);">
                                    <option value="">{$lang.service}: All</option>
                                    {foreach from=$imeiservicelist key=id item=Services}
                                        <option value="{$id}" {if $id eq $smarty.get.serviceid}selected{/if}>{$Services}</option>
                                    {/foreach}
                                </select>
                            </th>
                            <th>{$lang.imei}</th>
                            <th class="text-right">{$lang.credit}</th>
                            <th class="text-right">{$lang.date}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$imeiorderslist key=id item=order}
                            <tr>
                                <td class="text-center">
                                    <a href="{$order.seo}?standalone=true" data-target="#modal-ajax" data-toggle="modal" class="font-weight-bold text-body">
                                        {$order.encnum|default:$id}
                                    </a>
                                </td>
                                <td>
                                    {if $order.status eq 'Available' || $order.status eq 'Success'}
                                        <span class="badge badge-success">{$order.status}</span>
                                    {elseif $order.status eq 'Rejected' || $order.status eq 'Canceled'}
                                        <span class="badge badge-danger">{$order.status}</span>
                                    {elseif $order.status eq 'Pending' || $order.status eq 'In Process'}
                                        <span class="badge badge-warning text-white">{$order.status}</span>
                                    {else}
                                        <span class="badge badge-secondary">{$order.status}</span>
                                    {/if}
                                </td>
                                <td>{$order.service}</td>
                                <td class="font-monospace">
                                    {if $serverservice neq 2 && $serverservice neq 1}
                                        {$order.imei}
                                    {else}
                                        {$order.qnt}
                                    {/if}
                                </td>
                                <td class="text-right text-primary font-weight-bold">
                                    {if $order.points gt 0}{$order.points} Pts{else}{$order.display_credit}{/if}
                                </td>
                                <td class="text-right text-muted small">{$order.date}</td>
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">{$lang.norecordsfound}</td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
        
        {if !$standalone}
            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                <div class="pagination-wrapper">{$paginate}</div>
                <div>
                    <select name="autorefresh" class="form-control form-control-sm" onchange="javascript: setCookies(this.value);">
                        <option value="">Auto Refresh: Off</option>
                        <option value="1">1 Min</option>
                        <option value="5">5 Min</option>
                    </select>
                </div>
            </div>
        {/if}
    </div>
</div>
