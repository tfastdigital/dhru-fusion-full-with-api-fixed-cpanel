<div class="container"><div class="page-container">

    <div class="card card-simple-form">



        {if $addtestimonial}
            <div class="row">
                <div class="col-lg-5 m-auto">

                    <div class="alert"></div>


                    <form method="post" name="frm_testimonial" id="frm_testimonial">

                        <div class="form-row ">
                            <div class="form-group  col-lg-6">
                                <label>
                                    {$lang.author}
                                </label>
                                {$author}
                            </div>
                            <div class="form-group   col-lg-6">
                                <label>
                                    {$lang.email}
                                </label>
                                {$email}
                            </div>
                        </div>

                        <div class="form-group ">
                            <label>
                                {$lang.comment}
                            </label>
                            {$comment}
                        </div>

                        {if $captcha}
                            <div class="form-group input-captcha">
                                {$captcha}
                            </div>
                        {/if}

                        <div class="d-actionbar-mobile">
                            <button type="submit" class="btn btn-primary" id="regi"
                                    onclick="SubmitFormJSON('#regi','{$action_link}','#frm_testimonial','.alert','true','#loader');"
                                    name="register" value="{$lang.save}">
                                {$lang.save}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        {else}



            {if $block}

            {else}
                {if $allpages}
                    <div class="row">

                        <div class="col-lg-4   alter">
                            <div class="p-3   h-100">
                                <div class="card-body h-100 justify-content-center d-flex align-items-center  text-center">
                                    <a href="{$link}">
                                        <i class="fa fa-plus big-icon"></i>
                                        <div class="p-3">{$lang.leave} {$lang.testimonial}   </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {foreach from=$allpages item=t}
                            <div class="col-lg-4  alter">
                                <div class="p-3 h-100">
                                    <div class="card-body p-0">

                                        <blockquote class="blockquote text-center">
                                            <img src="https://www.gravatar.com/avatar/{$t.email|@md5}.jpg?s=100&d=mm"    class="rounded-circle double-border"/>
                                            <p class="mt-3 ">
                                            <h3 class="d-inline-block"><i class="fas fa-quote-left"></i> &nbsp;&nbsp;
                                            </h3>
                                            {$t.comment|strip_tags|truncate:100:"..."}
                                            </p>
                                        </blockquote>

                                    </div>

                                    <div class="blockquote-footer text-center pb-2">{$t.author} on <cite    title="Source Title">{$t.date}</cite></div>

                                </div>
                            </div>
                        {/foreach}
                    </div>
                {else}
                    <div>
                        <h2 class=" h2">
                            {$pagetitle}
                        </h2>

                        <div class="row">

                            <div class="col mw-320 alter mb-5">
                                <div class="card  p-3 p-sm-3 border-0 h-100">
                                    <div class="card-body justify-content-center d-flex align-items-center  text-center">
                                        <a href="{$link}">
                                            <i class="fa fa-plus"></i>
                                            <div class="p-3"> {$lang.leave} {$lang.testimonial} </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center p-5">
                            {$lang.noresultfound}
                        </div>
                    </div>
                {/if}
            {/if}
        {/if}
    </div>

    </div></div>
