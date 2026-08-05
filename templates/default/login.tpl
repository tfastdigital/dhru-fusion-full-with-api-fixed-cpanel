{assign var=unique_id value=10|mt_rand:20}

<div class="m-auto  max-360 page-login">
    <form method="post" class="m-auto card" id="login_forms{$unique_id}">

        <div class="login-panel">

        <div>
            <div class="alert alert-login"></div>
            <h5 class="page-title">{$lang.login} {$lang.toyouraccount}</h5>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text  border  bg-white"><i class="fal fa-user"></i></span>
                    </div>
                    <input type="text" autocomplete="off"   name="username" value=""
                           class="form-control " placeholder="{$lang.username}"/>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text  border  bg-white"><i class="fal fa-lock"></i></span>
                    </div>
                    <input type="password" autocomplete="off"  name="password"
                           class="form-control " value="" placeholder="{$lang.password}"/>
                </div>

                {if !$smarty.request.standalone}
                <div class="text-right">
                    <div class="cursor-pointer" style="font-size: 14px;padding: 0.2rem 0;" href="{$linkresetpassword}/?standalone=true" data-dismiss="modal" data-target="#modal-ajax"
                       data-size="modal-md" data-toggle="modal"
                       data-whatever="Forgot Password">{$lang.forgot} {$lang.password}?</div></div>
                {/if}
            </div>

        </div>


        <div class="form-group  onetimepass" style="display: none">

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text border bg-white"><i class="fal fa-lock"></i></span>
                </div>
                <input type="number" class="form-control"  name="seckey" placeholder="OTP"/>
            </div>

        </div>


        {if $capthaimage}
            <div class="form-group  input-captcha">
                {$capthaimage}
            </div>
        {/if}

            <div class="d-actionbar-mobile">
        <button type="submit"   value="{$lang.login}"
                onclick="SubmitFormJSON('#loginbut{$unique_id}','{$actionlogin}','#login_forms{$unique_id}','.alert-login','true','#loader');"
                class="btn btn-primary w-100" id="loginbut{$unique_id}">{$lang.login}</button>

            </div>
        </div>

       {* {if $googleclientid || $allow_facebook}
            <div class="text-center">
                <div>
                    <h3 class="h3  or">
                        <span class="text-muted">{$lang.or} </span>
                    </h3>

                </div>

                <div class="d-flex justify-content-center  w-100">
                    {if $googleclientid}
                        <a href="/loginoption.php?action=googlep"
                           class="text-white rounded  w-50 px-3 py-1 d-flex align-items-center justify-content-between"
                           style="background: #D84E3D;">
                            {$lang.login} {$lang.with} <i class="fab fa-google"></i>
                        </a>
                    {/if}
                    {if $allow_facebook}
                        <a href="/loginoption.php?action=facebook"
                           class="text-white rounded w-50 px-3 py-1 ml-3 d-flex align-items-center justify-content-between"
                           style="background: #425892;">
                            {$lang.login} {$lang.with} <i class="fab fa-facebook"></i>
                        </a>
                    {/if}
                </div>
            </div>
        {/if}*}
    </form>

</div>

