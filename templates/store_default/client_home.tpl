


<div class="client-area">


    <div class="clientarea-balance    position-relative {if $smarty.get.clientarea eq 'default'} {else} firsttime {/if}">

        <div class="container">
            <div class="page-container">

                <div>

                    {if $notification.success}
                        <div class="alert  alert1 alert-success">{$notification.success}</div>
                    {elseif $notification.error}
                        <div class="alert  alert1 alert-danger">{$notification.error}</div>
                    {elseif $notification.info}
                        <div class="alert alert1 alert-info">{$notification.info}</div>
                    {/if}


                    {if $secondauthmessage}
                        <div class="alert alert1 alert-info">{$secondauthmessage}
                            <a href="{$secondauthlink}?standalone=true" data-toggle="modal"
                               data-whatever="{$lang.2stepverif}" data-target="#modal-ajax"> Enable </a>
                        </div>
                    {/if}


                    {if $incompleteprofile || $userdetails.message || $priceupdate}
                        <div class="mb-4 bottom-space d-flex align-items-center  pb-3">
                            <div style="color:#ffc106">
                                <i class='fa fa-bell faa-ring animated fa-x'></i>
                            </div>
                            <div class="ml-2">
                                <strong> {$lang.message} {$lang.from} {$lang.administrator} : </strong>

                                {if $incompleteprofile}
                                    <a href="{$settingprofilelink}">{$incompleteprofile}</a>
                                {/if}
                                {if $userdetails.message && $stopmessage}
                                    {$userdetails.message}
                                {/if}

                                {if $priceupdate}
                                    <a href="{$settingservicelink}">{$lang.viewpricemessage}</a>
                                {/if}
                            </div>
                        </div>
                    {/if}

                    <div class="row">
                        <div class="col-lg-{if $resellerstore}8{else}12{/if}  mb-4 bottom-space">

                            <div class="row">
                                <div class="col-md-6 col-left">
                                    <div class="card h-100">

                                        <div class="text-muted">
                                            {$lang.yourcurrentbalance}
                                        </div>


                                        <div class="d-row">

                                            <h4 class="nowrap   big-font">
                                                <span class="aftercounter"> {$userdetails.currency.prefix} </span>
                                                <span class="counter"
                                                      data-count="{$userdetails.credit.credit|string_format:"%.2f"}">{if $smarty.get.clientarea eq 'default'} {$userdetails.credit.display_credit} {else} 0 {/if}</span>
                                                <span class="text-sm aftercounter">{$userdetails.currency.suffix}</span>
                                            </h4>

                                            <div class="aftercounter">
                                                {if $addfund}
                                                    {if $resellerstore}
                                                        <button class="btn btn-primary btn-sm" type="button"
                                                                onclick="window.location.href='{$addfundslink}'"><i
                                                                    class="fas fa-shopping-cart"></i> &nbsp; {$lang.buycredit}
                                                        </button>
                                                    {else}
                                                        {if $storepayform}
                                                            <button class="btn btn-primary btn-sm" type="button"
                                                                    data-toggle="modal" data-target="#modal-addfund"><i
                                                                        class="fas fa-shopping-cart"></i> &nbsp; {$lang.buycredit}
                                                            </button>
                                                        {/if}
                                                    {/if}
                                                {/if}
                                            </div>
                                        </div>



                                    </div>
                                </div>

                                <div class="col-md-6 col-right">
                                    <div class="card card-unpaid-balance h-100">
                                        <div class="aftercounter">
                                            <div class="cursor-pointer"
                                                 href="{$settingpendinginvoicelink}?standalone=true"
                                                 data-whatever="{$lang.unpaid} {$lang.balance}" data-toggle="modal"
                                                 data-target="#modal-ajax">
                                                <div class="text-muted"> {$lang.unpaid} {$lang.balance}   </div>
                                                <h4 class="big-font text-danger no-wrap"> {$currency.prefix} {if $unpaidbalance} {$display_unpaidbalance} {else} 0 {/if} {$currency.suffix}  </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="card card-othercredit my-4">






                                <div id="othercredit" class="aftercounter text-center">
                                    <div class="row">
                                        <div class="d-grid mb-4 mb-lg-0">
                                            <div>
                                                <div class="card-body">
                                                    <div class="text-center rounded-circle">
                                                        <i   class="fal fa-receipt fa-2x"></i>
                                                    </div>
                                                    <div class="text-muted p-2"> {$lang.totalreceipts}</div>
                                                    <h4 class="nowrap"> {$userdetails.currency.prefix}
                                                        <span class="">{$userdetails.credit.total}</span>
                                                        <span class="text-sm">{$userdetails.currency.suffix}</span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-grid  mb-4 mb-lg-0">
                                            <div>
                                                <div class="card-body">
                                                    <div class="text-center rounded-circle">
                                                        <i   class="fal fa-lock fa-2x"></i>
                                                    </div>
                                                    <div class="text-muted p-2"> {$lang.lockedamount}</div>
                                                    <h4 class="nowrap"> {$userdetails.currency.prefix}
                                                        <span class="">{$userdetails.credit.in_process}</span>
                                                        <span class="text-sm">{$userdetails.currency.suffix}</span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        {if $userdetails.usertype eq '1'}
                                            <div class="d-grid  mb-4 mb-lg-0">
                                                <div>
                                                    <div class="card-body">
                                                        <div class="text-center rounded-circle">
                                                            <i class="fal fa-shopping-bag fa-2x"></i>
                                                        </div>
                                                        <div class="text-muted p-2"> {$lang.sellinglimit}</div>
                                                        <h4  class="nowrap">{$userdetails.currency.prefix}
                                                            <span class="">{$userdetails.credit.selling_limit}</span>
                                                            <span class="text-sm">{$userdetails.currency.suffix}</span>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        {/if}

                                        {if $defreward}
                                            <div class="d-grid  mb-4 mb-lg-0">
                                                <div>
                                                    <div class="card-body">
                                                        <div class="text-center rounded-circle">
                                                            <i   class="fal fa-tag fa-2x"></i>
                                                        </div>
                                                        <div class="text-muted p-2"> {$lang.point} {$lang.balance}</div>
                                                        <h4  class="nowrap">
                                                            <span class="">{$pointbalance}</span>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        {/if}
                                    </div>
                                </div>

                            </div>




                            <div class="clientarea-balance">
                                {if !$eCommerce}
                                    <div class="container p-0">
                                        <div class="page-container">

                                            <div>
                                                {assign var="available" value=$userstats.imeiservice.total.4+$userstats.fileservice.total.4+$userstats.serverservice.total.4}
                                                {assign var="pending" value=$userstats.imeiservice.total.0+$userstats.fileservice.total.0+$userstats.serverservice.total.0+$userstats.imeiservice.total.1+$userstats.fileservice.total.1+$userstats.serverservice.total.1}
                                                {assign var="rejected" value=$userstats.imeiservice.total.3+$userstats.fileservice.total.3+$userstats.serverservice.total.3}
                                                {assign var="total" value=$userstats.imeiservice.totalorder+$userstats.fileservice.totalorder+$userstats.serverservice.totalorder}

                                                <div class="row">


                                                    <div class="col-lg-4 col-order-area   mb-4  bottom-space">
                                                        <div class="card text-center  card-area-status card-order-success h-100">
                                                            <div class="cursor-pointer  rounded"
                                                                 onclick="window.location.href='{$imeiorderavailable}'">
                                                                <h2 class="h2">{if $available}{$available}{else}0{/if}
                                                                    <span  class="text-muted"  style="font-weight: 100;font-size: 1.3rem">/ {$total} </span>
                                                                </h2>
                                                            </div>
                                                            <div class="py-3">
                                                                <div class="w-100   rounded bg-light position-relative">
                                                                    <div class="bg-success progressbar rounded"
                                                                         style="width: {($available*100)/$total}%;height:3px"></div>
                                                                </div>
                                                            </div>
                                                            <div class="text-muted p-2">{$lang.orderprocessuccess}  </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4  col-order-area  mb-4  bottom-space">
                                                        <div class="card text-center  card-area-status card-order-process h-100">
                                                            <div class="cursor-pointer rounded"
                                                                 onclick="window.location.href='{$imeiorderpending}'">
                                                                <h2 class="h2">{if $pending}{$pending}{else}0{/if}
                                                                    <span  class="text-muted" style="font-weight: 100;font-size: 1.3rem">/ {$total} </span>
                                                                </h2>
                                                            </div>
                                                            <div class="py-3">
                                                                <div class="w-100   rounded bg-light position-relative">
                                                                    <div class="bg-info progressbar  rounded"
                                                                         style="width: {($pending*100)/$total}%;height:3px"></div>
                                                                </div>
                                                            </div>

                                                            <div class="text-muted p-2">{$lang.orderinproces}</div>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4  col-order-area  mb-4  bottom-space">
                                                        <div class="card text-center  card-area-status card-order-fail h-100">
                                                            <div class="cursor-pointer  rounded"
                                                                 onclick="window.location.href='{$imeiorderrejected}'">

                                                                <h2 class="h2">{if $rejected}{$rejected}{else}0{/if}
                                                                    <span class="text-muted" style="font-weight: 100;font-size: 1.3rem">/ {$total} </span>
                                                                </h2>
                                                            </div>

                                                            <div class="py-3">
                                                                <div class="w-100  rounded bg-light position-relative">
                                                                    <div class="bg-danger progressbar rounded"
                                                                         style="width: {($rejected*100)/$total}%;height:3px"></div>
                                                                </div>
                                                            </div>

                                                            <div class="text-muted p-2">{$lang.orderprocesfail}</div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                {/if}
                            </div>

                            <div class="aftercounter d-flex">

                                <div >


                                {if $telegram}

                                    {if $userdetails.messengerid neq ''}

                                    {else}

                                        {if $resellerstore}
                                            <button class="btn   mr-3" style="background:#0288CB;color: white" data-toggle="modal"
                                                    type="button" data-target="#modal-telegram">
                                                <i class="fas fa-paper-plane" ></i> &nbsp;
                                                {$lang.connecttelegram}
                                            </button>
                                        {/if}


                                    {/if}
                                {/if}

                                {if $installapp}
                                    <button class="btn    " style="background:#9EC038;color: white" type="button"
                                            onclick="window.location.href='{$applink}'">
                                        <i class="fab fa-android"></i> &nbsp;
                                        {$lang.androidappavail}
                                    </button>
                                {/if}

                                </div>
                            </div>
                        </div>


                        {if $resellerstore}
                            <div class="col-lg-4">
                                <div class="card card-announcement">
                                    <h5 class="card-title"> <span> {$lang.announcements} </span></h5>
                                    <div   id="carousel-announcements">
                                        <script>
                                            getContect('#carousel-announcements', '{$quicknewslink}?standalone=true&carousellist=1', '#carousel-announcements', true, '#loader', true);
                                        </script>
                                    </div>
                                    <div class="text-right">
                                        {if $unreadannoucements}
                                            <a data-toggle="modal" href="#" data-target="#announcement"> View All </a>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        {/if}
                    </div>

                </div>


            </div>
        </div>
    </div>

</div>

    {if $resellerstore}
        <div class="modal   hide" id="announcement" data-backdrop="static" data-keyboard="false" tabindex='-1'>
            <div class="modal-dialog modal-dialog-centered  modal-lg" style="max-width: 1200px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fal fa-bullhorn"></i> &nbsp;{$lang.announcements} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="news">
                            <script>
                                getContect('.news', '{$quicknewslink}?standalone=true', '.news', true, '#loader', true);
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/if}



    {assign var=theme value=$userdetails.themesettings|json_decode:1}


    {literal}
    <script>
        $(document).ready(function () {
            var time = 1000;
            $('.firsttime .counter').each(function () {
                var $this = $(this),
                    countTo = $this.attr('data-count');

                $({
                    countNum: $this.text()
                }).animate({
                        countNum: countTo
                    },
                    {
                        duration: time,
                        easing: 'linear',
                        step: function () {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function () {
                            $this.text(this.countNum);
                            //alert('finished');
                        }

                    });
            });

            setTimeout(function () {
                $('.aftercounter').css({'opacity': 1});
                if ($('.announce').length) {
                    {/literal}
                    {if $announcementpopup eq 'true' && $smarty.get.clientarea neq 'default'}
                    $('#announcement').modal('show');
                    {/if}
                    {literal}
                }
            }, time);

            {/literal}
            {if !$theme.mode}
            $('#themeselection').modal('show');
            {/if}
            {literal}
        });
    </script>
    <style>


        .table-fixed-header thead.table-head-fixed {
            position: relative
        }

        .box-head {
            margin-bottom: 20px;
        }

        .firsttime .aftercounter {
            opacity: 0;
        }

        .ordertheme.active, .thememode.active {
            border-color: orange !important;
        }

        .clientarea .h1, .clientarea .h2, .clientarea .h3, .clientarea .h4, .clientarea .h5, .clientarea .h6, .clientarea h1, .clientarea h2, .clientarea h3, .clientarea h4, .clientarea h5, .clientarea h6 {
            color: black !important;
        }
    </style>
    {/literal}




    {if $resellerstore}
        <div class="modal   hide" id="modal-telegram" tabindex='-1'>
            <div class="modal-dialog modal-dialog-centered  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-paper-plane"></i> &nbsp;&nbsp; {$lang.connecttelegram}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div>

                            <h5 class="p-3 m-3 text-center"> {$lang.connectyouraccountwithtelegrtam}
                                <span style="color:#2da5d8;"> <br/>{$lang.securityalertorderstatus} </span>
                                etc... </h5>


                            <div class="row d-flex align-items-center mt-5">

                                <div class="col-lg-5">
                                    <div class="text-center p-3">
                                        <h5> {$lang.justsearch} <b> "{$telegram}" </b> <br/> {$lang.withcontacts}
                                        </h5>

                                        <div class="mt-3 p-2 bg-light rounded">
                                            <div><span style="font-size: 50px"> {$pairingcode} </span></div>
                                            <span style="color:#888"> {$lang.pairingcode}  </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2 text-center">
                                    <h3 class="h3 or"><span class="text-muted"> {$lang.or} </span></h3>
                                </div>


                                <div class="col-lg-5 text-center">
                                    <div class="border rounded">
                                        <img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl={$telegramurl}&choe=UTF-8"
                                             class=""/>
                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    {else}
        {if $storepaypalid}
            <div class="modal   hide" id="modal-addfund" tabindex='-1'>
                <div class="modal-dialog modal-dialog-centered  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Pay Now </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body   mb-4 bottom-space">
                            {$storepayform}
                        </div>
                    </div>
                </div>
            </div>
        {/if}
    {/if}


    <div class="modal   hide" id="themeselection" data-backdrop="static" data-keyboard="false" tabindex='-1'>
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> {$lang.thememode} </h5>
                </div>
                <div class="modal-body">

                    <div class="d-flex w-100 justify-content-center">
                        <div>
                            <div class="border rounded m-3 p-3 thememode" data-value="light">
                                <img src="templates/default/images/light.png">
                            </div>
                            <div class="p-3 text-center"> {$lang.light} </div>
                        </div>
                        <div>
                            <div class="border rounded m-3 p-3 thememode" data-value="dark">
                                <img src="templates/default/images/dark.png">
                            </div>
                            <div class="p-3 text-center"> {$lang.dark} </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                            aria-label="Close">{$lang.ok}</button>
                </div>
            </div>
        </div>


    </div>


