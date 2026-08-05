{include file="templates/default/chunks/carousel.tpl"}


{if $indexcontent}

    <div class="index-content mb-4 bottom-space">
        <div  class="container">
            <div class="page-container">
                {$indexcontent}
            </div>
        </div>
        {*<div class="row">
            <div class="col mw-320  wow bounceIn">
                <div class="card h-100">
                    <div><i class="fal fa-life-ring big-icon"></i>
                        <h2 class="m-2">24 Hours Support</h2>
                    </div>
                </div>
            </div>
            <div class="col mw-320  wow bounceIn">
                <div class="card h-100">
                    <div><i class="fal fa-tags big-icon"></i>
                        <h2 class="m-2">Attractive Prices</h2>
                    </div>
                </div>
            </div>
            <div class="col mw-320  wow bounceIn">
                <div class="card h-100">
                    <div><i class="fal fa-info big-icon"></i>
                        <h2 class="m-2">Simple Instruction</h2>
                    </div>
                </div>
            </div>
            <div class="col mw-320  wow bounceIn">
                <div class="card  h-100">
                    <div><i class="fal fa-lock big-icon"></i>
                        <h2 class="m-2">Absolutely Safe</h2>
                    </div>
                </div>
            </div>
            <div class="col mw-320  wow bounceIn">
                <div class="card  h-100">
                    <div><i class="fal fa-dollar-sign big-icon"></i>
                        <h2 class="m-2">Money Back Guarantee</h2>
                    </div>
                </div>
            </div>
            <div class="col mw-320  wow bounceIn">
                <div class="card  h-100">
                    <div><i class="fal fa-envelope big-icon"></i>
                        <h2 class="m-2">Expeditious Delivery</h2>
                    </div>
                </div>
            </div>




        </div>*}
        {* {if $cart && $quick_checkout && !$eCommerce && !$loggedin}
            <div class="wow bounceIn">
                <div class="card  h-100">
                    <div>
                        <i class="fal fa-shopping-cart"></i>
                        <h2 class="m-2">{$lang.quick} {$lang.checkout}</h2>
                        <div id="quick-checkout">
                            <script>
                                getContect('#quick-checkout','widget/placeOrder?new=true','#quick-checkout',true,'#loader');
                            </script>
                        </div>
                    </div>
                </div>
            </div>

        {/if}*}
    </div>

{/if}




  <div class="index-products">
    {if $cart}
        {include file="templates/default/index-products.tpl"}
     {/if}
  </div>

{if $configaffiliate}
    <div class="index-affiliate mt-5 pb-4">
    <div class="container"><div class="page-container">
        <div class="">
            <div class="card  d-none d-lg-block affiliate-marketing">
                <div class="index-content d-none d-md-block  p-lg-3 ">
                    <div  class="p-lg-3">
                        <h3>
                            <a href="affiliate.html">
                                <span> Affiliate Marketing </span>
                            </a>
                        </h3>
                        <div>
                            <div class="text-muted">In order to know that it's the best kind and will generate a good amount of income for you</div>
                            <div class="d-flex justify-content-center">
                                <i class="fal fa-tv big-icon p-5"></i>
                                <i class="fal fa-mouse-pointer p-5 big-icon"></i>
                                <i class="fal fa-shopping-basket p-5 big-icon"></i>
                                <i class="fal fa-money-bill-wave-alt big-icon p-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div></div>
    </div>
{/if}

 {if $resellerstore}
    {if $ResellerStore eq 1}
        <div class="index-reseller">
         <div class="container">
            <div class="page-container">
             <div class="card card-reseller">
                <div class="position-relative  p-lg-3">
                    <h3 class="p-3">
                        <a href="{$featureslink}" target="_blank"> <span>  Make your own free website today and group your network </span> </a>
                    </h3>
                     <div  class="text-left p-lg-3 m-auto">


                         <div class="row">
                             <div class="col-lg-1   col-sm-3 col-3 pt-1 pb-1">
                                    <span style="font-size:40px">
                                      <i class="fa fa-users"></i>
                                    </span>
                             </div>
                             <div class="col-lg-5 col-sm-9  col-9 pt-1 pb-1  border-left mb-4 bottom-space">
                                 <h5 class="text-orange">Manage your customers</h5>
                                 <div>Manage your customers easily. Get a comlete details of their account.  We also have added amazing features. <br /> <a class="text-muted text-white" href="{$featureslink}">Read More...</a> </div>
                             </div>

                             <div class="col-lg-1  col-sm-3  col-3 pt-1 pb-1">
                                    <span style="font-size:40px">
                                      <i class="fa fa-shopping-cart"></i>
                                    </span>
                             </div>
                             <div class="col-lg-5  col-sm-9  col-9 pt-1 pb-1 border-left mb-4 bottom-space">
                                 <h5 class="text-orange">Customize as you love to see your store</h5>
                                 <div>We have unique live template editor, It is very easy to customize with your own design the look of your website. <br /> <a class="text-muted text-white" href="{$featureslink}">Read More...</a> </div>
                             </div>


                             <div class="col-lg-1   col-sm-3  col-3 pt-1 pb-1">
                                    <span style="font-size:40px">
                                      <i class="fa fa-cog"></i>
                                    </span>
                             </div>
                             <div class="col-lg-5   col-sm-9  col-9 pt-1 pb-1 border-left">
                                 <h5 class="text-orange">Exclusive solutions, tools and services</h5>
                                 <div>Enable/Disable the services you want to sale on your store. You can setup different prices for retail cart or for whole sell customers. <br /> <a class="text-muted text-white" href="{$featureslink}">Read More...</a> </div>
                             </div>

                             <div class="col-lg-1  col-sm-3  col-3 pt-1 pb-1">
                                    <span style="font-size:40px">
                                      <i class="fas fa-globe"></i>
                                    </span>
                             </div>
                             <div class="col-lg-5   col-sm-9  col-9 pt-1 pb-1 border-left">
                                 <h5 class="text-orange">Powerfull and easy to use </h5>
                                 <div>A very easy to use CMS (Content Management System) for you to manage your website. <br /> <a class="text-muted text-white" href="{$featureslink}">Read More...</a> </div>
                             </div>
                         </div>

                        </div>
                    </div>
                </div>
            </div>
         </div>
        </div>
    {/if}
 {/if}




