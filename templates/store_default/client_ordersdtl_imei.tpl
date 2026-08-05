
{literal}
    <script type="text/javascript">
        $(function() {
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
            $('#from,#to').datepicker({ format: 'yyyy-mm-dd'}).on('changeDate', function(e){
                $(this).datepicker('hide');
            });
        });
    </script>
{/literal}

<!-- Modal -->
<div class="modal hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{$lang.search} {if $serverservice neq 2 && $serverservice neq 1 }{$lang.imei}{else}{$lang.server}{/if} {$lang.order} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span> </button>
            </div>
            <div class="modal-body">
                <form method="post" name="filterorderimei" id="filterorderimei" action="{$searchaction}">
                    <div class="form-row  input-daterange">

                        <div class="form-group  col-lg-12">
                            <input type="text" autocomplete="off" data-date-format="yyyy-mm-dd"  name="from"   placeholder="{$lang.from} {$lang.date}" id="from"  class="form-control "  />
                        </div>
                        <div class="form-group   col-lg-12">
                            <input type="text" name="to" autocomplete="off" id="to" data-date-format="yyyy-mm-dd"   placeholder="{$lang.to} {$lang.date} "   class="form-control " />
                        </div>
                    </div>
                    {if $serverservice neq 2 && $serverservice neq 1 }
                        <textarea class="form-control" name="searchvalue" placeholder="{$lang.search} {$lang.imei}"></textarea>
                    {/if}
                    <div class="mt-3">
                        <input type="submit" class="btn btn-success w-100"  value="{$lang.search}" name="searchbulk" />
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

{if $userdetails.themesettings}
    {assign var=theme value=$userdetails.themesettings|json_decode:1}
{/if}


<div id="modalverification" class="modal hide fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{$lang.verify} {$lang.orderdetails}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span> </button>
            </div>
            <div class="modal-body"> </div>
        </div>
    </div>
</div>

<div id="modalverificationbulk" class="modal hide fade" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="post">
            <div class="modal-header">
                <h5 class="modal-title">{$lang.bulk}  {$lang.verify} {$lang.order}  {$lang.reason} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span> </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="bulkids" id="buld-ids">
                <textarea placeholder="Reason" name="verifyreason" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit"  class="btn btn-primary" value="Submit">Submit</button>
            </div>
        </form>
    </div>
</div>


<div class="container history-container"><div class="page-container">

    <div class="card card-table-history">

    <div class="d-flex justify-content-end imei-title">

        <div>

            <a class="btn btn-light p-2 mb-2" id="buldverify" style="display: none" data-toggle="modal"  data-target="#modalverificationbulk" > Bulk Verify  </a>

            <a data-toggle="modal"  data-target="#myModal" style="font-style:normal" class="btn btn-light mb-2 p-2" href="#"> <i class="fal fa-search"></i> {$lang.search} </a>


            <div class="btn-group">

                <a  href="javascript:void(0)" class="btn  btn-light p-2 mb-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fal fa-file-excel"></i> {$lang.export}
                </a>
                <ul class="dropdown-menu  dropdown-menu-right    p-3">
                    <li>
                        <span class="nav-link no-wrap cursor-pointer" >
                            <a href="{$viewexportlink}">
                                {$lang.export} as view
                            </a>
                        </span>
                    </li>
                    <li>
                        <a class="nav-link no-wrap"  data-toggle="modal"  data-target="#modal-ajax" data-whatever="{$lang.export} {if $serverservice eq 2}{$lang.remote}{elseif $serverservice eq 1}{$lang.server}{else}{$lang.imei}{/if} {$lang.order}" data-size="modal-md" href="{$exportlink}?standalone=true">
                            Advance {$lang.export}
                        </a>
                    </li>
                </ul>
            </div>



            <div class="btn-group">
                <a  href="javascript:void(0)" class="btn  btn-light p-2 mb-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fal fa-eye"></i> {$lang.view}
                </a>
                <ul class="dropdown-menu   dropdown-menu-right    p-3">
                    <h6 class="text-muted text-uppercase mb-4 bottom-space">{$lang.column}</h6>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" value="1" data-name="orderid"  id="corderid" class="viewcolumn custom-control-input"  {if $theme.column.orderid}checked="checked"{/if}   />
                        <label class="custom-control-label" for="corderid">{$lang.orderid} </label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" value="1" data-name="credit"  id="dcredit" class="viewcolumn custom-control-input"  {if $theme.column.credit}checked="checked"{/if}   />
                        <label class="custom-control-label" for="dcredit">{$lang.credit} </label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" value="1" data-name="date"  id="cdate" class="viewcolumn custom-control-input"  {if $theme.column.date}checked="checked"{/if}   />
                        <label class="custom-control-label" for="cdate">{$lang.submitedon} </label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" value="1" data-name="action"  id="caction" class="viewcolumn custom-control-input"  {if $theme.column.action}checked="checked"{/if}   />
                        <label class="custom-control-label" for="caction">{$lang.action} </label>
                    </div>

                </ul>
            </div>

        </div>
    </div>
    <div> {if $notification.success}
            <div   class="alert alert-success">{$notification.success}</div>
        {elseif $notification.error}
            <div   class="alert alert-error">{$notification.error}</div>
        {/if}
        {if $withtab}
        {else}
            <form method="get" id="filterorderimei2"  action="{$statuslink}">
                <input type="hidden" name="serviceid" id="serviceids"
                       value="{$smarty.get.serviceid}"/>
                <input type="hidden" name="status" id="status" value="{$sts}"/>
                <input type="hidden" name="searchvalue" id="searchvalue" value=""/>
                {$token}
            </form>
        {/if}


            <div class="table-responsive  position-relative table-order-history">

                <table class="table  table-striped table-hover table-excel"  id="tcs-table">
                    <thead class="bg-white w-100">
                    <tr>

                        <th  class="col-orderid tcs-ignore" style="{if !$theme.column.orderid}display:none{/if}"><div>#{$lang.ID}</div> </th>
                        <th > <div>
                                <select name="status2" class="form-control  chosen " id="status2" onChange="setSubmitstatus(this);">
                                    <option value="all" selected="selected">{$lang.all}</option>
                                    <option value="available" {if 'available' eq $status} selected="selected" {/if}>{$lang.available}</option>
                                    <option value="rejected" {if 'rejected' eq $status} selected="selected" {/if}>{$lang.rejected}</option>
                                    <option value="pending" {if 'pending' eq $status} selected="selected" {/if}>{$lang.pending}</option>
                                </select>
                            </div></th>
                        <th> <div>
                                <select name="serviceid" id="service_id"  class="form-control "  onchange="setSubmitservice(this);">
                                    <option value="">{$lang.all}</option>
                                    {foreach from=$imeiservicelist key=id item=Services}
                                        <option value="{$id}" {if $id eq $smarty.get.serviceid}  selected="selected" {/if}>  {$Services}</option>
                                    {/foreach}
                                </select>
                            </div></th>
                        <th class="col-credit" style="{if !$theme.column.credit}display:none{/if}"><div> {$lang.credit}</div> </th>
                        <th class="col-date" style="{if !$theme.column.date}display:none{/if}"><div> {$lang.submited}&nbsp;{$lang.on}</div> </th>

                        <th class="text-center">
                            {if $serverservice neq 2 && $serverservice neq 1}
                                {$lang.imei}
                            {else}
                                {$lang.qnt}
                            {/if}
                        </th>
                        {if $serverservice eq 2 || $serverservice eq 1}
                            <th class="text-center">Field</th>
                        {/if}
                        <th> <div> {if $serverservice neq 2}{$lang.code} {else} {$lang.reply} {/if}</div></th>
                        {if $status neq 'rejected'}
                            <th class="col-action text-center" style="{if !$theme.column.action}display:none{/if}"><div>{$lang.action}</div></th>
                        {/if}

                    </tr>
                    </thead>
                    <tbody>

                    {foreach from=$imeiorderslist key=id item=order}

                        <tr class="status{$order.status_code}" id="orderid__{$order.encnum}">

                            <td  class="col-orderid  no-wrap" style="{if !$theme.column.orderid}display:none{/if}"   > <input type="hidden" name="orderid[{$order.encnum}]" value="{$order.encnum}" /> {if $order.actionnew} <input type="checkbox" class="verify-checkbox"  id="verify__{$order.encnum}" value="{$id}"  /> {/if}
                                <a href="{$order.seo}?standalone=true" data-target="#modal-ajax" data-toggle="modal" data-whatever="View Order #{$order.encnum}">  {if $order.encnum}{$order.encnum}{else}{$id}{/if} </a>
                            </td>
                            <td   ><div class="order-status"> {$order.status}</div> </td>
                            <td    ><div><a href="{$order.seo}?standalone=true" data-target="#modal-ajax" data-toggle="modal" data-whatever="View Order #{$order.encnum}">{$order.service} </a> </div></td>
                            <td class="col-credit" style="{if !$theme.column.credit}display:none{/if}"  ><div>{if $order.points gt 0}{$order.points} {$lang.point}{else}{$order.display_credit}{/if}</div></td>
                            <td class="col-date nowrap" style="{if !$theme.column.date}display:none{/if}"  ><div>{$order.date}</div></td>
                            <td class="position-relative">
                                {if $serverservice neq 2 && $serverservice neq 1 }
                                    {$order.imei}
                                {else}
                                    {$order.qnt}
                                {/if}
                            </td>
                            {if $serverservice eq 2 || $serverservice eq 1}
                                <td class="position-relative">
                                    {$order.field}
                                </td>
                            {/if}
                            <td class="position-relative">
                                <div class="wrap-normal replay-code">
                                    {if $order.reply eq 'Pending' or $order.reply eq 'In Process'}

                                        <div style="min-width: 200px">
                                            <div class="remaining-time" reply="{$order.reply}" orderid="{$order.encnum}" ordertime="{$order.time*1000}" times="{$order.times*1000}" averagetime="{$order.avgdeliverytime*1000}"> </div>
                                        </div>

                                    {else}
                                        {assign var="length" value=$order.reply|strlen}
                                        {if $length gt 15}
                                            <div> {$order.reply} </div>
                                        {else}
                                            {$order.reply}
                                        {/if}
                                    {/if}
                                </div>
                            </td>
                            {if $status neq 'rejected'}
                                <td  class="col-action text-center"  style="{if !$theme.column.action}display:none{/if}">
                                    {if $order.actionnew}
                                        <div>{$order.actionnew}</div>
                                    {else}
                                        <div>{if $order.action eq 'Locked'} <i class="fal fa-lock" data-toggle="tooltip" data-placement="top" title="Lock"></i> {else} {$order.action} {/if}</div>
                                    {/if}
                                </td>
                            {/if}

                        </tr>
                        {foreachelse}
                        <tr>
                            <td colspan="8" class="text-center"><div>{$lang.norecordsfound}</div></td>
                        </tr>
                    {/foreach}
                    </tbody>

                </table>
            </div>
        {if $withtab}
        {else}

            {if !$standalone}
                <div class="justify-content-between d-flex w-100 pagging">
                    <div  class="pagination">{$paginate}</div>
                    <div style="width: 250px" class="mt-4">
                        <select name="autorefresh" id="autorefresh" class="form-control no-chosen" onchange="javascript: setCookies(this.value);">
                            <option value="">{$lang.autorefresh} {$lang.disabled} </option>
                            <option value="1">1 {$lang.minutes}</option>
                            <option value="5">5 {$lang.minutes}</option>
                            <option value="10">10 {$lang.minutes}</option>
                            <option value="30">30 {$lang.minutes}</option>
                            <option value="60">1 {$lang.hour}</option>
                        </select>
                    </div>

                </div>
            {/if}


        {/if}

    </div>

    </div>

    </div></div>


{literal}
    <script>


        function detectMob() {
            return window.innerWidth <= 800;
        }

        if(!detectMob()) {
            var table = document.getElementById("tcs-table");
            var options = {
                deselectOutTableClick: false,
                enableChanging: true,
                selectIgnoreClass: false,
                ignoreThead: true
            };
            var buffer = new TableCellSelector.Buffer();
            var tcs = new TableCellSelector(table, options, buffer);
            tcs.onStartSelect = function (event, cell) {
                console.log('select cell');
            };
            tcs.enableHotkeys = true;
        }


        $(document).on("keydown", function(e){
            if (e.keyCode == 67 && (e.ctrlKey || e.metaKey)){
                console.log('copy');
                tcs.copy()
            }
        });


        $(document).ready(function(){
            var co=getCookie("UserAuto");
            $("#autorefresh").val( co ).attr('selected',true);
            if(co){
                setTimeout(function() {
                    location.href='{/literal}{$autorefreshlink}{literal}';
                }, 60000*co);
            }

            /*$('.input-daterange input[type="text"]').each(function() {
                $(this).datepicker({format: 'yyyy-mm-dd'}).on('changeDate', function(e){
                    $(this).datepicker('hide');
                });
            });*/
            $('.viewcolumn').click(function () {

                var  json = {orderid:true,credit:true,date:true,action:true,compaq:true}

                $('.viewcolumn').each(function () {
                    var column = $(this).attr('data-name');
                    if($(this).is(":checked")){
                        json[column] = true;
                        $('.col-'+column).show();
                    }
                    else{
                        json[column] = false;
                        $('.col-'+column).hide();
                    }
                });
                settheme('column',json,'{/literal}{$themelink}{literal}');
            })

            $('.verify-checkbox').click(function () {
                var flag = false;
                var ids = '';
                $('.verify-checkbox').each(function () {
                    if($(this).is(":checked")){
                        flag = true;
                        ids += $(this).val()+',';
                    }
                });
                if(flag){
                    $('#buldverify').show();
                    $('#buld-ids').val(ids);
                }
                else{
                    $('#buldverify').hide();
                }
            })

            $('.viewtable').click(function () {
                if($(this).is(":checked")) {
                    $('.table').addClass('compaq');
                }
                else{
                    $('.table').removeClass('compaq');
                }
            })

            //$('.table-excel').tableCellsSelection();

        });


        function setSubmitservice(obn){
            var ss=obn.options[obn.selectedIndex].value;
            document.getElementById('serviceids').value=ss;
            document.getElementById('filterorderimei2').submit();
        }
        function setSubmitstatus(obn){
            var ss=obn.options[obn.selectedIndex].value;
            document.getElementById('status').value=ss;
            document.getElementById('filterorderimei2').submit();
        }




    </script>


{/literal}

