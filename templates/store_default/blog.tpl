
<div class="container"><div class="page-container">

        <div class="page-blog">
            {if $blog}

                <div class="row">

                    <div class="col-lg-3 d-none d-lg-block">
                        <div class="card content-category">
                            <ul class="list-group">
                                <li class="list-group-item dropdown-header">Category</li>
                                {if $sidecategories}
                                    {foreach from=$sidecategories item=sidecat}
                                        <li class="list-group-item  cursor-pointer" onclick="window.location.href='{$sidecat.seo}'">{$sidecat.name}</li>
                                    {/foreach}
                                {/if}
                            </ul>
                        </div>
                    </div>



                    <div class="col-lg-9">
                        <div class="card">
                        {if $postid}


                            <div class="post">
                                <div>{$post.content}</div>
                                <div><span> {$lang.on} {$post.date} {$lang.by} {$post.author} </span></div>
                            </div>
                            {assign var="blg" value=$post.id}
                            {if $cmslinks.blog.$blg} <span><a target="_blank" href="{$cmslinks.blog.$blg}">Edit Page</a></span> {/if} <br />

                           {* <div class="d-flex">

                                <div class="m-2">
                                    {literal} <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=xa-4a51bb7478842e2e"></script> {/literal}
                                    {if $facebooklike}
                                        <iframe src="http://www.facebook.com/plugins/like.php?href={$siteurl}/blog?postid={$post.id}&amp;layout=button_count&amp;show_faces=true&amp;width=450&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:80px; height:20px"></iframe>
                                    {/if}
                                </div>

                            </div>

                            {if $comments}
                                <div>
                                    <h4	 class="">{$lang.usercomments} ({$totalcomments})</h4>
                                    {foreach from=$comments item=comment}
                                        <div> <img src="http://www.gravatar.com/avatar/{$comment.email|@md5}.jpg?s=80&d=mm" class="span1"  style="border-radius:50%;margin-top:10px"/> <strong>{$comment.author} </strong>
                                            <div> {$comment.content} </div>
                                            <small> {$comment.date} </small>
                                        </div>
                                    {/foreach}
                                </div>
                            {/if}*}


                            {*{if $allowcomments}
                                <br />
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="border p-3 p-sm-5">
                                            <h4 class="">{$lang.postcomment}</h4>

                                            <form  name="comment" method="post" action="blog/{$post.id}/{$post.seourl}">
                                                <input type="hidden" name="action" value="postcomment" />
                                                {if $posted}
                                                    <div    class="alert d-block alert-success"> {if $status eq 'pending'}
                                                            {$lang.commentsubmit}
                                                        {else}
                                                            {$lang.commentposted}
                                                        {/if} </div>
                                                {else}
                                                    {if $missing}
                                                        <div   class="alert d-block alert-danger" > {if $missing.name}{$lang.entername}<br />
                                                            {/if}
                                                            {if $missing.email}{$lang.enteremail}<br />
                                                            {/if}
                                                            {if $missing.message}{$lang.entercomment}<br />
                                                            {/if}
                                                            {if $missing.captcha}{$lang.wrongverify}{/if} </div>

                                                    {/if}
                                                {/if}


                                                <div class="form-row ">
                                                    {if $loggedin}
                                                        <div class="form-group  col-lg-6">
                                                            <label class="form-label">{$lang.name}</label>
                                                            <div class="controls">
                                                                <input type="hidden" name="isclient" value="true" />
                                                                <input type="text" name="name" class="form-control " size="30" value="{$userdetails.firstname} {$userdetails.lastname}" readonly="true" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group  col-lg-6">
                                                            <label class="form-label">{$lang.email}</label>
                                                            <div class="controls">
                                                                <input type="text" name="email"  class="form-control " size="30" value="{$userdetails.email}" readonly="true" />
                                                                <div class="text-muted">{$lang.notpublish}</div>
                                                            </div>
                                                        </div>

                                                    {else}
                                                        <div class="form-group  col-lg-6">
                                                            <label class="form-label">{$lang.name}</label>
                                                            <div class="controls">
                                                                <input type="text" name="name" size="30" class="form-control " value="{$userdetails.name}" />
                                                                *</div>
                                                        </div>
                                                        <div class="form-group  col-lg-6">
                                                            <label class="form-label">{$lang.email}</label>
                                                            <div class="controls">
                                                                <input type="text" name="email" size="30" class="form-control " value="{$userdetails.email}" />
                                                                * <br />
                                                                <small>{$lang.notpublish}</small></div>
                                                        </div>
                                                    {/if}
                                                </div>

                                                <div class="form-group ">
                                                    <label class="form-label">{$lang.websiteurl}</label>
                                                    <div class="controls">
                                                        <input type="text" name="url" size="30" class="form-control " value="{$commenter.url}" />
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label class="form-label">{$lang.comments}</label>
                                                    <div class="controls">
                                                        <textarea name="message" id="message" class="form-control " rows="4" cols="40" style="">{$commenter.message}</textarea>
                                                    </div>
                                                </div>
                                                {if $captcha}
                                                    <div class="form-group input-captcha">
                                                        <div class="controls">{$captcha}</div>
                                                    </div>
                                                {/if}

                                                <button type="submit" value="" class="btn btn-primary" >{$lang.submit}</button>


                                            </form>
                                        </div>
                                    </div>
                                </div>
                            {/if}*}


                        {else}


                            {foreach from=$posts item=post}
                                <blockquote class="blockquote  p-3">
                                    <a  href="{$post.seourl}">
                                        <div class="d-flex justify-content-between">
                                            <div  class="mb-2" >
                                                <h4 class="content-title">   {$post.title} </h4>
                                                <small class="text-muted"> {$post.date|date_format:"%d"} {$post.date|date_format:"%b"}, {$post.date|date_format:"%Y"} </small>
                                            </div>
                                            <small>
                                                <i class="fal fa-comments"></i> {$post.comments} &nbsp;&nbsp;&nbsp;
                                            </small>
                                        </div>
                                        <small>
                                            {$post.content}
                                        </small>
                                        <div class="blockquote-footer"> <i class="fal fa-user"></i>  {$post.author}</div>
                                    </a>
                                </blockquote>
                            {/foreach}



                        {/if}
                        </div>
                    </div>



                </div>






            {/if}

        </div>
    </div>
</div></div>
