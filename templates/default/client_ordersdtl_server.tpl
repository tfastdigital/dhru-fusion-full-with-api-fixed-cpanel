{include file="templates/default/client_vieworderserver.tpl"}


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


<div class="modal hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Search Server Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span> </button>
            </div>
            <div class="modal-body">
                <form method="post" name="filterorderfile" id="filterorderfile" >
                    <div class="form-row  input-daterange">

                        <div class="form-group  col-lg-6">
                            <input type="text" autocomplete="off"  name="from"   placeholder="From Date" id="from"  class="form-control "  />
                        </div>
                        <div class="form-group   col-lg-6">
                            <input type="text" name="to" autocomplete="off" id="to"    placeholder="To Date"   class="form-control " />
                        </div>
                    </div>
                    <div class="mt-3">
                        <input type="submit" class="btn btn-success"  value="Search" name="searchbulk" />
                    </div>
                </form>



            </div>
        </div>
    </div>
</div>

{assign var=theme value=$userdetails.themesettings|json_decode:1}



<div class="container"><div class="page-container">
    <div class="d-flex justify-content-end imei-title">

        <div>

            <a data-toggle="modal"  data-target="#myModal" style="font-style:normal" class="btn  btn-light mb-2 p-2" href="#"> <i class="fal fa-search"></i> Search </a>

            <a class="btn  btn-light p-2 mb-2"  style="font-style:normal"  data-toggle="modal" data-whatever="Export Server Order" data-target="#modal-ajax" data-size="modal-md" href="export?standalone=true&service=3"> <i class="fal fa-file-excel"></i> Export</a>

            <div class="btn-group">
                <a  href="javascript:void(0)" class="btn  btn-light p-2 mb-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fal fa-eye"></i>  View
                </a>
                <ul class="dropdown-menu shadow-sm dropdown-menu-right    p-3">
                    <h6 class="text-muted text-uppercase mb-4 bottom-space">Column</h6>
                    <li class="checkbox"> <label> <input type="checkbox" value="1" data-name="orderid"  class="viewcolumn"  {if $theme.column.orderid}checked="checked"{/if}   />  Order ID  <i class="helper" style="top:5px"></i> </label> </li>
                    <li class="checkbox"> <label> <input type="checkbox" value="1" data-name="credit"   class="viewcolumn"  {if $theme.column.credit}checked="checked"{/if}    />  Credit <i class="helper" style="top:5px"></i> </label> </li>
                    <li class="checkbox"> <label> <input type="checkbox" value="1" data-name="date"   class="viewcolumn"   {if $theme.column.date}checked="checked"{/if}   />  Submited On <i class="helper" style="top:5px"></i> </label> </li>
                    <li class="checkbox"> <label> <input type="checkbox" value="1" data-name="action"  class="viewcolumn"  {if $theme.column.action}checked="checked"{/if}    />  Action <i class="helper" style="top:5px"></i> </label> </li>
                    <h6 class="dropdown-divider"></h6>
                    <h6 class="text-muted text-uppercase  mb-4 bottom-space">Table</h6>
                    <li class="checkbox"> <label> <input type="checkbox" value="1" data-name="compaq"  class="viewcolumn viewtable"  {if $theme.column.compaq}checked="checked"{/if}    />  Compaq View <i class="helper" style="top:5px"></i> </label> </li>
                </ul>
            </div>


        </div>
    </div>


  <div class="tab-content"> {if $notification.success}
    <div   class="alert alert-success">{$notification.success}</div>
    {elseif $notification.error}
    <div    class="alert alert-danger">{$notification.error}</div>
    {/if}
    <form method="post" id="filterorderserver2">
      <input type="hidden" name="serviceid" id="serviceids" value="{$smarty.post.serviceid}"/>
      <input type="hidden" name="status" id="status" value="{$sts}"/>
      {$token}
    </form>
    <div class="table-responsive position-relative {if $serverorderslist} table-fixed-header {/if}">
        <table class="table table-bordered {if $theme.column.compaq} compaq {/if}  table-striped table-hover" id="tcs-table">
        <thead>
          <tr>

            <th  class="col-orderid tcs-ignore" style="{if !$theme.column.orderid}display:none{/if}"><div>#{$lang.ID}</div></th>
            <th> <div>
                <select name="status2" id="status2"  class="form-control chosen "  onchange="setSubmitstatus(this);">
                  <option value="all">{$lang.all}</option>
                  <option value="available" {if 'available' eq $smarty.post.status} selected="selected" {/if}>{$lang.available}</option>
                  <option value="rejected" {if 'rejected' eq $smarty.post.status} selected="selected" {/if}>{$lang.rejected}</option>
                  <option value="pending" {if 'pending' eq $smarty.post.status} selected="selected" {/if}>{$lang.pending}</option>
                </select>
              </div>
            </th>
            <th class="w-100">
                <div>
                <select name="serviceid" id="service_id"  class="form-control " onchange="setSubmitservice(this);">
                    <option value="">{$lang.all}</option>
                    {foreach from=$serverservicelist key=id item=Services}
                      <option   value="{$id}" value="{$id}" {if $id eq $smarty.post.serviceid} selected="selected" {/if}>
                        {$Services}
                      </option>
                    {/foreach}
                </select>
                </div>
            </th>
            <th  class="col-credit" style="{if !$theme.column.credit}display:none{/if}"><div> {$lang.credit}</div> </th>
            <th  class="col-date" style="{if !$theme.column.date}display:none{/if}"><div> {$lang.submited} {$lang.on}</div> </th>
            <th><div class="wrap-normal">{if $status neq 'pending'}
              {$lang.reply}
              {/if}</div></th>
            <th  class="col-action"   style="{if !$theme.column.action}display:none{/if}"><div>{if $status neq 'rejected'}{$lang.action}{/if}</div></th>

          </tr>
          </thead>
		 <tbody>
        {foreach from=$serverorderslist key=id item=order}
        <tr id="orderid__{$id}">

          <td class="col-orderid cursor-pointer"  style="{if !$theme.column.orderid}display:none{/if}"  onclick="vieworderdetail({$id})"><div>{$id}</div></td>
          <td class=" cursor-pointer"  onclick="vieworderdetail({$id})"><div style="text-align:left">{$order.status}</div></td>
          <td class=" cursor-pointer"  onclick="vieworderdetail({$id})"><div>{$order.service}</div></td>
          <td  class="col-credit  cursor-pointer"  style="{if !$theme.column.credit}display:none{/if}"  onclick="vieworderdetail({$id})"><div>{$order.credit-$order.discount}</div></td>
          <td  class="col-date  cursor-pointer"  style="{if !$theme.column.date}display:none{/if}"  onclick="vieworderdetail({$id})"><div>{$order.date}</div></td>
          <td  onclick="vieworderdetail({$id})"><div>{if $status neq 'pending'}{$order.reply}{/if}</div></td>



          {if $status neq 'rejected'}
                <td class="col-action"  style="{if !$theme.column.action}display:none{/if}"><div>{$order.action}</div></td>
          {/if}

        </tr>
        {foreachelse}
        <tr>
          <td  colspan="7"><div>{$lang.norecordsfound}</div></td>
        </tr>
        {/foreach}
			 </tbody>
      </table>
    </div>

	 <div class="justify-content-between d-flex w-100 pagging">
    <div  class="pagination">{$paginate}</div>
    <div >
      <select name="autorefresh" id="autorefresh" class="form-control " onchange="javascript: setCookies(this.value);">
        <option value="">{$lang.autorefresh} Disabled</option>
        <option value="5">5 Miniute</option>
        <option value="10">10 Miniute</option>
        <option value="30">30 Miniute</option>
        <option value="60">1 Hour</option>
      </select>
    </div>
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
                    location.href='orders.php?action=server&status=all';
                }, 60000*co);
            }
        });



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

            settheme('column',json);
        });

        $('.viewtable').click(function () {
            if($(this).is(":checked")) {
                $('.table').addClass('compaq');
            }
            else{
                $('.table').removeClass('compaq');
            }
        })

        function setSubmitservice(obn){
            var ss=obn.options[obn.selectedIndex].value;
            document.getElementById('serviceids').value=ss;
            document.getElementById('filterorderserver2').submit();
        }
        function setSubmitstatus(obn){
            var ss=obn.options[obn.selectedIndex].value;
            document.getElementById('status').value=ss;
            document.getElementById('filterorderserver2').submit();
        }
    </script>
{/literal}

{call name=orderdetail}
