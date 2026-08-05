{literal}
<script>
    $('#imei').change(function () {
        var str;
        str = $(this).val();
        if (str != '') {
            $.get("{/literal}{$getpricelink}{literal}", {id: str, service: "imei"},
                function (data) {
                    var substr = data.split('|');
                    $("#idetail").show();
                    $("#idetail #price").html(substr[0] + "{/literal}{$currency.code}{literal}");
                    $("#idetail #days").html(substr[1] + " days");
                });
        }
    });
    $('#file').change(function () {
        var str;
        str = $(this).val();
        if (str != '') {
            $.get("{/literal}{$getpricelink}{literal}", {id: str, service: "file"},
                function (data) {
                    var substr = data.split('|');
                    $("#fdetail").show();
                    $("#fdetail #price").html(substr[0] + "{/literal}{$currency.code}{literal}");
                    $("#fdetail #days").html(substr[1] + " days");
                });
        }
    });
    $('#server').change(function () {
        var str;
        str = $(this).val();
        if (str != '') {
            $.get("{/literal}{$getpricelink}{literal}", {id: str, service: "server"},
                function (data) {
                    var substr = data.split('|');
                    $("#sedetail").show();
                    $("#sedetail #price").html(substr[0] + "{/literal}{$currency.code}{literal}");
                    $("#sedetail #days").html(substr[1] + " days");
                });
        }
    });
    $('#shop').change(function () {
        var str;
        str = $(this).val();
        if (str != '') {
            $.get("{/literal}{$getpricelink}{literal}", {id: str, service: "shop"},
                function (data) {
                    var substr = data.split('|');
                    $("#shdetail").show();
                    $("#shdetail #price").html(substr[0] + "{/literal}{$currency.code}{literal}");
                    $("#shdetail #days").html(substr[1] + " days");
                });
        }
    });
</script>
{/literal}


<div class="p-lg-3">

{if $notification}
    <div class="alert1  alert {$class}">{$msg}</div>
{else}
    <div class="alert"></div>
{/if}

{if $servicelist}
    <div>
        <form method="post" name="frmimei" id="frmimei" class="mb-4 bottom-space">
            {$token}


            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group">

                        <select name="imei" id="imei" class="form-control no-chosen">
                            <option value="">{$lang.select}</option>

                            {foreach from=$servicelist key=id item=Services}
                                <option value="{$Services.id}">{$Services.service_name}</option>
                            {/foreach}

                        </select>

                        <div class="input-group-append">
                            <button type="submit" id="save" class="btn btn-primary"
                                    onclick="SubmitForm('#save','{$buynowlink}','#frmimei','.alert','true','#loader',true);"
                                    name="save" value="{$lang.buy} {$lang.now}">{$lang.buy} {$lang.now}</button>
                        </div>
                        </div>

                    </div>

                <div class="col-lg-6">
                    <div id="idetail">
                        <div class="row">
                            <div class="col"><label>{$lang.price}</label> <span id="price"></span></div>
                            <div class="col"><label>{$lang.days}</label> <span id="days"></span></div>
                        </div>
                    </div>
                </div>

            </div>

        </form>
    </div>
    <div class="table-responsive">
        <table class="table   table-striped">
            <thead>
            <tr>
                <th>{$lang.service}</th>
                <th>{$lang.subscription} {$lang.date}</th>
                <th>{$lang.subscription} {$lang.end}</th>
                <th>{$lang.price}</th>
                <th>{$lang.status}</th>
                <th>{$lang.action}</th>
            </tr>
            </thead>
            <tbody>

            {foreach from=$subscription key=id item=t}
                <tr>
                    <td>{$t.service}</td>
                    <td>{$t.subscribe_start}</td>
                    <td>{$t.subscribe_end}</td>
                    <td>{$t.price} {$currency.code}</td>
                    <td>{$t.status}</a></td>
                    <td> {if $t.stat eq 'expired'}
                            <form method="post" name="frmimei{$id}" id="frmimei{$id}">
                                <input type="hidden" name="imei" value="{$t.service_id}"/>
                                {$token}
                                <a href="javascript: void(0);" id="save{$id}"
                                   onclick="SubmitForm('#save{$id}','{$buynowlink}','#frmimei{$id}','.alert','true','#loader',true);"
                                >{$lang.renew}</a>
                            </form>
                        {else}
                            -
                        {/if} </td>

                </tr>
                {foreachelse}
                <tr>
                    <td colspan="6" class="text-center">{$lang.norecordsfound}</td>
                </tr>
            {/foreach}
            </tbody>

        </table>
    </div>
{/if}


{if $fileservicelist}
    <form method="post" name="frmfile" id="frmfile" class="mb-4 bottom-space">
        {$token}

        <div class="row">
        <div class="col-lg-4">
        <div class="input-group">

            <select name="file" id="file" class="form-control no-chosen">
                <option value="">{$lang.select}</option>
                {foreach from=$fileservicelist key=id item=Services}
                    <option value="{$Services.id}">{$Services.service_name}</option>
                {/foreach}
            </select>

            <div class="input-group-append">
                <button type="submit" class="btn btn-primary" id="save"
                        onclick="SubmitForm('#save','{$buynowlink}','#frmfile','.alert','true','#loader',true);"
                        name="save" value="{$lang.buy} {$lang.now}">{$lang.buy} {$lang.now}</button>
            </div>

        </div>

        </div>

        <div class="col-lg-6">
            <div id="fdetail" class="">
                <div class="d-flex">
                    <div class="form-group"><label class="font-normal text-muted">{$lang.price}</label> <div id="price"></div></div>
                    <div class="form-group ml-4"><label class="font-normal  text-muted">{$lang.days}</label> <div id="days"></div></div>
                </div>
            </div>
        </div>

        </div>

    </form>
    <div class="table-responsive">
        <table class="table border-0  table-striped">
            <thead>
            <tr>
                <th>{$lang.service}</th>
                <th>{$lang.subscription} {$lang.date}</th>
                <th>{$lang.subscription} {$lang.end}</th>
                <th>{$lang.price}</th>
                <th>{$lang.status}</th>
                <th>{$lang.action}</th>
            </tr>
            </thead>
            <tbody>

            {foreach from=$subscription key=id item=t}
                <tr>
                    <td>{$t.service}</td>
                    <td>{$t.subscribe_start}</td>
                    <td>{$t.subscribe_end}</td>
                    <td>{$t.price} {$currency.code}</td>
                    <td>{$t.status}</td>
                    <td> {if $t.stat eq 'expired'}

                            <form method="post" name="frmfile{$id}" id="frmfile{$id}">
                                <input type="hidden" name="file" value="{$t.service_id}"/>
                                {$token}
                                <a href="javascript: void(0);" id="save{$id}"
                                   onclick="SubmitForm('#save{$id}','{$buynowlink}','#frmfile{$id}','.alert','true','#loader',true);"
                                >{$lang.renew}</a>
                            </form>
                        {else}
                            -
                        {/if} </td>

                </tr>
                {foreachelse}
                <tr>
                    <td colspan="6" class="text-center">{$lang.norecordsfound}</td>
                </tr>
            {/foreach}
            </tbody>

        </table>
    </div>
{/if}




{if $serverservicelist}
    <div>
        <form method="post" name="frmserver" id="frmserver" class="mb-4 bottom-space">
            {$token}

            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group">

                        <select name="server" id="server" class="form-control no-chosen ">
                            <option value="">{$lang.select}</option>
                            {foreach from=$serverservicelist key=id item=Services}
                                <option value="{$Services.id}">{$Services.service_name}</option>
                            {/foreach}
                        </select>

                        <div class="input-group-append">
                            <button type="submit" id="save" class="btn btn-primary mb-2"
                                    onclick="SubmitForm('#save','{$buynowlink}','#frmserver','.alert','true','#loader',true);"
                                    name="save" value="{$lang.buy} {$lang.now}">{$lang.buy} {$lang.now}</button>
                        </div>

                    </div>

                </div>

                <div class="col-lg-6">
                    <div id="sedetail" class="">
                        <div class="d-flex">
                            <div class="form-group"><label class="font-normal text-muted">{$lang.price}</label> <div id="price"></div></div>
                            <div class="form-group ml-4"><label class="font-normal  text-muted">{$lang.days}</label> <div id="days"></div></div>
                        </div>
                    </div>
                </div>

            </div>


        </form>
    </div>
    <div class="table-responsive">
        <table class="table  table-stripted">
            <thead>
            <tr>
                <th>{$lang.service}</th>
                <th>{$lang.subscription} {$lang.date}</th>
                <th>{$lang.subscription} {$lang.end}</th>
                <th>{$lang.price}</th>
                <th>{$lang.status}</th>
                <th>{$lang.action}</th>
            </tr>
            </thead>
            <tbody>

            {foreach from=$subscription key=id item=t}
                <tr>
                    <td>{$t.service}</td>
                    <td>{$t.subscribe_start}</td>
                    <td>{$t.subscribe_end}</td>
                    <td>{$t.price} {$currency.code}</td>
                    <td>{$t.status}</a></td>
                    <td> {if $t.stat eq 'expired'}
                            <form method="post" name="frmserver{$id}" id="frmserver{$id}">
                                <input type="hidden" name="server" value="{$t.service_id}"/>
                                {$token}
                                <a href="javascript: void(0);" id="save{$id}"
                                   onclick="SubmitForm('#save{$id}','{$buynowlink}','#frmserver{$id}','.alert','true','#loader',true);"
                                >{$lang.renew}</a>
                            </form>
                        {else}
                            -
                        {/if} </td>

                </tr>
                {foreachelse}
                <tr>
                    <td colspan="6" class="text-center">{$lang.norecordsfound}</td>
                </tr>
            {/foreach}
            </tbody>

        </table>
    </div>
{/if}

{if $shopservicelist}
    <div>
        <form method="post" name="frmshop" id="frmshop">{$token}
            <div class="row">
                <div class="form-group col">
                    <select name="shop" id="shop" class="form-control  mb-2 mr-sm-2 col-lg-4">
                        <option value="">{$lang.select}</option>

                        {foreach from=$shopservicelist key=id item=Services}
                            <option value="{$Services.id}">{$Services.service_name}</option>
                        {/foreach}

                    </select>
                </div>

                <div id="shdetail" class="mb-2 mr-sm-2  col-auto">
                    <div class="row">
                        <div class="col"><label>{$lang.price}</label> <span id="price"></span></div>
                        <div class="col"><label>{$lang.days}</label> <span id="days"></span></div>
                    </div>
                </div>


                <div class="col-auto">
                    <button type="submit" id="save" class="btn btn-primary mb-2"
                            onclick="SubmitForm('#save','{$buynowlink}','#frmshop','.alert','true','#loader',true);"
                            name="save" value="{$lang.buy} {$lang.now}">{$lang.buy} {$lang.now}</button>
                </div>

            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table   table-stripted">
            <thead>
            <tr>
                <th>{$lang.service}</th>
                <th>{$lang.subscription} {$lang.date}</th>
                <th>{$lang.subscription} {$lang.end}</th>
                <th>{$lang.price}</th>
                <th>{$lang.status}</th>
                <th>{$lang.action}</th>
            </tr>
            </thead>
            <tbody>

            {foreach from=$subscription key=id item=t}
                <tr>
                    <td>{$t.service}</td>
                    <td>{$t.subscribe_start}</td>
                    <td>{$t.subscribe_end}</td>
                    <td>{$t.price} {$currency.code}</td>
                    <td>{$t.status}</td>
                    <td> {if $t.stat eq 'expired'}
                            <form method="post" name="frmshop{$id}" id="frmshop{$id}">
                                <input type="hidden" name="shop" value="{$t.service_id}"/>
                                {$token}
                                <a href="javascript: void(0);" id="save{$id}"
                                   onclick="SubmitForm('#save{$id}','{$buynowlink}','#frmshop{$id}','.alert','true','#loader',true);"
                                >{$lang.renew}</a>
                            </form>

                        {else}
                            -
                        {/if} </td>

                </tr>
                {foreachelse}
                <tr>
                    <td colspan="6" class="text-center">{$lang.norecordsfound}</td>
                </tr>
            {/foreach}
            </tbody>

        </table>
    </div>
{/if}

</div>
