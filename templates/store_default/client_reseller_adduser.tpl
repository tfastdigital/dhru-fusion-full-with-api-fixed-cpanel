<div class="container"><div class="page-container">

    <div class="card card-simple-form" >

        <div class="row">
            <div class="col-lg-4 m-auto">

                {*<ul class="nav nav-pills flex-nowrap">
                    <li class="nav-item "><a class="nav-link  active" href="#tab1" data-toggle="tab">{$lang.adduser}</a>
                    </li>
                    <li class="nav-item "><a class="nav-link " href="#tab2"
                                             data-toggle="tab">{$lang.addmultipleuser}</a></li>
                </ul>*}
                <div class="tab-content">

                    {if $notification}
                        <div class="alert1 alert alert-success">{$notification.success}</div>
                    {else}
                        <div class="alert"></div>
                    {/if}

                    <div class="tab-pane active pt-lg-3 pb-lg-3" id="tab1">
                        <form method="post" name="adduser" id="adduser">

                            {$token}

                            <div class="form-row ">
                                <div class="form-group  col-lg-6">
                                    <label>{$lang.username}</label>
                                    {$username}
                                </div>
                                <div class="form-group  col-lg-6">
                                    <label>{$lang.password}</label>
                                    {$password}
                                </div>
                            </div>

                            <div class="form-group ">
                                <label>{$lang.email}</label>
                                {$email}
                            </div>
                            <div class="form-group ">
                                <label>{$lang.credit}</label>
                                {$credit}
                            </div>

                            <div class="form-group ">
                                <label>{$lang.country}</label>
                                {$country}
                            </div>


                            {if $customfields}
                                {foreach from=$customfields key=name item=fields}
                                    <div class="form-group ">
                                        <label>{$name}:</label>
                                        {$fields.input} {$fields.description}
                                    </div>
                                {/foreach}
                            {/if}

                            <div class="d-actionbar-mobile">
                                <button type="submit" class="btn btn-primary w-100" id="createuser"
                                        onclick="SubmitForm('#createuser','{$action_link}','#adduser','.alert','true','#loader');"
                                        name="createuser" value="{$lang.save}">{$lang.save}</button>
                            </div>
                        </form>
                    </div>

                   {* <div class="tab-pane py-3" id="tab2">
                        <form method="post" enctype="multipart/form-data">
                            {$token}

                            <div class="form-group">
                                <label>{$lang.upload} CSV {$lang.file}</label>
                                <div class="input-group">
                                    <input type="file" class="form-control -file" name="csv"/>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn input-group-text btn-primary" id="createuser"
                                                name="uploaduser" value="{$lang.upload}">{$lang.upload}</button>
                                    </div>
                                </div>
                            </div>

                        </form>

                        <div class="form-group ">
                            <label>{$lang.fileformat}</label> <br/>
                            <textarea class="form-control "> testuser,test123,test@domain.com,200  test2,pass292929,test@yahoo.com,150 </textarea>
                            <div class="text-muted">"Username","Password","Email","Credit"</div>
                        </div>
                    </div>*}

                </div>
            </div>
        </div>
    </div>
    </div></div>
