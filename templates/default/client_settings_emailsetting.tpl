<div class="container"><div class="page-container">

    <div class="card">

        {if $id && $message}

            {if $notification.success}
                <div class="alert1 alert alert-success">{$notification.success}</div>
            {elseif $notification.error}
                <div class="alert1 alert alert-danger">{$notification.error}</div>
            {else}
                <div class="alert"></div>
            {/if}
            <form method="post" name="editemail" id="editemail">


                <input type="hidden" name="id" value="{$ids}"/>
                {$token}
                <div class="form-group ">
                    <label>{$lang.subject}</label>
                    {$subject} </div>
                <div class="form-group ">
                    <label>{$lang.message}</label>
                    {$message} </div>
                <div class="form-group ">
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="save"
                            onclick="SubmitForm('#save','{$action_link}','#editemail','.alert','true','#loader',true);"
                            name="save" value="{$lang.save}">{$lang.save}</button>
                    <button type="submit" class="btn btn-secondary" id="reset" name="reset"
                            value="{$lang.reset} {$lang.to} {$lang.default}">{$lang.reset} {$lang.to} {$lang.default}</button>
                </div>
            </form>
        {else}
            <form method="post" name="imeipricing" id="imeipricing">
                <div class="table-responsive">



                        {foreach from=$emailtemplatelist key=GroupName item=Temp}
                            <table class="table  table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> <h5>{$GroupName}</h5></th>
                                    </tr>
                                </thead>
                                <tbody>
                                {foreach from=$Temp key=id item=email}
                                    <tr class="href" href="{$email.link}?standalone=true" data-toggle="modal"
                                        data-target="#modal-ajax" data-whatever="{$email.name}">
                                        <td>{$email.name}</td>

                                    </tr>
                                    {foreachelse}
                                    <tr>
                                        <td colspan="4" class="text-center">{$lang.norecordsfound}</td>
                                    </tr>
                                {/foreach}

                                </tbody>
                            </table>
                            <br/><br/>
                        {/foreach}



                </div>
            </form>
        {/if} </div>
    </div></div>
