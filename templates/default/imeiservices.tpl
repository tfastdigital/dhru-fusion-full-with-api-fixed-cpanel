<div class="dashboard-content pt-4">

    <!-- Search & Filter Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3 mb-md-0">
                    <label class="form-label text-muted">{$lang.search}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" id="searchservicebox" class="form-control border-left-0" placeholder="{$lang.search} {$lang.service}">
                    </div>
                </div>
                
                <div class="col-md-4 mb-3 mb-md-0">
                    <label class="form-label text-muted">{$lang.group}</label>
                    <select class="form-control" onchange="loadItems(this.value)">
                        <option value="">{$lang.all} {$lang.group}</option>
                        {foreach from=$imeiservicelist key=GroupName item=Services name=foo}
                            <option value="g_{$smarty.foreach.foo.index}">{$GroupName}</option>
                        {/foreach}
                    </select>
                </div>
                
                <div class="col-md-4">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="hotitem" onchange="showhot(this);">
                        <label class="custom-control-label" for="hotitem">{$lang.hotproduct}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services List -->
    <div id="services-container">
        {foreach from=$imeiservicelist key=GroupName item=Services name=foo}
            <div class="card mb-4 service-group g_{$smarty.foreach.foo.index}">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="mb-0 text-primary">{$GroupName}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 services-table">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th>{$lang.service}</th>
                                    <th>{$lang.deliverytime}</th>
                                    {if $displayprice eq 1}
                                        <th class="text-right">{$lang.price}</th>
                                    {/if}
                                    <th style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach from=$Services key=id item=service}
                                    <tr class="service-row {if $service.hot eq 1}table-warning{/if}">
                                        <td class="text-center text-muted">{$service.id}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {if $service.icon}
                                                    <span class="mr-2">{$service.icon}</span>
                                                {else}
                                                    <span class="mr-2 text-muted"><i class="fas fa-cogs"></i></span>
                                                {/if}
                                                <div>
                                                    <a href="{$service.detaillink}?standalone=true" data-toggle="modal" data-target="#modal-ajax" class="text-body font-weight-bold">
                                                        {$service.service_name}
                                                    </a>
                                                    {if $service.hot eq 1}
                                                        <span class="badge badge-danger ml-2">HOT</span>
                                                    {/if}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light text-dark border">
                                                <i class="far fa-clock mr-1"></i> {$service.time}
                                            </span>
                                        </td>
                                        {if $displayprice eq 1}
                                            <td class="text-right font-weight-bold text-primary">
                                                {$currency.prefix} {$service.credit} {$currency.suffix}
                                            </td>
                                        {/if}
                                        <td class="text-center">
                                            <a href="client_order_imei?service={$service.id}" class="btn btn-sm btn-primary">
                                                {$lang.order}
                                            </a>
                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        {/foreach}
    </div>
</div>

{literal}
<script>
    $(document).ready(function(){
        // Simple search functionality
        $('#searchservicebox').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('.services-table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    function loadItems(groupClass){
        if(groupClass){
            $('.service-group').hide();
            $('.' + groupClass).fadeIn();
        }else{
            $('.service-group').fadeIn();
        }
    }
    
    function showhot(checkbox){
        if(checkbox.checked){
            $('.service-row').hide();
            $('.table-warning').show();
        } else {
            $('.service-row').show();
        }
    }
</script>
{/literal}
