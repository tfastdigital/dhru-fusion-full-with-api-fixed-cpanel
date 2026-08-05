<div class="container"><div class="page-container">



        <div class="alert"></div>

        <div class="row">

            {include file="templates/default/download_rightmenu.tpl"}

            <div class="col-lg-9">
                <div class="card">

                {if $downloads}
                    {if $downloadscats}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th><span>{$lang.directory}</span></th>
                                    <th>{$lang.item}</th>
                                </tr>
                                </thead>
                                <tbody>
                                {foreach from=$downloadscats item=ds}
                                    <tr>
                                        <td>
                                            <a href="{$ds.seo}"><i class="fa fa-folder-open"></i> {$ds.groupname}</a>
                                            <div>{$ds.info|strip_tags}</div>
                                        </td>
                                        <td>{$ds.artical}</td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                        </div>
                    {/if}
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead>
                            <tr>
                                <th><span>File Name</span></th>
                                <th>Actions</th>
                                <th>Size</th>
                                <th>Uploaded</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach from=$downloads item=t}
                                <tr>

                                    <td>

                                        <div>
                                            {assign var=foo value="."|explode:$t.filename}

                                            {*{if $foo[1] eq 'jpg'}
                                                <img src="templates/default/images/jpg.png"/>
                                            {elseif $foo[1] eq 'gif' || $foo[1] eq 'png'}
                                                <img src="templates/default/images/imageicon.png"/>
                                            {elseif $foo[1] eq 'zip'}
                                                <img src="templates/default/images/zip.png"/>
                                            {/if}*}

                                            <span>
                                                 {if $t.external}
                                                     <a href="{$t.external}" target="_blank">
                                                         {$t.filename}
                                                      </a>
                                                {else}
                                                     {$t.filename}
                                                 {/if}
                                            </span>
                                        </div>

                                        <div class="text-muted">{$t.description}</div>
                                    </td>

                                    <td >
                                        <a href="{$t.downloadlink}" class="text-center">
                                            {if $t.reqlogin && !$loggedin}
                                                <i class="fal fa-lock"></i>
                                            {else}
                                                <i class="fal fa-download"></i>
                                            {/if}
                                        </a>
                                    </td>
                                    <td> {$t.size}MB</td>
                                    <td> {$t.counter} </td>
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                {else}

                    {if $allpages}
                    {else}
                        <div class="text-center p-3">{$lang.nomatchfound}</div>
                    {/if}

                {/if}


                {if $allpages}
                    <table class="table  table-striped">
                        <thead>
                        <tr>
                            <th><span>{$lang.directory}</span></th>
                            <th>{$lang.item}</th>
                        </tr>
                        </thead>
                        {foreach from=$allpages item=t}
                            <tr>
                                <td>
                                    <a href="{$t.seo}"><i class="fal fa-folder-open"></i> {$t.groupname}</a>
                                    <div>{$t.info|strip_tags}</div>
                                </td>
                                <td>{$t.artical}</td>
                            </tr>
                        {/foreach}
                    </table>
                {/if}

                </div>
            </div>

        </div>



    </div></div>
