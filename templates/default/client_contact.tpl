<div class="container"><div class="page-container">
    <div class="card">
        <div class="row">
            <div class="col-lg-6 col-left">

                <div class="alert"></div>

                <form method="post" name="contact" id="contact">
                    {if $name}
                        {if $itemname}
                            <input type="hidden" name="inquiry" value="{$inquiry}"/>
                            <div class="form-group ">
                                <label>
                                    {$lang.item}
                                </label>
                                {$itemname}
                            </div>
                        {/if}
                        <div class="form-row ">
                            <div class="form-group  col-lg-6">
                                <label>
                                    {$lang.name}
                                </label>
                                {$name}
                            </div>
                            <div class="form-group  col-lg-6">
                                <label>
                                    {$lang.email}
                                </label>
                                {$email}
                            </div>
                        </div>
                        <div class="form-group  stextarea">
                            <label>
                                {$lang.query}
                            </label>
                            {$query}
                        </div>
                        {if $itemname}
                            <div class="form-group ">
                                <label>
                                    {$lang.contactno}.
                                </label>
                                <input type="text" name="phone" value=""/>
                            </div>
                        {else}
                            {if $customfields}
                                {foreach from=$customfields key=name item=fields}
                                    <div class="form-group ">
                                        <label>
                                            {$name}
                                        </label>
                                        {$fields.input}{$fields.required} {$fields.description}
                                    </div>
                                {/foreach}
                            {/if}
                        {/if}
                        {if $loggedin}
                        {else}
                            <div class="form-group input-captcha">
                                {$captcha}
                            </div>
                        {/if}
                    {/if}
                    <button type="submit" class="btn btn-primary" id="send"
                            onclick="SubmitFormJSON('#send','{$action_link}','#contact','.alert','true','#loader');"
                            name="send" value="{$lang.submit}">
                        {$lang.submit}
                    </button>
                </form>
                <br/>
                {$content}
            </div>

            <div class="col-lg-6 col-right">

                {if $contactusphone}
                    <div><i class="fas fa-phone"></i> {$contactusphone} </div>
                {/if}
                {if $contactusdisplayemail}
                    <div>  <i class="fas fa-envelope"></i>  {$contactusdisplayemail}  </div>
                {/if}
                {if $contactusaddress}
                    <address><i class="fa fa-map-marker"></i> {$contactusaddress} </address>
                {/if}

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
    </div>
    </div></div>

