<div class="dashboard-content pt-4">

    {if $notification.success}
        <div class="alert alert-success border-0 shadow-sm mb-4">{$notification.success}</div>
    {elseif $notification.error}
        <div class="alert alert-danger border-0 shadow-sm mb-4">{$notification.error}</div>
    {elseif $notification.info}
        <div class="alert alert-info border-0 shadow-sm mb-4">{$notification.info}</div>
    {/if}

    <!-- Calculate Stats -->
    {assign var="available" value=$userstats.imeiservice.total.4+$userstats.fileservice.total.4+$userstats.serverservice.total.4}
    {assign var="pending" value=$userstats.imeiservice.total.0+$userstats.fileservice.total.0+$userstats.serverservice.total.0+$userstats.imeiservice.total.1+$userstats.fileservice.total.1+$userstats.serverservice.total.1}
    {assign var="rejected" value=$userstats.imeiservice.total.2+$userstats.fileservice.total.2+$userstats.serverservice.total.2}
    {assign var="total" value=$userstats.imeiservice.totalorder+$userstats.fileservice.totalorder+$userstats.serverservice.totalorder}

    <!-- Stats Row -->
    <div class="row">
        <!-- Balance Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">{$lang.yourcurrentbalance}</div>
                        <div class="stat-value">
                            {$userdetails.currency.prefix} {$userdetails.credit.credit|string_format:"%.2f"} {$userdetails.currency.suffix}
                        </div>
                    </div>
                    <div class="stat-icon bg-light-primary">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100" onclick="window.location.href='{$imeiorderavailable}'" style="cursor:pointer">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">{$lang.orderprocessuccess}</div>
                        <div class="stat-value">{$available|default:'0'} <span class="text-muted text-sm">/ {$total}</span></div>
                    </div>
                    <div class="stat-icon bg-light-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100" onclick="window.location.href='{$imeiorderpending}'" style="cursor:pointer">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">{$lang.orderinproces}</div>
                        <div class="stat-value">{$pending|default:'0'} <span class="text-muted text-sm">/ {$total}</span></div>
                    </div>
                    <div class="stat-icon bg-light-warning">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejected Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100" onclick="window.location.href='{$imeiorderrejected}'" style="cursor:pointer">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">{$lang.orderprocesfail}</div>
                        <div class="stat-value">{$rejected|default:'0'} <span class="text-muted text-sm">/ {$total}</span></div>
                    </div>
                    <div class="stat-icon bg-light-danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Quick Actions</h5>
                    <div class="d-flex flex-wrap">
                         {if $addfund}
                            <button class="btn btn-primary mr-3 mb-2" type="button" onclick="{if $resellerstore}window.location.href='{$addfundslink}'{else}$('#modal-addfund').modal('show'){/if}">
                                <i class="fas fa-plus-circle mr-2"></i> {$lang.buycredit}
                            </button>
                         {/if}
                         <a href="client_order_imei" class="btn btn-outline-primary mr-3 mb-2">
                            <i class="fas fa-mobile-alt mr-2"></i> {$lang.imei} {$lang.order}
                         </a>
                         <a href="client_order_server" class="btn btn-outline-secondary mb-2">
                            <i class="fas fa-server mr-2"></i> {$lang.server} {$lang.order}
                         </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
