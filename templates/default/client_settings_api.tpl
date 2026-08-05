<div class="container"><div class="page-container">


    <div class="card card-simple-form">





        <div class="col-lg-6 p-0 m-auto">
            <div class="alert"></div>
        <form method="post" name="api" id="frm-api">

            {$token}
            <div class="form-group ">
                <label>{$lang.apikey}</label>
                {$api}
            </div>

            <div class="form-group ">
                <label>{$lang.apiip}</label>
                {$ip}
                <div class="text-muted">{$lang.apiinfo}</div>
            </div>

            {if $pin eq 1}
                <div class="form-group ">
                    <label>{$lang.masterpin}</label>
                    <input type="password" name="masterpin" class="form-control " id="masterpin" maxlength="4"/>
                </div>
            {/if}

            <div class="api-access-btns d-flex">
            {if $actionsaveip}
                <button class="btn btn-primary mb-2" type="submit" name="resetip"
                        value="{$lang.reset} {$lang.ip}">{$lang.reset} {$lang.ip}</button>
            {/if}
            <button type="submit" class="btn btn-primary mb-2 mr-2" id="save"
                    onClick="SubmitForm('#save','{$action_link}','#frm-api','.alert','true','#loader','','',function(data){ submitCallback(data); })"
                    name="save" value="{$lang.renew}"><i class="fal fa-retweet"></i> {$lang.renew}</button>
            <button type="submit" class="btn btn-secondary mr-2 mb-2 ml-auto" name="showkey"
                    value="{$lang.showkey}"><i class="fal fa-eye"></i> {$lang.showkey}</button>
            <button type="button" class="btn btn-secondary  mb-2" name="downloadapi"
                    value="{$lang.download} {$lang.api} {$lang.document}" class="button_gray"
                    onclick="javascript:location.href='clientapi.zip'">
                    <i class="fal fa-download"></i>
                {$lang.download} {$lang.api} {$lang.document}
            </button>
            </div>

        </div>

        </form>
    </div>

    </div></div>

{literal}
  <script>
    function submitCallback(data){
      if(data === 'success'){
        window.location.reload();
      }
    }
  </script>
{/literal}
