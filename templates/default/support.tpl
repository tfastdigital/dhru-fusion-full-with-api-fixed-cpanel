{literal}
    <script>
        function addMoreFiles() {
            $("#suppf").append('<input type="file" name="files[]" /><br/>');
            //designFilefield();
        }
    </script>
{/literal}


<div class="container"><div class="page-container">
    <div class="card">

        <div   class="alert"></div>

        {if $step eq 1}
            <div class="row">
                {foreach from=$department key=id item=depart}
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <div class="border  p-3 text-center">
                            <h5>
                                <a href="{$depart.seo}" class="d-block">
                                    {$depart.department}
                                </a>
                            </h5>
                            {if $depart.iconlink}<img src="{$depart.iconlink}"/>{/if}
                            <div class="info">
                                {$depart.info}
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        {/if}

        {if $step eq 2 and $department neq ""}
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <form method="post" name="contact" id="contact" enctype="multipart/form-data">


                        {$department}


                        <div class="row">
                            <div class="col-lg-6">

                                <div class="form-row">
                                    <div class="form-group mb-0 col-12">
                                         {if $name} <i class="fa fa-user-alt mr-2"></i> {$name}{else}-{/if}
                                    </div>
                                    <div class="form-group col-12">
                                        <span class="d-block"> <i class="fa fa-envelope-open mr-2"></i> {$email}</span>
                                    </div>
                                </div>


                                <div class="form-group ">
                                    <label>
                                        {$lang.subject}
                                    </label>
                                    {$subject}
                                </div>


                                {if $orders}
                                    <div class="form-group ">
                                        <label>
                                            {$lang.order}
                                        </label>

                                        <select name="oid" class="form-control ">
                                            <option value="">{$lang.select}</option>
                                            {foreach from=$orders key=id item=det}
                                                <option value="{$det.order_id}">{$det.product} {if $det.domain}- {$det.domain}{/if} </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                {/if}

                                <div class="form-group ">
                                    <label>
                                        {$lang.priority}
                                    </label>

                                    <select name="priority" class="form-control ">
                                        {foreach from=$priority key=id item=depart}
                                            <option value="{$id}">{$depart}</option>
                                        {/foreach}
                                    </select>

                                </div>

                                <div class="form-group ">
                                    <label>
                                        {$lang.message}
                                    </label>
                                    {$message}
                                </div>

                                {if !$loggedin}
                                    <div class="form-group  input-captcha">
                                        {$captcha}
                                    </div>
                                {/if}


                                <div class="d-actionbar-mobile">
                                    <button type="submit" class="btn btn-primary mb-2" id="send"
                                            onclick="SubmitFormJSON('#send','{$action_link}','#contact','.alert','true','#loader');"
                                            name="send" value="{$lang.submit} {$lang.ticket}">
                                        {$lang.submit} {$lang.ticket}
                                    </button>
                                </div>

                                <div  id="notification1">
                                    {$lang.knowledgebasehelp}
                                </div>
                                <div id="searchKnowledgebase"></div>

                            </div>


                            <div class="col-lg-6">

                                {if $contactusphone}
                                    <div><i class="fas fa-phone"></i> {$contactusphone} </div>
                                {/if}
                                {if $contactusdisplayemail}
                                    <div><i class="fas fa-envelope"></i> {$contactusdisplayemail}  </div>
                                {/if}
                                <address class="mt-3"><i class="fa fa-map-marker"></i> {$contactusaddress} </address>


                                <div class="mapouter">
                                    <div class="gmap_canvas">

                                        <iframe
                                                width="100%"
                                                height="100%"
                                                frameborder="0"
                                                scrolling="no"
                                                marginheight="0"
                                                marginwidth="0"
                                                src="https://maps.google.com/maps?q={$locationlatitude},{$locationlongitude}&hl=es&z=14&amp;output=embed"
                                        >
                                        </iframe>
                                    </div>
                                    {literal}
                                        <style>
                                            .mapouter {
                                                position: relative;
                                                text-align: right;
                                                height: 400px;
                                                width: 100%;
                                            }

                                            .gmap_canvas {
                                                overflow: hidden;
                                                background: none !important;
                                                height: 400px;
                                                width: 100%;
                                            }
                                        </style>
                                    {/literal}
                                </div>

                            </div>

                        </div>





                    </form>
                </div>
            </div>
        {/if}

    </div>
    </div></div>


