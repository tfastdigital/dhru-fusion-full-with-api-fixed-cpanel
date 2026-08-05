
<div class="container"><div class="page-container">

    <div class="card">

        <ul class="nav nav-pills flex-nowrap">
            <li class="nav-item "><a class="nav-link  {if $activetab} {else} active {/if}" data-toggle="tab"
                                     onclick="javascript: location.href='{$imeitablink}';"
                                     href="#imei">{$lang.imei} {$lang.orders}</a></li>
            <li class="nav-item "><a class="nav-link  {if $activetab eq 'file'} active {/if}" data-toggle="tab"
                                     onclick="javascript: location.href='{$filetablink}';"
                                     href="#file">{$lang.file} {$lang.orders}</a></li>
            <li class="nav-item "><a class="nav-link  {if $activetab eq 'newserver'} active {/if}" data-toggle="tab"
                                     onclick="javascript: location.href='{$servertablink}';"
                                     href="#server">{$lang.server} {$lang.orders}</a></li>
        </ul>


        <div class="tab-content">


            {if $notification.success}
                <div class="alert alert-success">{$notification.success}</div>
            {elseif $notification.error}
                <div class="alert alert-danger">{$notification.error}</div>
            {/if}

            {if $smarty.get.order eq 'imei'}
                <div class="tab-pane {if $activetab eq 'newserver'} active {elseif $activetab}  {else} active {/if}"
                     id="tab1">


                    <form method="post" name="filterorderimei" id="filterorderimei" action="{$searchlink}">
                        <input type="hidden" name="order" value="imei"/>

                        {$token}
                        <div class="d-flex mt-3">

                            <div class="form-group mr-3  ml-auto">
                                <select name="user" class="form-control" id="service_id">
                                    <option value="">{$lang.select}</option>
                                    {foreach from=$myusers key=id item=user}
                                        <option value="{$id}">{$user.username}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="form-group mr-3">
                                <input type="text" name="searchvalue" class="form-control"/>
                            </div>
                            <div>
                                <input type="submit" class="btn btn-primary" name="search" value="{$lang.search}"/>
                            </div>

                        </div>
                    </form>


                    <div class="table-responsive">
                        <table class="table  table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#{$lang.ID} </th>
                                <th>{$lang.status}</th>
                                <th>{$lang.service}</th>
                                {if $activetab neq 'newserver'}
                                    <th>{$lang.imei}</th>
                                {/if}
                                <th>{$lang.reply}</th>
                                <th></th>
                            </thead>
                            </tr>
                            {foreach from=$imeiorderslist key=id item=order}
                                <tr class="href"   href="{$order.seo}?standalone=true" data-target="#modal-ajax" data-toggle="modal" data-whatever="View Order #{$order.encnum}">
                                    <td>{$order.encnum}</td>
                                    <td>
                                        <label class="label {if $order.status eq 'Pending'} label-warning {elseif $order.status eq 'Accepted'} label-warning {elseif $order.status eq 'Replied'} label-success {elseif $order.status eq 'Rejected'} label-important {/if}"> {$order.status} </label>
                                    </td>
                                    <td>{$order.service}</td>
                                    {if $activetab neq 'newserver'}
                                        <td>{$order.imei}</td>
                                    {/if}
                                    <td>{$order.reply}</td>
                                    <td></td>
                                </tr>
                                {foreachelse}
                                <tr>
                                    <td colspan="7" align="center">{$lang.norecordsfound}</td>
                                </tr>
                            {/foreach}

                        </table>
                    </div>

                    <div class="pagination">{$paginate}</div>

                </div>
            {/if}


            {if $smarty.get.order eq 'file' or $smarty.post.order eq 'file'}
                <div class="tab-pane {if $activetab eq 'file'} active {/if}" id="tab2">


                    <form method="post" name="filterorderfile" id="filterorderfile" action="{$searchlink}">
                        <input type="hidden" name="order" value="file"/>
                        {$token}


                        <div class="d-flex mt-3 ">

                            <div class="form-group mr-3 ml-auto">
                                <select name="user" class="form-control" id="service_id">
                                    <option value="">{$lang.select}</option>
                                    {foreach from=$myusers key=id item=user}
                                        <option value="{$id}">{$user.username}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="form-group mr-3">
                                <input type="text" name="searchvalue" class="form-control"/>
                            </div>
                            <div>
                                <input type="submit" class="btn btn-primary" name="search" value="{$lang.search}"/>
                            </div>

                        </div>

                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#{$lang.ID}</th>
                                <th>
                                    <div>{$lang.status}</div>
                                </th>
                                <th>
                                    <div>{$lang.service}</div>
                                </th>
                                <th>
                                    <div>{$lang.file}</div>
                                </th>
                                <th>{if $status neq 'pending'}
                                        <div>{$lang.reply}</div>{/if}</th>
                                <th></th>
                            </tr>
                            </thead>
                            {foreach from=$fileorderslist key=id item=order}
                                <tr class="href"  onclick="vieworderdetail('{$order.encnum}')">
                                    <td>{$id}</td>
                                    <td>
                                        <label class="label {if $order.status eq 'Pending'} label-warning {elseif $order.status eq 'Accepted'} label-warning {elseif $order.status eq 'Replied'} label-success {elseif $order.status eq 'Rejected'} label-important {/if}"> {$order.status} </label>
                                    </td>
                                    <td>{$order.service}</td>
                                    <td>{$order.file}</td>
                                    <td>
                                        {if $status neq 'pending'}{$order.reply}{/if}</td>
                                    <td></td>
                                </tr>
                                {foreachelse}
                                <tr>
                                    <td colspan="6">{$lang.norecordsfound}</td>
                                </tr>
                            {/foreach}

                        </table>
                    </div>
                    <div class="pagination">{$paginate}</div>
                </div>
            {/if}


            {if $smarty.get.order eq 'server' or $smarty.post.order eq 'server'}
                <div class="tab-pane {if $activetab eq 'server'} active {/if}" id="tab3">


                    <form method="post" name="filterorderserver" id="filterorderserver" action="{$searchlink}">
                        <input type="hidden" name="order" value="server"/>
                        {$token}

                        <div class="d-flex mt-3">

                            <div class="form-group mr-3  ml-auto">
                                <select name="user" class="form-control" id="service_id">
                                    <option value="">{$lang.select}</option>
                                    {foreach from=$myusers key=id item=user}
                                        <option value="{$id}">{$user.username}</option>
                                    {/foreach}
                                </select>
                            </div>

                            <div class="form-group mr-3">
                                <input type="text" name="searchvalue" class="form-control"/>
                            </div>

                            <div>
                                <input type="submit" class="btn btn-primary" name="search" value="{$lang.search}"/>
                            </div>

                        </div>

                    </form>

                    <div class="table-responsive">
                        <table class="table  table-striped table-hover">
                            <thead>
                            <tr>

                                <th>#{$lang.ID}</th>
                                <th>{$lang.status}</th>
                                <th>
                                    <div>{$lang.service}</div>
                                </th>
                                <th>{if $status neq 'pending'}
                                        <div>{$lang.reply}</div>{/if}</th>
                                <th></th>
                            </tr>
                            </thead>
                            {foreach from=$serverorderslist key=id item=order}
                                <tr class="href"  onclick="vieworderdetail('{$order.encnum}')">
                                    <td>{$id}</td>
                                    <td>
                                        <label class="label {if $order.status eq 'Pending'} label-warning {elseif $order.status eq 'Accepted'} label-warning {elseif $order.status eq 'Replied'} label-success {elseif $order.status eq 'Rejected'} label-important {/if}"> {$order.status} </label>
                                    </td>
                                    <td>{$order.service}</td>
                                    <td>{if $status neq 'pending'}{$order.reply}{/if}</td>
                                    <td></td>
                                </tr>
                                {foreachelse}
                                <tr>
                                    <td colspan="6">{$lang.norecordsfound}</td>
                                </tr>
                            {/foreach}

                        </table>
                    </div>
                    <div class="pagination">{$paginate}</div>

                </div>
            {/if}

        </div>
    </div>


    </div></div>


