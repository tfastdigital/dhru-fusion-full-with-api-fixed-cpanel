<script type="text/javascript">
    function checkDomain(domin, ips) {
        SubmitForm('#save', '{$checkdomainlink}?domain=' + domin + '&ips=' + ips, '#chk', '.alert', 'true', '#loader', true);
    }
</script>

<div class="container">
    <div class="page-container">

        <div class="card">

            <div class="row">
                <div class="col-lg-12">
                    <form method="post" id="chk">
                        {$token}
                    </form>

                    <div class="alert"></div>
                    {if $addinfo}
                    {else}
                        <div class="alert1 alert alert-info"> {$lang.storedomainpointinfo} <strong>{$linkip}</strong>
                        </div>
                    {/if}
                    <form method="post" name="store" id="store" enctype="application/x-www-form-urlencoded">
                        <ul class="nav nav-pills flex-nowrap">
                            <li class="nav-item "><a class="nav-link  active" data-toggle="tab"
                                                     href="#tab1">{$lang.general} </a></li>
                            <li class="nav-item "><a class="nav-link " data-toggle="tab"
                                                     href="#tab2"> {$lang.payment} {$lang.invoicestransgateway} {$lang.setting} </a>
                            </li>
                            <li class="nav-item "><a class="nav-link " data-toggle="tab"
                                                     href="#tab3">{$lang.twitter}</a></li>
                            <li class="nav-item "><a class="nav-link " data-toggle="tab"
                                                     href="#tab4">{$lang.googleanalytics}</a></li>


                            <li class="nav-item"><a class="nav-link " href="{$featureslink}"
                                                    title="{$lang.hottosetupstore}">Store Features</a></li>


                        </ul>
                        <div class="tab-content pt-3">
                            <div class="tab-pane     fade active show" id="tab1" role="tabpanel"
                                 aria-labelledby="tab1"> {$token}


                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="p-3">

                                            <div class="form-group ">
                                                <label>{$lang.domain}</label>
                                                {$domain} </span>
                                                <div class="text-muted">{$lang.domaininfo}</div>
                                            </div>
                                            <div class="form-group ">
                                                <label>{$lang.storeurl}</label>
                                                {$site_address}</span>
                                                <div class="text-muted">{$lang.siteaddressinfo}</div>
                                            </div>
                                            <div class="form-group ">
                                                <label>{$lang.sslurl}</label>
                                                {$config_ssl_allow}
                                                <div class="text-muted">{$lang.sslinfo}</div>
                                            </div>
                                            <div class="form-group  full">
                                                <label>
                                                    {$lang.sitedescription} <span
                                                            class="text-muted">{$lang.forseo}</span> </label>
                                                {$site_description}
                                            </div>
                                            <div class="form-group ">
                                                <label>
                                                    {$lang.sitekeywords} <span class="text-muted">{$lang.forseo}</span>
                                                </label>
                                                {$sitekeywords}

                                            </div>

                                            <div class="form-row ">
                                                <div class="form-group  col-lg-6">
                                                    <label>{$lang.template}</label>
                                                    {$templates} </div>
                                                <div class="form-group  col-lg-6">
                                                    <label>{$lang.default} {$lang.language}</label>
                                                    {$language} </div>
                                            </div>
                                        </div>

                                        </div>
                                        <div class="col-lg-6">

                                            <div class="p-3">

                                            <div class="form-group mb-0">
                                                <label class="form-label">{$lang.logolink}</label>
                                                <div class="d-none text-right">
                                                    <img id="logo_link"/>
                                                </div>
                                            </div>

                                            {if $logo_link}
                                                {$logo_link}
                                            {else}
                                                <div class="form-group ">
                                                    <input id="fileToUpload1" type="file" size="45"
                                                           name="fileToUpload1" class="form-control  file"/>
                                                </div>
                                            {/if}


                                            <div class="form-row mt-3">
                                                <div class="form-group col-lg-6 ">
                                                    <label>{$lang.storetitle}</label>
                                                    {$config_site_name} </div>
                                                <div class="form-group  col-lg-6">
                                                    <label>{$lang.companyname}</label>
                                                    {$companynames} </div>
                                            </div>

                                            <div class="form-group ">
                                                <label>{$lang.contactmail}</label>
                                                {$config_admin_mail} </div>
                                            <div class="form-group ">
                                                <label>{$lang.facebook}</label>
                                                {$facebook} </div>
                                            <div class="form-group ">
                                                <label>{$lang.linkedin}</label>
                                                {$linkedin} </div>
                                            <div class="form-group ">
                                                <label>{$lang.invoice} pay to</label>
                                                {$invoicepayto} </div>


                                            <div class="form-row ">
                                                <div class="form-group  col-lg-6">
                                                    <label>{$lang.signuptype}</label> <br/>
                                                    {$signuptype} </div>
                                                {if $cartforstore}
                                                    <div class="form-group  col-lg-6">
                                                        <label>{$lang.cart} {$lang.for} {$lang.store}</label> <br/>
                                                        {$cartforstore} </div>
                                                {/if}
                                            </div>
                                        </div>
                                    </div>


                                </div>


                            </div>
                            <div class="tab-pane    fade" id="tab2" role="tabpanel" aria-labelledby="tab2">
                                <div class="row">

                                    <div class="col-lg-6">

                                        <div class="p-3">

                                        <h5>{$lang.paypal}</h5>
                                        <div class="form-group ">
                                            <label>{$lang.paypal} {$lang.email}</label>
                                            {$paypalid}
                                            <div class="text-muted">{$lang.leavepaypal}</div>
                                        </div>
                                        <div class="form-group col-lg-4 p-0">
                                            <label>{$lang.paypal} {$lang.currency}</label>
                                            {$paypalcurrency}

                                        </div>
                                        <div class="form-group  col-lg-4 p-0">
                                            <label>{$lang.paypal} {$lang.tax}</label>
                                            <div class="input-group"> {$paypaltax} </div>
                                        </div>
                                        <div class="form-group  col-lg-4 p-0">
                                            <label>{$lang.minimumaddfund} </label>
                                            <div class="input-group"> {$AddFundsMinimum} </div>

                                        </div>
                                        </div>
                                    </div>
                                    {if $coinbaseapikey}
                                        <div class="col-lg-6">

                                            <div class="p-3">

                                            <h5>Coinbase</h5>
                                            <div class="form-group ">
                                                <label>Coinbase {$lang.apikey} {$lang.key}</label>
                                                {$coinbaseapikey}
                                            </div>
                                            <div class="form-group ">
                                                <label>Coinbase webhook {$lang.secret}</label>
                                                {$coinbasesecret}
                                            </div>
                                            <div class="form-group col-lg-4 p-0">
                                                <label>Coinbase {$lang.currency}</label>
                                                {$coinbasecurrency}
                                            </div>
                                            <div class="form-group ">
                                                <label>Coinbase Webhook URL</label>
                                                {$coinbasewebhook}
                                            </div>
                                            <div class="form-group col-lg-4 p-0">
                                                <label>Coinbase {$lang.tax}</label>
                                                <div class="input-group">{$coinbasetax}</div>
                                            </div>
                                        </div>
                                        </div>
                                    {/if}
                                </div>
                            </div>


                            <div class="tab-pane  fade" id="tab3" role="tabpanel" aria-labelledby="tab3">
                                <div class="col-lg-5 p-0">
                                    <div class="p-3">
                                <div class="form-group ">
                                    <label>Consumer Key</label>
                                    {$consumer_key} </div>
                                <div class="form-group ">
                                    <label>Consumer Secret</label>
                                    {$consumer_secret} </div>
                                <div class="form-group ">
                                    <label>Access Token</label>
                                    {$access_token} </div>
                                <div class="form-group ">
                                    <label>Token Secret</label>
                                    {$token_secret} </div>
                                </div>
                                </div>
                            </div>
                            <div class="tab-pane    fade" id="tab4" role="tabpanel" aria-labelledby="tab4">
                                <div class="col-lg-5 p-0">
                                    <div class="p-3">
                                <div class="form-group ">
                                    <label>{$lang.tracking} {$lang.code}</label>
                                    {$tracking_code} </div>
                                <div class="form-group ">
                                    <label>{$lang.tracking} {$lang.domain}</label>
                                    {$tracking_domain} </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-3 mb-4 bottom-space">

                        <button class="btn btn-primary" type="submit" id="save"
                                onclick="SubmitFormFile('#save','{$action_link}','#store','.alert','true','#loader',true);"
                                name="save" value="{$lang.save}">{$lang.save}</button>

                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
