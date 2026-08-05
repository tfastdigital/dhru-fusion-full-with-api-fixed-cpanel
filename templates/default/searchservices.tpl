{literal}
    <script>
        function getModels(bId, serviceId, callbackDivId, loader, loaderDivId) {
            if (loader) {
                $(loaderDivId).show();
            }
            $.post(urlprefix+'widget/getModels', {bid: bId, serviceid: serviceId}, function (data, success, textStatus) {
                $("#modelsTr").show();
                $(callbackDivId).fadeIn();
                $(callbackDivId).html(data);
                if (loader) {
                    $(loaderDivId).hide();
                }
            });
        }

        function getProvider(cId, serviceId, callbackDivId, loader, loaderDivId) {
            if (loader) {
                $(loaderDivId).show();
            }
            $.post(urlprefix+'widget/getProvider', {cid: cId, serviceid: serviceId}, function (data, success, textStatus) {
                $("#providerTr").show();
                $(callbackDivId).fadeIn();
                $(callbackDivId).html(data);
                if (loader) {
                    $(loaderDivId).hide();
                }
            });
        }
    </script>
{/literal}



<div class="container"><div class="page-container">
    <div class="card">
        <div class="row">
            <div class="col-lg-4">

                <form method="get" name="search_form" id="search_form" action="productsandservices.php?action=final">
                    <input type="hidden" name="action" value="final"/>
                    <input type="hidden" name="parentid" value="1006"/>
                    {$token}

                    <div class="form-group ">
                        <label>{$lang.brand}</label>
                        {$brands}
                    </div>

                    <div class="form-group  specialP d-none" id="modelsTr">
                        <label>{$lang.model}</label>
                        <span id="modelsdropdown"></span>
                        <div class="text-muted">{$lang.modelinformation}</div>
                    </div>

                    <div class="form-group ">
                        <label>{$lang.country}</label>
                        {$provider_countrys}
                    </div>
                    <div id="providerTr" style="display: none;" class="specialP">
                        <div class="form-group ">
                            <label>{$lang.provider}</label>
                            <span id="providerdropdown"></span> <small>{$lang.providerinformation}</small>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="search" value="{$lang.search}">{$lang.search}</button>
                </form>
            </div>
            <div class="col-lg-8"></div>
        </div>
    </div>
    </div></div>
