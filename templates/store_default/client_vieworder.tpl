
{*{function name=orderdetail}
    <div id="modal-orderdetail" class="modal hide fade" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{$lang.order} {$lang.detail}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span> </button>
                </div>
                <div class="modal-body">

                    {foreach from=$imeiorderslist key=id item=order}
                        <div class="orderdetail" id="orderdetail_{$order.encnum}">

                            <div>
                                <b> #{if $order.encnum}{$order.encnum}{else}{$id}{/if}  </b>
                            </div>

                            <div>

                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div class="pr-2">{$order['service']}</div>
                                    <h1   class="pl-2">{$userdetails.currency.prefix}{if $order['server'] eq '1'}{($order['credit']-$order['discount'])*$order['qnt']}{else}{$order['credit']-$order['discount']}{/if}</h1>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        {if $order['server'] eq '1'}
                                            <span class="text-muted font-normal"> Qty </span>  <h1> {$order['qnt']} </h1>
                                        {/if}
                                    </div>
                                </div>


                                <div class="row  mt-3">


                                    <div class="form-group col-lg-4">
                                        <span class="text-muted font-normal"> {if $smarty.get.service neq 2} {$lang.imei} {else} {$lang.server} {/if} </span>  <h3> {$order['imei']}</h3>
                                        <span> {$order['status']} </span>
                                    </div>

                                    <div class="form-group col-lg-8">


                                        {if $order['status_code'] eq '4' || $order['status'] eq '3'}
                                            <div class="text-muted font-normal d-flex justify-content-between">
                                                <span>{$lang.code}  </span>
                                                <span class="p-1 cursor-pointer"  data-toggle="tooltip" data-placement="top" title="Copy to clipboard" onclick="copy('#replycode{$id}')"> <i class="fa fa-copy"></i> Copy </span>
                                            </div>
                                            <div  class="mx-height border   lg-border rounded p-3 cursor-pointer"  data-toggle="tooltip" data-placement="top" title="Copy to clipboard" id="replycode{$id}" onclick="copy('#replycode{$id}')"> <table><tr><td> <p> {if $order['reply']} {$order['reply']}  {/if} </p></td></tr></table></div>

                                            {if $order['apirefid']}
                                                <span class="text-muted font-normal">  {$lang.api} Reference ID </span> <br />  {$order['apirefid']}
                                            {/if}
                                        {else}
                                            <div class="text-muted font-normal d-flex justify-content-between">
                                                <span>{$lang.code} </span>
                                            </div>
                                            <div  class="border bg-light text-center w-100 lg-border rounded p-5 text-muted">
                                                <table><tr><td> <p>{$order['reply']}</p></td></tr></table>
                                            </div>
                                        {/if}

                                    </div>

                                </div>



                            </div>


                            {if $order['model'] || $order['provider'] || $order['mep'] || $order['kbh'] || $order['type'] || $order['locks'] || $order['pin'] || $order['prd'] || $order['sn'] || $order['secro'] || $order['reference'] || $order['note'] || $order['comments'] || $order['custom']}

                                <a class="btn mb-4 bottom-space"  onclick="getmoreorderdetails('#moredetail_{$order.encnum}','{$order.seo}')">
                                    More  <i class="fal fa-chevron-down"></i>
                                </a>

                                <div class="collapse  " id="moredetail_{$order.encnum}">
                                    <div class=" mt-3 mb-4 bottom-space">
                                        <table class="table w-100   table-hover">
                                            {if $order['model']}
                                                <tr><td>{$lang.model}</td><td>:</td><td>  {$order['model']}  </td></tr>
                                            {/if}
                                            {if $order['provider']}
                                                <tr><td>{$lang.provider}</td><td>:</td><td>  {$order['providercountry']} / {$provider}</td></tr>
                                            {/if}
                                            {if $order['mep']}
                                                <tr><td>{$lang.mep}</td><td>:</td><td>  {$order['mep']}</td></tr>
                                            {/if}
                                            {if $order['kbh']}
                                                <tr><td>{$lang.kbh}</td><td>:</td><td>  {$order['kbh']} </td></tr>
                                            {/if}
                                            {if $order.type}
                                                <tr><td>{$lang.type}</td><td>:</td><td>  {$order.type}</td></tr>
                                            {/if}
                                            {if $order.locks}
                                                <tr><td>{$lang.locks} </td><td>:</td><td>   {$order.locks}</td></tr>
                                            {/if}
                                            {if $order.pin}
                                                <tr><td>{$lang.pin}</td><td>:</td><td>  {$order.pin} </td></tr>
                                            {/if}
                                            {if $order.prd}
                                                <tr><td>{$lang.prd}</td><td>:</td><td>  {$order.prd} </td></tr>
                                            {/if}
                                            {if $order.sn}
                                                <tr><td>SN</td><td>:</td><td>  {$order.sn} </td></tr>
                                            {/if}
                                            {if $order.secro}
                                                <tr><td>SecRO</td><td>:</td><td>  {$order.secro} </td></tr>
                                            {/if}
                                            {if $order.reference}
                                                <tr><td>{$lang.reference}</td><td>:</td><td>   {$order.reference}</td></tr>
                                            {/if}
                                            {if $order.note}
                                                <tr><td>{$lang.note} </td><td>:</td><td>  {$order.note}</td></tr>
                                            {/if}
                                            {if $order.comments}
                                                <tr><td>{$lang.comments} </td><td>:</td><td>  {$order.comments}</td></tr>
                                            {/if}
                                            {if $order.custom}
                                                {foreach from=$order.custom item=csst}
                                                    <tr>
                                                        <td>{$csst.name} </td>
                                                        <td>:</td>
                                                        <td>{$csst.value}</td>
                                                    </tr>
                                                {/foreach}
                                            {/if}
                                        </table>
                                    </div>
                                </div>
                            {/if}
                            <br/><br/><br/>



                            <div class="p-3 bg-light">
                                <div class="row">

                                    <div class="form-group col-lg-4">
                                        <span class="text-muted font-normal"> {$lang.submited} {$lang.on} </span> <br /> {$order.time|date_format:"%Y/%m/%d  %H:%M:%S"}
                                    </div>

                                    {if $order.reply_time}

                                        <div class="form-group col-lg-4">
                                            <span class="text-muted font-normal"> {$lang.replyon} </span> <br /> <span>{$order.reply_times|date_format:"%Y/%m/%d  %H:%M:%S"} </span>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <span class="text-muted font-normal"> Replied in  </span> <br /> <div> <span  id="replytime{$id}"></span>   </div>
                                        </div>

                                        <script>
                                            msToTime({$order.time*1000},{$order.reply_times*1000},'#replytime{$id}');
                                        </script>

                                    {/if}
                                </div>
                            </div>
                        </div>
                    {/foreach}

                </div>
            </div>
        </div>
    </div>

{/function}*}


{foreach from=$datas key=id item=order}

    <div>

        <div>

            <div class="d-flex w-100 justify-content-between align-items-center">
                <div class="pr-2"> <h5> {$order['service']} </h5></div>
                <h1   class="pl-2">{$userdetails.currency.prefix}{if $order['server'] eq '1'}{($order['credit']-$order['discount'])*$order['qnt']}{else}{$order['credit']-$order['discount']}{/if}</h1>
            </div>

            <div class="row">
                <div class="form-group col-lg-4">
                    {if $order['server'] eq '1'}
                        <span class="text-muted font-normal"> Qty </span>  <h1> {$order['qnt']} </h1>
                    {/if}
                </div>
            </div>


            <div class="row  mt-3">


                <div class="form-group col-lg-6">
          
                    <span class="text-muted font-normal"> {if $order['server'] neq 1} {$lang.imei} {else} {$lang.server} {/if} </span>  <h3> {$order['imei']}</h3>
                    <span> {$order['status']} </span>
                </div>

                <div class="form-group col-lg-6">


                    {if $order['status_code'] eq '4' || $order['status'] eq '3'}
                        <div class="text-muted font-normal d-flex justify-content-between">
                            <span>{$lang.code}  </span>
                            <span class="p-1 cursor-pointer"  data-toggle="tooltip" data-placement="top" title="Copy to clipboard" onclick="copy('#replycode{$id}')"> <i class="fa fa-copy"></i> Copy </span>
                        </div>
                        <div  class="mx-height border   lg-border rounded p-3 cursor-pointer"  data-toggle="tooltip" data-placement="top" title="Copy to clipboard" id="replycode{$id}" onclick="copy('#replycode{$id}')"> <table><tr><td> <p> {if $order['reply']} {$order['reply']}  {/if} </p></td></tr></table></div>

                        {if $order['apirefid']}
                            <span class="text-muted font-normal">  {$lang.api} Reference ID </span> <br />  {$order['apirefid']}
                        {/if}
                    {else}
                        <div class="text-muted font-normal d-flex justify-content-between">
                            <span>{$lang.code} </span>
                        </div>
                        <div  class="border bg-light text-center w-100 lg-border rounded p-3 text-muted">
                            <table><tr><td> <p>{$order['reply']}</p></td></tr></table>
                        </div>
                    {/if}

                </div>

            </div>



        </div>


            <div >
                <div class=" mt-3 mb-4 bottom-space">
                    <table class="table w-100   table-hover">
                        {if $order['model']}
                            <tr><td>{$lang.model}</td><td>:</td><td>  {$order['model']}  </td></tr>
                        {/if}
                        {if $order['provider']}
                            <tr><td>{$lang.provider}</td><td>:</td><td>  {$order['providercountry']} / {$provider}</td></tr>
                        {/if}
                        {if $order['mep']}
                            <tr><td>{$lang.mep}</td><td>:</td><td>  {$order['mep']}</td></tr>
                        {/if}
                        {if $order['kbh']}
                            <tr><td>{$lang.kbh}</td><td>:</td><td>  {$order['kbh']} </td></tr>
                        {/if}
                        {if $order.type}
                            <tr><td>{$lang.type}</td><td>:</td><td>  {$order.type}</td></tr>
                        {/if}
                        {if $order.locks}
                            <tr><td>{$lang.locks} </td><td>:</td><td>   {$order.locks}</td></tr>
                        {/if}
                        {if $order.pin}
                            <tr><td>{$lang.pin}</td><td>:</td><td>  {$order.pin} </td></tr>
                        {/if}
                        {if $order.prd}
                            <tr><td>{$lang.prd}</td><td>:</td><td>  {$order.prd} </td></tr>
                        {/if}
                        {if $order.sn}
                            <tr><td>SN</td><td>:</td><td>  {$order.sn} </td></tr>
                        {/if}
                        {if $order.secro}
                            <tr><td>SecRO</td><td>:</td><td>  {$order.secro} </td></tr>
                        {/if}
                        {if $order.reference}
                            <tr><td>{$lang.reference}</td><td>:</td><td>   {$order.reference}</td></tr>
                        {/if}
                        {if $order.note}
                            <tr><td>{$lang.note} </td><td>:</td><td>  {$order.note}</td></tr>
                        {/if}
                        {if $order.comments}
                            <tr><td>{$lang.comments} </td><td>:</td><td>  {$order.comments}</td></tr>
                        {/if}
                        {if $order.custom}
                            {foreach from=$order.custom item=csst}
                                <tr>
                                    <td>{$csst.name} </td>
                                    <td>:</td>
                                    <td>{$csst.value}</td>
                                </tr>
                            {/foreach}
                        {/if}
                    </table>
                </div>
            </div>

        <br/><br/><br/>



        <div class="p-3 rounded bg-light">
            <div class="row">

                <div class="form-group col-lg-4">
                    <span class="text-muted font-normal"> {$lang.submited} {$lang.on} </span> <br /> {$order.time|date_format:"%Y/%m/%d  %H:%M:%S"}
                </div>

                {if $order.reply_time}

                    <div class="form-group col-lg-4">
                        <span class="text-muted font-normal"> {$lang.replyon} </span> <br /> <span>{$order.reply_times|date_format:"%Y/%m/%d  %H:%M:%S"} </span>
                    </div>
                    <div class="form-group col-lg-4">
                        <span class="text-muted font-normal"> Replied in  </span> <br /> <div> <span  id="replytime{$id}"></span>   </div>
                    </div>

                    <script>
                        msToTime({$order.time*1000},{$order.reply_times*1000},'#replytime{$id}');
                    </script>

                {/if}
            </div>
        </div>
    </div>
{/foreach}






