<div class="container"><div class="page-container">

    <div class="card">

        <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link {if $smarty.get.action eq 'affiliate'} active {/if}"
                                    href="{$affiliatelink}">{$lang.banner} {$lang.code}</a></li>
            <li class="nav-item"><a class="nav-link {if $smarty.get.action eq 'affiliatetext'} active {/if}"
                                    href="{$affiliatelinktext}">{$lang.text} {$lang.code}</a></li>
            <li class="nav-item"><a class="nav-link {if $smarty.get.action eq 'affiliateitems'} active {/if}"
                                    href="{$affiliatelinkterm}">{$lang.affiliate} {$lang.product}</a></li>
            <li class="nav-item"><a class="nav-link {if $smarty.get.action eq 'affiliatehistory'} active {/if}"
                                    href="{$affiliatehistory}">{$lang.affiliate} {$lang.history}</a></li>
            <li class="nav-item"><a class="nav-link {if $smarty.get.action eq 'affiliatepayout'} active {/if}"
                                    href="{$affiliatepayout}">{$lang.affiliate} {$lang.payout}</a></li>
        </ul>
        <div class="tab-content mt-3">
            {if $showpay}
                <div class="tab-pane active" id="tab1">
                    <table class="table  table-striped">
                        <thead>
                        <tr>
                            <th width="150">
                                <div align="left">{$lang.date}</div>
                            </th>
                            <th>
                                <div align="left">{$lang.invoicestransid}</div>
                            </th>
                            <th width="200">
                                <div align="left">{$lang.amount}</div>
                            </th>
                        </tr>
                        </thead>
                        {foreach from=$history key=id item=det}
                            <tr id="">
                                <td>{$det.date}</td>
                                <td>{$det.tid}</td>
                                <td>{$det.amount|string_format:"%.2f"} {$currency.code}</td>
                            </tr>
                            {foreachelse}
                            <tr>
                                <td colspan="3" align="center">{$lang.norecordsfound}</td>
                            </tr>
                        {/foreach}
                    </table>
                </div>
            {elseif $showtab}
                <div class="tab-pane active" id="tab2">
                    <table class="table  table-striped">
                        <thead>
                        <tr>
                            <th width="80">
                                <div align="left">{$lang.date}</div>
                            </th>
                            <th>
                                <div align="left">{$lang.user}</div>
                            </th>
                            <th width="200">
                                <div align="left">{$lang.amount}</div>
                            </th>
                            <th width="100">
                                <div style="text-align:right">{$lang.commission}</div>
                            </th>
                        </tr>
                        </thead>
                        {foreach from=$history key=id item=det}
                            <tr id="">
                                <td>{$det.date}</td>
                                <td>{$det.user}</td>
                                <td>{$det.amount|string_format:"%.2f"} {$currency.code}</td>
                                <td>
                                    <div align="right">{$det.comission|string_format:"%.2f"} {$currency.code}</div>
                                </td>
                            </tr>
                            {foreachelse}
                            <tr>
                                <td colspan="4" align="center">{$lang.norecordsfound}</td>
                            </tr>
                        {/foreach}
                        <tr id="">
                            <td></td>
                            <td></td>
                            <td align="right"><strong>{$lang.balance}</strong>:</td>
                            <td align="center"> {$abalance|string_format:"%.2f"} {$currency.code}</td>
                        </tr>
                        <tr id="">
                            <td></td>
                            <td></td>
                            <td align="right"><strong>{$lang.payout}</strong>:</td>
                            <td align="center"> {$apayout|string_format:"%.2f"} {$currency.code}</td>
                        </tr>
                        <tr id="">
                            <td></td>
                            <td></td>
                            <td align="right"><strong>{$lang.pending} {$lang.payout}</strong>:</td>
                            <td align="center"> {$apending|string_format:"%.2f"} {$currency.code}</td>
                        </tr>
                    </table>
                </div>
            {elseif $text}
                <div class="tab-pane active" id="tab3">
                    {foreach from=$text key=id item=det}
                        <h4> {$det.image} </h4>
                        {$det.code}

                    {/foreach}
                </div>
            {elseif $affiliateitems}
                <div class="tab-pane active" id="tab4">
                    {if $userdetails.access.imeiservice}
                        {assign var='std' value='imei'}
                    {elseif $userdetails.access.serverlogservice}
                        {assign var='std' value='server'}
                    {elseif $cart}
                        {assign var='std' value='product'}
                    {/if}
                    {literal}
                    <script>
                        getContect('#tab2', 'settings/affiliateitems?name={/literal}{$std}{literal}', '#tabcontent1', true, '#loader');
                    </script>
                    <style>
                        .nav-block li {
                            display: block
                        }
                    </style>
                    {/literal}
                    <div class="tabbable tabs-left" style="background: white;padding:10px">
                        <ul class="nav nav-tabs nav-block">
                            {if $userdetails.access.imeiservice}
                                <li class="active"><a
                                            onclick="getContect('#tab2','settings/affiliateitems?name=imei','#tabcontent1',true,'#loader');"
                                            id="tab2">{$lang.imei}</a></li>
                            {/if}
                            {if $userdetails.access.serverlogservice}
                                <li>
                                    <a onclick="getContect('#tab14','settings/affiliateitems?name=server','#tabcontent1',true,'#loader');"
                                       id="tab14">{$lang.server}</a></li>
                            {/if}
                            {if $cart}
                                <li>
                                    <a onclick="getContect('#tab5','settings/affiliateitems?name=product','#tabcontent1',true,'#loader');"
                                       id="tab5">{$lang.product}</a></li>
                            {/if}

                        </ul>
                        <div class="tab-content">
                            <div id="tabcontent1"></div>
                        </div>
                    </div>
                </div>
            {else}
                <div class="tab-pane active" id="tab5">
                    {literal}
                        <script type="text/javascript" src="templates/default/js/zeroclipboard.js"></script>
                        <script language="JavaScript">
                            $(document).ready(function () {
                                var clip = null;

                                function $(id) {
                                    return document.getElementById(id);
                                }
                            });

                            function init() {
                                clip = new ZeroClipboard.Client();
                                clip.setHandCursor(true);
                            }

                            function move_swf(ee) {
                                copything = document.getElementById(ee.id + "_text").value;
                                clip.setText(copything);
                                if (clip.div) {
                                    clip.receiveEvent('mouseout', null);
                                    clip.reposition(ee.id);
                                } else {
                                    clip.glue(ee.id);
                                }
                                clip.receiveEvent('mouseover', null);
                            }
                        </script>
                    {/literal}
                    <body onload="init();">
                    <div>
                        {assign var='i' value='1'}
                        <table class="table table-striped">

                            {foreach from=$banners key=id item=det}
                                <tr>
                                    <td colspan="2"> {$det.name} </td>
                                    <td><span>{$det.code}</span></td>
                                    <td>
                                        <div id='textid{$i}' onMouseOver='move_swf(this)' class='clip_button'><span
                                                    class="label label-info" title="Click to Copy to Clipboard"
                                                    style="cursor:pointer">{$lang.copytoclipboard} <span></span></div>
                                    </td>
                                    <td colspan="2">
                                        <div>{$det.image}</div>
                                    </td>
                                </tr>
                                {assign var='i' value=$i+1}
                            {/foreach} </table>
                    </div>
                    </body>
                </div>
            {/if}
        </div>
    </div>
    </div></div>

