<footer   class="d-none d-lg-block">

    <div class="footer-top p-3 p-lg-4">
        <div class="container"><div class="page-container">

          {*  <div>
                {if $currentpage eq 'index' && $twitter}
                    <div id="twitterfeed">
                        <script>
                            getContect('#tab1','widget/twitterfeed','#twitterfeed',true,'#loader',false);
                        </script>
                    </div>
                {/if}
            </div>*} 

            <div class="row">

                <div class="col-lg-3">
                    <h4 class="link-heading h4 text-uppercase">{$companyname}</h4>

                    <div class="my-3">
                        <ul class="nav   social-icons">
                            {include file="templates/default/chunks/social-links.tpl"}
                        </ul>
                    </div>

                </div>

                <div class="col-lg-3 mr-auto">
                    <h5 class="link-heading h5">{$lang.usefullinks}</h5>
                    <div class="footer-navbar">

                        <ul class="nav navbar-nav">

                            {if $resellerstore}
                                {foreach from=$menucateArr key=id item=menu}

                                        <li class="nav-item">
                                            <a  class="nav-link" {if $menu.newwindow eq '1'} target="_blank" {/if}  href="{if $menu.external eq 1}{$menu.link}{else}{$menu.seolink}{/if}" >
                                                {$menu.name}
                                            </a>
                                        </li>

                                {/foreach}
                            {else}
                                {foreach from=$menucateArr key=id item=menu}
                                    {if $menu.locked eq 1}
                                        {if $menu.id neq 1004}
                                            <li class="nav-item">
                                                <a  class="nav-link" {if $menu.newwindow eq '1'} target="_blank" {/if}    href="{if $menu.external eq 1}{$menu.link}{else}{$menu.seolink}{/if}" >
                                                    {$menu.name}
                                                </a>
                                            </li>
                                        {/if}
                                    {/if}
                                {/foreach}
                            {/if}
                        </ul>

                    </div>
                </div>


                {if $resellerstore}
                    <div class="col-lg-3">
                        <h5 class="link-heading h5">{$lang.subscribe}</h5>
                        <div class="my-3">
                           <span> {$lang.dontmissourfuture} </span>
                        </div>
                        <div class="">
                            <div class="d-flex w-100">
                                <div class="">

                                    <div class="modal fadeIn hide" id="newsletters"  tabindex='-1'>
                                        <div class="modal-dialog modal-dialog-centered  modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{$lang.newsletter}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span>&times;</span>  </button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="alert-newsletter alert"></div>

                                                    <form method="post"  id="newsltter" >
                                                        {$token}

                                                        <div class="form-group  ">
                                                            <input class="form-control"  value=""  placeholder="{$lang.email}" name="email"   type="text" required="required">
                                                        </div>

                                                        {if $captchaonnewsletter}
                                                            <div class="form-group input-captcha">
                                                                {$captchanewsletter}
                                                            </div>
                                                        {/if}

                                                        <button class="btn btn-primary w-100"
                                                                onclick="SubmitFormJSON('#btn-newsletter','{$newsletteraction}','#newsltter','.alert-newsletter','true','#loader');"
                                                                type="button" id="btn-newsletter">{$lang.submit}</button>


                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn   btn-newsletter"  name="subscription" data-modal="newsletters" type="button" data-toggle="modal" data-target="#newsletters" id="btnFNL" ><i class="fal fa-envelope-open-text"></i>  {$lang.newsletter}  </button>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}



                <div class="col-lg-3">
                    {if $resellerstore}
                        <h5 class="link-heading h5"> {$lang.connectwithus}  </h5>
                        <div class="my-3">
                            <ul class="nav d-block">
                                {if $contactusphone}
                                    <li class="nav-item"> <span class="nav-link px-0" href="#"> <i class="fal fa-phone"></i>  {$contactusphone}  </span> </li>
                                {/if}
                                {if $contactusdisplayemail}
                                    <li class="nav-item mr-auto"> <span class="nav-link px-0" href="#"> <i class="fal fa-envelope"></i>  {$contactusdisplayemail}  </span> </li>
                                {/if}
                            </ul>
                        </div>
                    {/if}
                </div>

            </div>
            </div></div>
    </div>

    <div class="footer-bottom  p-3 p-lg-4">

        <div class="container"><div class="page-container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <small> &copy; {$smarty.now|date_format:"%Y"} {$companyname}  {$lang.allrightsreservdby}</small>
                </div>
                <div class="col-lg-6 text-right">
                    <img src="templates/default/images/payment_logo.png"/>
                </div>
            </div>
            </div>
        </div>
    </div>

</footer>
{if $euCook}
    {$euCook}
{/if}

{$googleanalytics}
