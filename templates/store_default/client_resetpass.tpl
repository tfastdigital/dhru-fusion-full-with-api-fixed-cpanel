<div class="container"><div class="page-container">
	<div class="m-auto">
	<div class="card">
		<div  class="alert alert-res"></div>

    <form method="post" name="resetpassword" id="resetpassword">
        {if $requiredusername}
            <div class="form-group ">
                <label>
                    {$lang.newpass}
                </label>
                {$newpassword}
            </div>
            <div class="form-group ">
                <label>
                    {$lang.confirmpass}
                </label>
                {$confirmation}
            </div>
        {else}
            {if $question}
                <div class="form-group ">
                    <label>
                        {$question}
                    </label>
                    {$answer}
                </div>
            {else}
                <div class="form-group">
                    <label>
                        {$lang.username}
                    </label>
                    {$username}
                </div>
                {if $captchaforget}
                    <div class="form-group    input-captcha">
                        <label>
                            {$forgetimage}
                        </label>
                        <input type="text" class="form-control " name="captcha"/>
                    </div>
                {/if}

            {/if}
        {/if}
        <div class="d-actionbar-mobile">
            <button type="submit" class="btn  btn-primary w-100" id="btn-resetpassword"
                    onClick="SubmitFormJSON('#btn-resetpassword','{$action_link}','#resetpassword','.alert-res','true','#loader');"
                    name="register" value="{$lang.next}">
                {$lang.next} &nbsp; <i class="fal fa-arrow-right"></i>
            </button>
        </div>
    </form>
</div>
</div>
</div>
</div>
