


    {function name=orderdetail}

        <div id="modal-orderdetail" class="modal hide fade" tabindex="-1">
            <div class="modal-dialog  modal-dialog-centered  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Order Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span> </button>
                    </div>
                    <div class="modal-body">

                        {foreach from=$fileorderslist key=id item=order}


                            <div class="orderdetail" id="orderdetail_{$id}">


                                <div>
                                    <b> #{$order.order_id} </b>
                                </div>


                                <div>


                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="pr-2">{$order.service}</div>
                                        <h1 style="font-size: 3rem" class="pl-2">{$userdetails.currency.prefix}{if $order.server eq '1'}{$order.credit*$order.qnt}{else}{$order.credit}{/if}</h1>
                                    </div>


                                    <div class="row  mt-3">


                                        <div class="form-group col-lg-6">
                                            <span class="text-muted font-normal">   {$lang.file}  </span>  <h3 title="{$order.file}"> {$order.file}</h3>
                                            <span> {$order['status']} </span>
                                        </div>

                                        <div class="form-group col-lg-6">


                                            {if $order['status_code'] eq '4' || $order['status'] eq '3'}
                                                <div class="text-muted font-normal d-flex justify-content-between">
                                                    <span>{$lang.code}  </span>
                                                    <span class="p-1 cursor-pointer"  data-toggle="tooltip" data-placement="top" title="Copy to clipboard" onclick="copy('#replycode{$id}')"> <i class="fa fa-copy"></i> Copy </span>
                                                </div>
                                                <div  class="mx-height border   lg-border rounded p-3 cursor-pointer"  data-toggle="tooltip" data-placement="top" title="Copy to clipboard" id="replycode{$id}" onclick="copy('#replycode{$id}')"> <p>{if $order['reply']} {$order['reply']}  {/if}</p> </div>

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

                                <table class="table table-borderd table-striped table-hover w-auto table-padding-2 border-top pt-3 mt-3">
                                    {foreach from=$order.filedtl key=id item=dtl}
                                        <tr>
                                            <td>{$dtl.name}</td>
                                            <td>:</td>
                                            <td>{$dtl.value}</td>
                                        </tr>
                                    {/foreach}

                                    {if $order.comments}
                                        <tr><td>{$lang.comments}</td><td>:</td><td>  {$order.comments}  </td></tr>
                                    {/if}

                                </table>

                                <div class="p-3 bg-light">
                                    <div class="row">
                                        <div class="form-group col-lg-4">
                                            <span class="text-muted font-normal"> {$lang.submited} {$lang.on} </span> <br /> {$order.time|date_format:"%Y/%m/%d  %H:%M:%S"}
                                        </div>

                                        {if $order.reply_time}
                                            <div class="form-group col-lg-4">
                                                <span class="text-muted font-normal"> {$lang.replyon} </span> <br /> <span>{$order.reply_time|date_format:"%Y/%m/%d  %H:%M:%S"} </span>
                                            </div>


                                            <div class="form-group col-lg-4">
                                                <span class="text-muted font-normal"> Replied in  </span> <br /> <div> <span  id="replytime{$id}"></span>   </div>
                                            </div>

                                            <script>
                                                msToTime({$order.time*1000},{$order.reply_time*1000},'#replytime{$id}');
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

    {/function}

